<?php

namespace App\Controllers;
use App\Models\PublicationsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class References extends BaseController
{
    protected array $page;
    protected int $countInPage= 20;
    protected PublicationsModel $PublicationsModel;

    protected array $likes;
    protected array $where= ["cnt>"=>0];
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);
        $this->PublicationsModel= model(PublicationsModel::class);
        return true;
    }

    public function list($type,int $currentPage= 1): string|RedirectResponse
    {
        $this->page['includes']=(object)[
            'js'    =>  [],
            'css'   =>  [
                "css/public/references.css",
                "css/public/pagination.css",
            ],
        ];

        /* Reference letters */
        $letters= $this->db
            ->table($type)
            ->select("DISTINCT UPPER(LEFT(name, 1)) AS letter")
            ->where("cnt>",0)
            ->get()
            ->getResult();

        sort($letters);

        if($this->session->has("letterFor_$type")){
            $currentLetter = $this->session->get("letterFor_$type");
            $this->likes[]= (object)[
                "field"     =>  "name",
                "search"    =>  $currentLetter,
                "side"      =>  "after",
            ];
        }

        $lettersBox= view("public/Templates/Letters",[
            'type'      =>  $type,
            'letters'   =>  $letters,
            "current"   =>  $currentLetter??false,
        ]);

        /* search */
        if($this->session->has("searchFor_$type")){
            $search= $this->session->get("searchFor_$type");
            $this->likes[]= (object)[
                "field"     =>  "name",
                "search"    =>  $search,
                "side"      =>  "both",
            ];
        }

        $searchBox= view("public/References/Search",[
            "action"=> base_url("$type/search"),
            "search"=> $search??null,
        ]);

        /* Sorts */
        if($this->session->has("sortFor_$type"))
            $sorts= $this->session->get("sortFor_$type");

        $sortBox= view("public/References/Sort",[
            "baseurl"=> base_url("show/$type/"),
            "sort"=> (object)($sorts??[]),
        ]);

        if(empty($sorts['name']))
            $sorts['name']= "asc";


        /* Reference List && Pagination */
        $list= $this->db->table($type);

        $paginator= $this->model->getListWithPagination(
            $list,
            $this->where??[],
            $this->likes??[],
            $sorts??[],
            (object)[
                "link"      =>  base_url("show/$type/page-"),
                "current"   =>  $currentPage,
                "inPage"    =>  $this->countInPage,
            ]
        );

        /* Splitting list */
        if(is_array($list)){
            $equal= count($list)%2;

            $list= [
                array_slice($list,0,ceil(count($list)/2)),
                array_slice($list,ceil(count($list)/2)),
            ];
        }

        /* References List Box */
        $listBox= view("public/References/List",[
            "title"     =>  match($type){
                "tags"      =>  "Темы",
                "authors"   =>  "Автора",
                "advisors"  =>  "Научные руководители",
            },
            "list"      =>  $list,
            "equal"     =>  $equal??false,
            "paginator" =>  $paginator,
            "link"      =>  base_url("set-$type/"),
        ]);

        /* References Page Content */
        $this->page['pageContent']= view("public/References/PageContent",[
            "letters"   =>  $lettersBox,
            "search"    =>  $searchBox,
            "sort"      =>  $sortBox,
            "list"      =>  $listBox,
        ]);

        return view("public/page",$this->page);
    }

    public function setSort($type,$sort,$direction):RedirectResponse
    {
        $this->session->set("sortFor_$type",[$sort=>$direction]);
        return redirect()->to(base_url("show/$type"));
    }
    public function showByLetter($type,$op):RedirectResponse|bool
    {
        if($op == "all")
            $this->session->remove("letterFor_$type");

        else
            $this->session->set("letterFor_$type",$op);

        return redirect()->to(base_url("show/$type"));
    }


    public function searchByType($type):RedirectResponse
    {
        $search= $this->request->getVar("search");

        if(empty($search))
            $this->session->remove("searchFor_$type");

        else
            $this->session->set("searchFor_$type",$search);

        return redirect()->to(base_url("show/$type"));
    }

}