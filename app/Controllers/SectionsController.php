<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;

class SectionsController extends BaseController
{
    public function adminList(): string
    {
        if($this->model->hasAuth() === false)
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $page['includes']=(object)[
            'js'=>[],
            'css'=>["/css/admin/sections.css"],
        ];
        $page["title"]= "Control Panel: Разделы";
        $page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);

        $page['list']= $this->model->db->table("sections")->get()->getResult();
        $page['list']= $this->model->buildTree($page['list'],"id");
        $page['list']= $this->model->Tree2List($page['list']);

        $page['pageContent']= view("admin/Sections/List",$page);
        return view("admin/template/page",$page);
    }

    public function form($action= "add",$id= false):string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        if($action!=="add" && $id===false) return redirect()->to(base_url("/admin/sections/"));

        $page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);

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

        $page['data']["title"] = ($action!=="edit")?"Раздел: Создать":"Раздел: Изменить";
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
        }
        elseif($form->action=="edit"){
            $this->model->db->table("sections")->update($sql,["id"=>$form->id]);
        }

        return redirect()->to(base_url("/admin/sections/"));
    }

}