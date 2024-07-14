<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\DownloadResponse;
class Download extends BaseController
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
                $publication= $this->db->table("Publications")->where("id",$op)->get();
                if(!$publication->getNumRows()) break;
                $file= $publication->getFirstRow()->pdf;
            break;
            default:
                $file= WRITEPATH ."Publications/$op";
            break;
        }
        if(!empty($file) and file_exists($file)) {
            return $this->response->download($file, null);
        }
        $this->data['pageContent']= view("public/download/error");
        return view("public/page",$this->data);
    }

    public function readPDF($type= "link",$op= ""){
        echo $file = WRITEPATH."Publications/373_test_1.pdf";
        echo $file2 = "Publications/373_test_1.pdf";
        rename ($file, $file2);
        $filename = '373_test_1.pdf';
// Header content type
        //header('Content-type: application/pdf');

//        header('Content-Disposition: inline; filename="' . $filename . '"');

  //      header('Content-Transfer-Encoding: binary');

//        header('Accept-Ranges: bytes');
        header ("Location: /admin");
        //return @readfile($file);
    }
}