<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\PublicationsModel;

class PublicationsController extends BaseController
{
    protected array $page;
    protected int $countInPage = 20;

    protected array $json= [
        "collections"=>false,
        "sections"=>false,
        "authors"=>", ",
        "tags"=>false,
    ];

    protected PublicationsModel $PublicationsModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);
        $this->page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);
        $this->PublicationsModel= model(PublicationsModel::class);
        return true;
    }
    public function adminList($page= 1): string
    {
        if($this->model->hasAuth() === false)
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $this->page['includes']=(object)[
            'js'=>["/js/admin/change-visible.js"],
            'css'=>["/css/admin/publications.css"],
        ];
        $this->page["title"]= "Control Panel: Публикации";

        if($this->session->has("message"))
            $this->page['message']= $this->session->getFlashdata("message");

        $filter= [];
        if($this->session->has("publicationsFilter"))
            $filter= $this->session->get("publicationsFilter");

        $count=  $this->db
            ->table("publications")
            ->like($filter)
            ->get()->getNumRows();

        $maxPages= ceil($count / $this->countInPage);

        if($maxPages<$page) $page = $maxPages;
        if($page<1) $page = 1;

        $this->page['paginator']= view("admin/template/paginator",[
            "maxPages"=>$maxPages,
            "currentPage"=>$page,
            "baseLink"=>base_url("/admin/publications/page-"),
        ]);

        $this->page['list']= $this->db
            ->table("publications")
            ->like($filter)
            ->limit($this->countInPage,$this->countInPage*($page-1))
            ->get()->getResult();

        foreach ($this->page['list'] as $key=>$publication){
            foreach ($this->json as $filed=>$separator)
                if(!empty($publication->{$filed})){
                    $publication->{$filed}= json_decode($publication->{$filed});
                    if($separator !== false)
                        if(is_array($publication->{$filed}))
                            $publication->{$filed}= implode($separator,$publication->{$filed});
                }
            $this->page['list'][$key]= $publication;
        }

        /** get sections:  tree->list  */
        $this->page['data']['sections']= $this->model->convertTree2List(
            $this->db->table("sections")
                ->orderBy("parent")->orderBy("name")
                ->get()->getResult()
        );

        /** get sources:  list  */
        $this->page['data']['sources']=
            $this->db->table("sources")
                ->orderBy("title")
                ->get()->getResult();

        /** get collections:  list  */
        $this->page['data']['collections']=
            $this->db->table("collections")
                ->orderBy("title")
                ->get()->getResult();


        $this->page['filter']= view("admin/Publications/Filter",["filter"=>(object)$filter]);

        $this->page['pageContent']= view("admin/Publications/List",$this->page);
        return view("admin/template/page",$this->page);
    }
    public function form($action= "add",$id= false):string|RedirectResponse
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        if($action!=="add" && $id===false) return redirect()->to(base_url("/admin/publications/"));

        $this->page['data']["title"] = ($action!=="edit")?"Публикация: Создать":"Публикация: Изменить";
        $this->page["title"]= $this->page['data']["title"];
        if($this->session->has("message"))
            $this->page['data']['message']= $this->session->getFlashdata("message");

        $this->page['data']['includes']=(object)[
            'js'=>[],
            'css'=>[],
        ];

        $this->page['data']['action']= $action;
        $this->page['data']['id']= $id;

        /** get sections:  tree->list  */
        $this->page['data']['sections']= $this->model->convertTree2List(
            $this->db->table("sections")
                ->orderBy("parent")->orderBy("name")
                ->get()->getResult()
        );

        /** get sources:  list  */
        $this->page['data']['sources']=
            $this->db->table("sources")
                ->orderBy("title")
                ->get()->getResult();

        /** get collections:  list  */
        $this->page['data']['collections']=
            $this->db->table("collections")
                ->orderBy("title")
                ->get()->getResult();


        if($this->session->has("form")){
            $this->page['data']['form']= $this->session->getFlashdata("form");
            if(!empty($this->page['data']['form']->data->tags))
                $this->page['data']['form']->data->tags= implode(",",json_decode($this->page['data']['form']->data->tags));

            if(!empty($this->page['data']['form']->data->collections))
                $this->page['data']['form']->data->collections= json_decode($this->page['data']['form']->data->collections);

            $this->page['data']['validator']= $this->session->getFlashdata("validator");
            $this->page['data']['validatorErrors']= $this->session->getFlashdata("validatorErrors");
        }
        elseif($action=="edit"){
            $publication= $this->db->table("publications")->where(['id'=>$id])->get()->getFirstRow();

            if(!empty($publication->tags))
                $publication->tags= implode(", ",json_decode($publication->tags));

            if(!empty($publication->authors))
                $publication->authors= implode(", ",json_decode($publication->authors));

            $publication->collections= json_decode($publication->collections);

            $this->page['data']['form']= (object)[
                "data"=> $publication,
            ];
        }

        $this->page['data']['ckeditor']= view("admin/template/CKEditor");
        $this->page['pageContent']= view("admin/Publications/Form",$this->page['data']);
        return view(ADMIN."/template/page",$this->page);
    }

    public function formProcessing():string|RedirectResponse
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);
        $form= (object)$this->request->getVar('form');
        $id= $this->request->getVar('id');

        $rules= [
            'form.data.name' => 'required',
            'form.data.authors' => 'required',
            'form.data.section' => 'required',
            'form.data.source' => 'required',
        ];
        $messages= [
            'form.data.name'=>[
                "required"=>"Укажите название",
            ],
            'form.data.authors'=>[
                "required"=>"Укажите автора",
            ],
            'form.data.section'=>[
                "required"=>"Укажите раздел",
            ],
            'form.data.source'=>[
                "required"=>"Укажите источник",
            ],
        ];

        $valid = $this->validate($rules,$messages);


        $form->data= (object)$form->data;

        /* обработка коллекций */
        if(!empty($form->data->collections)){
            $collections= $form->data->collections;
            $form->data->collections= json_encode($form->data->collections);
        }

        /* обработка авторов */
        if(!empty($form->data->authors))
            $form->data->authors=
                json_encode(
                    array_map('trim',
                        explode(",",$form->data->authors)
                    ),
                    JSON_UNESCAPED_UNICODE
                );

        /* обработка тегов */
        if(!empty($form->data->tags))
            $form->data->tags=
                json_encode(
                    array_map('trim',
                        explode(",",$form->data->tags)
                    ),
                    JSON_UNESCAPED_UNICODE
                );

        /* обработка разделов */
        $section= $this->db->table("sections")->where(['id'=>$form->data->section])->get()->getFirstRow();
        if($section->parent)
            $form->data->sections[]= $section->parent;
        $form->data->sections[]= $section->id;

        $sections= $form->data->sections;

        $form->data->sections= json_encode($form->data->sections);

        /* обработка pdf файла */
        $file = $this->request->getFile('pdf');
        if($file->isValid() && !$file->hasMoved()){
            if(file_exists(WRITEPATH . "uploads/publications/tmp.pdf"))
                unlink(WRITEPATH . "uploads/publications/tmp.pdf");

            $form->data->fileName= str_replace(" ","_",$file->getName());
            $form->data->pdf= WRITEPATH . "uploads/publications/tmp.pdf";
            $file->move(WRITEPATH . 'uploads/publications/', "tmp.pdf");
        }

        if(empty($form->data->pdf)){
            $valid= 0;
        }

        /* ошибка формы */
        if (!$valid) {
            $this->session->setFlashdata("form",$form);
            $this->session->setFlashdata("validatorErrors",(object)$this->validator->getErrors());
            if($form->action=="add")
                return redirect()->to(base_url("/admin/publications/add"));
            else
                return redirect()->to(base_url("/admin/publications/edit/$id"));
        }

        if(!isset($form->data->display))
            $form->data->display= 0;

        /* добавление публикации */
        if($form->action=="add"){
            $form->data->display= (int)$form->data->display;
            $this->db->table("publications")->insert($form->data);
            $insertID= $this->db->insertID();
            $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Раздел добавлена: #$insertID: ".$form->data->name]);

            $pdf= "publications/".$insertID."_".$form->data->fileName;
            if(file_exists($pdf))
                unlink($pdf);
            rename($form->data->pdf, $pdf);

            $this->db->table("publications")->update(["pdf"=>$pdf],["id"=>$insertID]);
        }

        /* изменение публикации */
        if($form->action=="edit"){
            $publication= $this->db->table("publications")->where(['id'=>$id])->get()->getFirstRow();
            if($form->data->pdf != $publication->pdf){
                $pdf= "publications/".$id."_".$form->data->fileName;
                if(file_exists($pdf)) unlink($pdf);
                if(file_exists($publication->pdf)) unlink($publication->pdf);
                rename($form->data->pdf, $pdf);
                $form->data->pdf= $pdf;
            }

            $this->db->table("publications")->update($form->data,["id"=>$id]);

            $this->session->setFlashdata("message",(object)[
                "type"=>"success",
                "class"=>"callout-success",
                "message"=>"Раздел изменен: #: $id: ".($publication->name!=$form->data->name?" $publication->name -> ":" ").$form->data->name,
            ]);

            /* пониженеие счетчиков в коллекциях */
            $publication->collections= json_decode($publication->collections);
            if(!empty($publication->collections))
                foreach($publication->collections as $cID)
                    $this->model->updateCount("collections",$cID,false);

            /* пониженеие счетчиков в разделах */
            $publication->sections= json_decode($publication->sections);
            if(!empty($publication->sections))
                foreach($publication->sections as $sID)
                    $this->model->updateCount("sections",$sID,false);

            /* пониженеие счетчика в источниках */
            $this->model->updateCount("sources",$publication->source,false);
        }

        /* повышение счетчиков в коллекциях */
        if(!empty($collections))
            foreach($collections as $cID)
                $this->model->updateCount("collections", $cID);

        /* повышение счетчиков в разделах */
        if(!empty($sections))
            foreach($sections as $sID)
                $this->model->updateCount("sections",$sID);

        /* повышение счетчика в источниках */
        $this->model->updateCount("sources",$form->data->source);

        /* переучет авторов */
        if(!empty($authors))
            $this->PublicationsModel->AuthorAudit($authors);

        return redirect()->to(base_url("/admin/publications/"));
    }

    public function delete($id=false):RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $current= $this->db->table("publications")->where(['id'=>$id])->get()->getFirstRow();

        $current->collections= json_decode($current->collections);
        if(!empty($current->collections))
            foreach($current->collections as $cID)
                $this->model->updateCount("collections",$cID,false);

        $current->sections= json_decode($current->sections);
        if(!empty($current->sections))
            foreach($current->sections as $sID)
                $this->model->updateCount("sections",$sID,false);

        $this->model->updateCount("sources",$current->source,false);


        $this->db->table("publications")->delete(["id"=>$id]);

        if(file_exists($current->pdf)) unlink($current->pdf);

        $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Публикация удалена: #$current->id $current->name"]);

        return redirect()->to(base_url("/admin/publications/"));
    }

    public function changeVisible():bool
    {
        $form= (object)$this->request->getVar();
        if(empty($form->id) or !isset($form->display)) return false;
        $this->db->table("publications")->update(["display"=>$form->display],["id"=>$form->id]);
        return true;
    }

    public function setFilter():RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $filter= $this->request->getVar('filter')??[];

        $this->session->set("sectionsFilter",$filter);
        return redirect()->to(base_url("/admin/sections/"));
    }
}