<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;

class PublicationsController extends BaseController
{
    public function adminList(): string
    {
        if($this->model->hasAuth() === false)
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $page['includes']=(object)[
            'js'=>["/js/admin/change-visible.js"],
            'css'=>["/css/admin/publications.css"],
        ];
        $page["title"]= "Control Panel: Публикации";
        $page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);

        if($this->session->has("message"))
            $page['message']= $this->session->getFlashdata("message");

        $filter= [];
        if($this->session->has("publicationsFilter"))
            $filter= $this->session->get("sectionsFilter");

        $page['list']= $this->model->db
            ->table("sections")
            ->like($filter)
            ->orWhere(["parent!="=>0])
            ->orderBy("parent")
            ->orderBy("sort")
            ->orderBy("name")
            ->get()->getResult();

        $page['filter']= view("admin/Sections/Filter",["filter"=>(object)$filter]);

        $page['list']= $this->model->buildTree($page['list'],"id");
        $page['list']= $this->model->Tree2List($page['list']);

        $page['pageContent']= view("admin/Sections/List",$page);
        return view("admin/template/page",$page);
    }
/*
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
*/
}