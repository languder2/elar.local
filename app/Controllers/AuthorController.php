<?php

namespace App\Controllers;
use App\Models\PublicationsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AuthorController extends BaseController
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
        if($this->session->has("authorsFilter"))
            $filter= $this->session->get("authorsFilter");

        $list= $this->model->db->table("authors");
        if(!empty($filter))
            $list= $list->like($filter);

        $page['list']= $list->get()->getResult();


        $page['filter']= view("admin/authors/Filter",["filter"=>(object)$filter]);

        $page['pageContent']= view("admin/Authors/List",$page);

        return view("admin/template/page",$page);
    }
    public function form($action= "add",$id= false):string|RedirectResponse
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        if($action!=="add" && $id===false) return redirect()->to(base_url("/admin/years/"));

        $page['data']["title"] = "Автор: Добавить";
        $page["title"]= "Control Panel: ".$page['data']["title"];

        $page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);
        if($this->session->has("message"))
            $page['data']['message']= $this->session->getFlashdata("message");

        $page['data']['includes']=(object)[
            'js'=>[],
            'css'=>[],
        ];

        $page['data']["years"]= $this->model->db
            ->table("authors")
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

        $page['pageContent']= view("admin/Authors/Form",$page['data']);
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
                "is_unique"=>"Такой автор уже существует: $form->name"
            ],
        ];

        $inputs = $this->validate($rules,$messages);

        if (!$inputs) {
            $form= json_decode(json_encode($form), FALSE);
            $this->session->setFlashdata("form",$form);
            $this->session->setFlashdata("validator",$this->validator);
            if($form->action=="add")
                return redirect()->to(base_url("/admin/authors/add"));
        }

        $sql=[
            "name"=>$form->name,
        ];

        if($form->action=="add"){
            $this->model->db->table("authors")->insert($sql);
            $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Автор добавлена: #".$this->db->insertID().": $form->name"]);
        }

        return redirect()->to(base_url("/admin/authors/"));
    }
    public function delete($id=false):RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $current= $this->db->table("authors")->where(['id'=>$id])->get()->getFirstRow();

        if($current->cnt)
            $this->session->setFlashdata("message",(object)["type"=>"error","class"=>"callout-error","message"=>"Автор не может быть удален, т.к. содержит публикации.<br>Год #$current->id: $current->name"]);
        else{
            $this->model->db->table("authors")->delete(["id"=>$id]);
            $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Автор удален: #$current->id $current->name"]);
        }

        return redirect()->to(base_url("/admin/authors/"));
    }
    public function setFilter():RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $filter= $this->request->getVar('filter')??[];

        $this->session->set("authorsFilter",$filter);
        return redirect()->to(base_url("/admin/authors/"));
    }

    public function changeVisible():bool
    {
        $form= (object)$this->request->getVar();
        if(empty($form->id) or !isset($form->display)) return false;
        $this->model->db->table("authors")->update(["display"=>$form->display],["id"=>$form->id]);
        return true;
    }

    public function setSort($sid= 0, $sort = false, $sortDirection= "asc"):RedirectResponse
    {
        $publicationsSort= (object)[$sort=>$sortDirection];
        $this->session->set("publicationsSort",$publicationsSort);
        return redirect()->route('Sections::showSection',[$sid]);
    }


}