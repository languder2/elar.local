<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;

class PagesController extends BaseController
{
    public function welcome(): string
    {
        if($this->model->hasAuth() === false)
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $page['data']['includes']=(object)[
            'js'=>[],
            'css'=>["/css/admin/profiles.css"],
        ];
        $page['data']["title"]= "Control Panel: Welcome";
        $page['data']['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);
        return view("admin/template/page",["pageContent"=>view("admin/welcome",$page['data'])]);
    }
}