<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;

class User extends BaseController
{
    public function exit(): RedirectResponse
    {
        $this->model->exit();
        return redirect()->to(base_url(ADMIN));
    }

    public function auth(): string|RedirectResponse
    {
        if($this->model->hasAuth())
            return redirect()->to(base_url(ADMIN_MAIN_PAGE));

        $data["title"]= "Control Panel: Authentication";

        if(is_array($this->request->getVar('authForm'))) {
            if(!$this->model->auth($this->request->getVar('authForm')))
                $data['ErrorMessage']= $this->session->getFlashdata("ErrorMessage");
            $data['form']= $this->request->getVar('authForm');
        }

        if($this->model->hasAuth())
            return redirect()->to(base_url(ADMIN_MAIN_PAGE));

        return view("admin/template/page",["pageContent"=>view("admin/User/Auth",$data)]);
    }
}