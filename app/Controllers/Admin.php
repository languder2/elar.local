<?php

namespace App\Controllers;
use App\Models\PublicationsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Admin extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);

        $PublicationsModel= model(PublicationsModel::class);

        /* пересчет счетчиков разделов */
        foreach ([
                     "sections",
                     "types",
                     "authors",
                     "advisors",
                     "tags",
                     "years",
                 ] as $by
        )
            $PublicationsModel->recountPublications($by);

        return true;
    }

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