<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
class PublicationsController extends BaseController
{
    protected array $page;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);
        $this->page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);
        return true;
    }
    public function adminList(): string
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

        $this->page['list']= $this->model->db
            ->table("publications")
            ->like($filter)
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
            $this->model->db->table("sections")
                ->orderBy("parent")->orderBy("name")
                ->get()->getResult()
        );

        /** get sources:  list  */
        $this->page['data']['sources']=
            $this->model->db->table("sources")
                ->orderBy("title")
                ->get()->getResult();

        /** get collections:  list  */
        $this->page['data']['collections']=
            $this->model->db->table("collections")
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
        elseif($action=="edit")
            $this->page['data']['form']= $this->model->db->table("sections")->where(['id'=>$id])->get()->getFirstRow();

        $this->page['pageContent']= view("admin/Publications/Form",$this->page['data']);
        return view(ADMIN."/template/page",$this->page);
    }

    public function formProcessing():string|RedirectResponse
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);
        $form= (object)$this->request->getVar('form');

        $rules= [
            'form.data.name' => 'required',
        ];
        $messages= [
            'form.data.name'=>[
                "required"=>"Название должно быть указано",
            ],
        ];

        $valid = $this->validate($rules,$messages);

        $form->data= (object)$form->data;
        if(!empty($form->data->collections))
            $form->data->collections= json_encode($form->data->collections);
        if(!empty($form->data->tags))
            $form->data->tags=
                json_encode(
                    array_map('trim',
                        explode(",",$form->data->tags)
                    )
                );

        $file = $this->request->getFile('pdf');
        if($file->isValid() && !$file->hasMoved()){
            if(file_exists(WRITEPATH . "uploads/publications/tmp.pdf"))
                unlink(WRITEPATH . "uploads/publications/tmp.pdf");

            $form->data->fileName= $file->getName();
            $form->data->pdf= WRITEPATH . "uploads/publications/tmp.pdf";
            $file->move(WRITEPATH . 'uploads/publications/', "tmp.pdf");
        }

        if(empty($form->data->pdf)){
            $valid= 0;
        }

        if (!$valid) {
            $this->session->setFlashdata("form",$form);
            $this->session->setFlashdata("validatorErrors",(object)$this->validator->getErrors());
            if($form->action=="add")
                return redirect()->to(base_url("/admin/publications/add"));
            else
                return redirect()->to(base_url("/admin/publications/edit/$form->id"));
        }

        $section= $this->model->db->table("sections")->where(['id'=>$form->data->section])->get()->getFirstRow();
        $form->data->sections= [$section->id];
        if($section->parent)
            $form->data->sections[]= $section->parent;
        $form->data->sections= json_encode($form->data->sections);

        if($form->action=="add"){
            $this->model->db->table("publications")->insert($form->data);
            $insertID= $this->model->db->insertID();
            $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Раздел добавлена: #$insertID: ".$form->data->name]);

            $pdf= WRITEPATH . "/publications/".$insertID."_".str_replace(" ","_",$form->data->fileName);
            if(file_exists($pdf))
                unlink($pdf);
            rename($form->data->pdf, $pdf);
            $this->model->db->table("publications")->update(["pdf"=>$pdf],["id"=>$insertID]);
        }
/*
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

            $this->model->db->table("sections")->update($data,["id"=>$form->id]);
            $this->session->setFlashdata("message",(object)[
                "type"=>"success",
                "class"=>"callout-success",
                "message"=>"Раздел изменен: #: $form->id: ".($current->name!=$form->name?" $current->name -> ":"")." $form->name",
            ]);
        }
        */
        return redirect()->to(base_url("/admin/publications/"));
    }

    /*
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
    */
}