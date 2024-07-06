<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\DownloadResponse;
class DownloadController extends BaseController
{
    protected array $data;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);
        return true;
    }
    public function downloadPdf($type= "link",$op= ""): DownloadResponse|string|null
    {
        $this->data['includes']=(object)[
            'js'=>[""],
            'css'=>["/css/callout.css"],
        ];
        $file= "";
        switch($type){
            case "publication":
                $publication= $this->db->table("publications")->where("id",$op)->get();
                if(!$publication->getNumRows()) break;
                $file= $publication->getFirstRow()->pdf;
            break;
            default:
                $file= WRITEPATH ."publications/$op";
            break;
        }
        if(!empty($file) and file_exists($file)) {
            return $this->response->download($file, null);
        }
        $this->data['pageContent']= view("public/download/error");
        return view("public/page",$this->data);
    }
}