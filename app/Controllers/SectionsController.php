<?php

namespace App\Controllers;
use App\Models\PublicationsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class SectionsController extends BaseController
{
    protected array $page;
    protected int $countInPage= 20;
    protected PublicationsModel $PublicationsModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);
        $this->PublicationsModel= model(PublicationsModel::class);
        return true;
    }
    public function adminList(): string
    {
        if($this->model->hasAuth() === false)
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $page['includes']=(object)[
            'js'=>["/js/admin/change-visible.js"],
            'css'=>["/css/admin/sections.css"],
        ];
        $page["title"]= "Control Panel: Разделы";
        $page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);

        if($this->session->has("message"))
            $page['message']= $this->session->getFlashdata("message");

        $filter= [];
        if($this->session->has("sectionsFilter"))
            $filter= $this->session->get("sectionsFilter");

        $list= $this->model->db->table("sections");

        if(!empty($filter))
            $list= $list->like($filter)->orWhere(["parent!="=>0]);

        $list= $list->orderBy("parent")->orderBy("sort")->orderBy("name");
        $page['list']= $list->get()->getResult();
        $page['list']= $this->model->convertTree2List($page['list']);

        $page['filter']= view("admin/Sections/Filter",["filter"=>(object)$filter]);

        $page['pageContent']= view("admin/Sections/List",$page);
        return view("admin/template/page",$page);
    }

    public function form($action= "add",$id= false):string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        if($action!=="add" && $id===false) return redirect()->to(base_url("/admin/sections/"));

        $page['data']["title"] = ($action!=="edit")?"Раздел: Создать":"Раздел: Изменить";
        $page["title"]= "Control Panel: ".$page['data']["title"];
        $page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);
        if($this->session->has("message"))
            $page['data']['message']= $this->session->getFlashdata("message");

        $page['data']['includes']=(object)[
            'js'=>[],
            'css'=>[],
        ];

        $page['data']["sections"]= $this->model->db
            ->table("sections")
            ->where(['parent'=>0])
            ->orderBy("name")
            ->get()
            ->getResult();

        $page['data']['action']= $action;
        $page['data']['id']= $id;


        if($this->session->has("form")){
            $page['data']['form']= (object)$this->session->getFlashdata("form");
            $page['data']['validator']= $this->session->getFlashdata("validator");
            $page['data']['errors'] = $this->model->getFormErrors($page['data']['validator']);
        }
        elseif($action=="edit")
            $page['data']['form']= $this->model->db->table("sections")->where(['id'=>$id])->get()->getFirstRow();

        $page['pageContent']= view("admin/Sections/Form",$page['data']);
        return view(ADMIN."/template/page",$page);
    }

    public function formProcessing():string|RedirectResponse
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $form= (object)$this->request->getVar('form');
        $rules= [
            'form.name' => 'required|is_unique[sections.name]',
        ];
        if($form->action=="edit") $rules['form.name']= "required|is_unique[sections.name, id, ".$form->id."]";
        $messages= [
            'form.name'=>[
                "required"=>"required",
                "is_unique"=>"Раздел с названием уже существует: $form->name"
            ],
        ];

        $inputs = $this->validate($rules,$messages);

        if (!$inputs) {
            $form= json_decode(json_encode($form), FALSE);
            $this->session->setFlashdata("form",$form);
            $this->session->setFlashdata("validator",$this->validator);
            if($form->action=="add")
                return redirect()->to(base_url("/admin/sections/add"));
            else
                return redirect()->to(base_url("/admin/sections/edit/".$form->id));
        }

        $sql=[
            "name"=>$form->name,
            "description"=>$form->description,
            "parent"=>$form->parent,
        ];

        if($form->action=="add"){
            $this->model->db->table("sections")->insert($sql);
            $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Раздел добавлена: #".$this->db->insertID().": $form->name"]);
        }
        elseif($form->action=="edit"){
            $current= $this->db->table("sections")->where(['id'=>$form->id])->get()->getFirstRow();
            if(
                $current->parent!=$form->parent
                and $form->parent!=0
                and $this->db->table("sections")->where(['parent'=>$form->id])->get()->getNumRows()
            ){
                $this->session->setFlashdata("message",(object)["type"=>"error","class"=>"callout-error","message"=>"Раздел не может стать дочерним т.к. имеет подразделы"]);
                return redirect()->to(base_url("/admin/sections/edit/".$form->id));
            }

            $this->model->db->table("sections")->update($sql,["id"=>$form->id]);
            $this->session->setFlashdata("message",(object)[
                "type"=>"success",
                "class"=>"callout-success",
                "message"=>"Раздел изменен: #: $form->id: ".($current->name!=$form->name?" $current->name -> ":"")." $form->name",
            ]);
        }

        return redirect()->to(base_url("/admin/sections/"));
    }

    public function delete($id=false):RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $current= $this->db->table("sections")->where(['id'=>$id])->get()->getFirstRow();

        if($current->cnt)
            $this->session->setFlashdata("message",(object)["type"=>"error","class"=>"callout-error","message"=>"Раздел не может быть удален, т.к. содержит публикации.<br>Раздел #$current->id: $current->name"]);
        elseif($this->db->table("sections")->where(['parent'=>$current->id])->get()->getNumRows())
            $this->session->setFlashdata("message",(object)["type"=>"error","class"=>"callout-error","message"=>"Раздел не может быть удален, т.к. содержит подразделы.<br>Раздел #$current->id: $current->name"]);
        else{
            $this->model->db->table("sections")->delete(["id"=>$id]);
            $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Раздел удален: #$current->id $current->name"]);
        }

        return redirect()->to(base_url("/admin/sections/"));
    }
    public function setFilter():RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $filter= $this->request->getVar('filter')??[];

        $this->session->set("sectionsFilter",$filter);
        return redirect()->to(base_url("/admin/sections/"));
    }

    public function changeVisible():bool
    {
        $form= (object)$this->request->getVar();
        if(empty($form->id) or !isset($form->display)) return false;
        $this->model->db->table("sections")->update(["display"=>$form->display],["id"=>$form->id]);
        return true;
    }

    public function showSection($sid= false, $currenPage= 1):string|RedirectResponse
    {
        $this->page['includes']=(object)[
            'js'=>[],
            'css'=>[
                "/css/public/sections.css",
                "/css/public/publications.css",
            ],
        ];

        $this->page['meta']= (object)[
            "title"=> "Control Panel: Разделы"
        ];

        /* get section */
        $section= $this->db
            ->table("sections")
            ->where(['id'=>$sid])
            ->get()
            ->getFirstRow();

        if(empty($section)) return redirect()->to(base_url("/"));

        /* get parent */
        $section->parent= $this->db
            ->table("sections")
            ->where(['id'=>$section->parent])
            ->get()
            ->getFirstRow();

        /* get subsections */
        $section->sub= $this->db
            ->table("sections")
            ->where(['parent'=>$section->id])
            ->get()
            ->getResult();

        $this->page['section']= $section;

        /* paginator */
        $count=  $this->db
            ->table("publications")
            ->where("JSON_CONTAINS(sections, '".$sid."', '$')")
            ->get()
            ->getNumRows();

        $maxPages= ceil($count / $this->countInPage);

        if($maxPages<$currenPage) $currenPage = $maxPages;
        if($currenPage<1) $currenPage = 1;
        if($maxPages>1)
            $paginator= view("admin/template/paginator",[
                "maxPages"=>$maxPages,
                "currentPage"=>$currenPage,
                "baseLink"=>base_url("/section/$sid/page-"),
            ]);

        /* get Publications */
        $publications= $this->db
            ->table("publications")
            ->where("JSON_CONTAINS(sections, '".$sid."', '$')")
            ->limit($this->countInPage,($currenPage-1)*$this->countInPage)
            ->orderBy("date","desc")
            ->orderBy("name","asc")
            ->get()
            ->getResult();

        $this->PublicationsModel->prepareToShow($publications);

        $this->page['sort']= view("public/Templates/Sort",[]);

        $this->page['subsections']= view("public/Sections/List",[
            "title"=>"Подразделы",
            "list"=>$section->sub,
        ]);

        $this->page['publication']= view("public/Publications/List",[
            "list"=>$publications,
            "paginator"=>$paginator??"",
        ]);


       $this->page['pageContent']= view("public/Sections/Simple",$this->page);

        return  view("public/page",$this->page);
    }
}