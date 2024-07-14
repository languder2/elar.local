<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\PublicModel;
use App\Models\PublicationsModel;

class PublicController extends BaseController
{
    private PublicModel $pbl;

    protected array $page;
    protected int $countInPage= 10;
    protected PublicationsModel $PublicationsModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);
        $this->PublicationsModel= model(PublicationsModel::class);
        $this->pbl= model(PublicModel::class);
        return true;
    }

    public function MainList($id=false,$pg=0):string|RedirectResponse{
        $page['data']["title"]= "Электронный научный архив МелГУ: Главаня страница";

        if($this->session->has("collectionsFilter"))
            $page['data']['filter']= $this->session->get("MainFilter");

        $page['data']['edSections']= $this->pbl->getSectionsList();

        $page['pageContent']= view("public/main",$page['data']);
        return view("public/page",$page);
    }
    public function ChapterList($id=false,$pg=0):string|RedirectResponse{
        $page['data']["title"]= "Электронный научный архив МелГУ: ";

        if($this->session->has("collectionsFilter"))
            $page['data']['filter']= $this->session->get("MainFilter");

        $page['data']['edSections']= $this->pbl->getChapterList($id);
        $page['data']['TitleSections']= $this->pbl->getTitleSection($id);
        //$page['data']['edCollections']= $this->pbl->getCollectionsList($id);

        $l = $this->pbl->db->table('sections')->where(['parent'=>$id])->get()->getResult();
        $count=  $this->pbl->db
            ->table("Publications")
            ->get()->getNumRows();
        $maxPages= ceil($count / 20);

        if($maxPages<$pg) $pg = $maxPages;
        if($pg<1) $pg = 1;

        $page['data']['paginator']= view("admin/template/paginator",[
            "maxPages"=>$maxPages,
            "currentPage"=>$pg,
            "baseLink"=>base_url("/collections/$id/page-"),
        ]);

        $list = $this->pbl->db->table('Publications')
            ->where("JSON_CONTAINS(sections, '".$id."', '$')")
            ->limit(20,($pg-1)*20)
            ->orderBy("date","desc")
            ->orderBy("name","asc")
            ->get()->getResult();


        if(empty($l)){
            $page['data']['Publications']= view("public/Publications",["list"=>$list,"paginator"=>$page['data']['paginator']]);
            $page['pageContent']= view("public/subchapter",$page['data']);
            return view("public/page",$page);
        }
        else{
            $page['data']['Publications']= view("public/Publications",["list"=>$list,"paginator"=>$page['data']['paginator']]);
            $page['pageContent']= view("public/chapter",$page['data']);
            return view("public/page",$page);
        }

    }

    public function browse($type='',$search='',$id=false,$pg=0,):string|RedirectResponse
    {
        $where= [];
        $like= [];
        $page['data']['filter'] = (object)['title'=>''];
        if ($this->session->has("MainFilter"))
            $page['data']['filter'] = $this->session->get("MainFilter");
        $search = $page['data']['filter'];

        $page['data']["title"] = "Электронный научный архив МелГУ: ";
        $page['data']['type'] = $type;
        switch ($type){
            case "authors":
                $template = 'Publications-authors';
                $table = 'authors';
                $page['data']['typeName'] = 'По автору';
                $like= ["fio"=>$search->title];
                break;
            case "date":
                $template = 'Publications';
                $table = 'Publications';
                $page['data']['typeName'] = 'По дате';
                if (!empty($search->title))
                    $where= [$type=>$search->title];
                break;
            case "name":
                $template = 'Publications';
                $table = 'Publications';
                $page['data']['typeName'] = 'По заглавию';
                $like= [$type=>$search->title];
                break;
            case "tags":
                $template = 'Publications-tags';
                $table = 'tags';
                $page['data']['typeName'] = 'По источникам';
                $like= [$type=>$search->title];
                break;
        }
        $page['data']['filterSection'] = view("public/FilterSection", $page['data']);


        $publications= $this->db->table($table);

        if(!empty($where))
            $publications= $publications->where($where);

        if(!empty($like))
            $publications= $publications->like($like);

        $publications= $publications->get()->getResult();

        $count = $this->pbl->db
            ->table($table)
            ->get()->getNumRows();
        $maxPages= ceil($count / 20);

        if($maxPages<$pg) $pg = $maxPages;
        if($pg<1) $pg = 1;

        $page['data']['paginator']= view("admin/template/paginator",[
            "maxPages"=>$maxPages,
            "currentPage"=>$pg,
            "baseLink"=>base_url("/collections/$id/page-"),
        ]);

        $page['data']['publications']= view("public/search-template/$template",["list"=>$publications,"paginator"=>$page['data']['paginator']]);
        $page['pageContent']= view("public/browse",$page['data']);
        return view("public/page",$page);
    }
    public function setFilter($type=''){
        if(!$this->pbl->hasAuth()) return json_encode(['message'=>"success denied"]);
        $filter= (object)$this->request->getVar('filter');
        $this->session->set("MainFilter",$filter);
        return redirect()->to(base_url("/browse/$type"));
    }
    public function CollectList($id=false,$pg=0):string|RedirectResponse{
        $page['data']["title"]= "Электронный научный архив МелГУ: ";

        if($this->session->has("collectionsFilter"))
            $page['data']['filter']= $this->session->get("MainFilter");

        $count=  $this->pbl->db
            ->table("Publications")
            ->get()->getNumRows();
        $maxPages= ceil($count / 20);

        if($maxPages<$pg) $pg = $maxPages;
        if($pg<1) $pg = 1;

        $page['data']['paginator']= view("admin/template/paginator",[
            "maxPages"=>$maxPages,
            "currentPage"=>$pg,
            "baseLink"=>base_url("/collections/$id/page-"),
        ]);

        $list = $this->pbl->db->table('Publications')
            ->where("JSON_CONTAINS(collections, '\"".$id."\"', '$')")
            ->limit(20,($pg-1)*20)
            ->get()->getResult();

        $page['data']['edCollections']= $this->pbl->getTitleCollection($id);
        $page['data']['Publications']= view("public/Publications",["list"=>$list,"paginator"=>$page['data']['paginator']]);
        $page['pageContent']= view("public/collections",$page['data']);
        return view("public/page",$page);
    }
    public function CollectionsList($id=false,$pg=0):string|RedirectResponse{
        $page['data']["title"]= "Электронный научный архив МелГУ: ";

        if($this->session->has("collectionsFilter"))
            $page['data']['filter']= $this->session->get("MainFilter");

        $page['data']['edCollections']= $this->pbl->getCollectionsList($id);
        $page['data']['TitleChapter']= $this->pbl->getSubTitleChapter($id);


        $page['pageContent']= view("public/subchapter",$page['data']);
        return view("public/page",$page);
    }


    public function applyFilter($type= false, $search=""){
        $where= [];
        $like= [];
        switch ($type){
            case "author":
                $like= ["JSON_EXTRACT(authors, '$')"=>$search]; // форма запроса  для автора
                break;
            case "date":
                $where= [$type=>$search]; // форма запроса  для автора
                break;
            case "name":
                $like= [$type=>$search]; // форма запроса  для автора
                break;
        }


        $publications= $this->db->table("publications");

        if(!empty($where))
            $publications= $publications->where($where);

        if(!empty($like))
            $publications= $publications->like($like);

        $publications= $publications->get()->getResult();
        dd($publications);
    }

    public function index():string
    {
        $this->page['includes']=(object)[
            'js'=>[],
            'css'=>[
                "/css/public/sections.css",
                "/css/public/publications.css",
            ],
        ];

        $this->page['meta']= (object)[
            "title"=> "Control Panel: Разделы"
        ];

        /* get sections */
        $sections= $this->db
            ->table("sections")
            ->where(['parent'=>0])
            ->orderBy("name","asc")
            ->get()
            ->getResult();

        $this->page['sections']= view("public/Sections/List",[
            "title"=>"Разделы",
            "list"=>$sections,
        ]);


        /* get Publications */
        $publications= $this->db
            ->table("publications")
            ->where('display',"1")
            ->limit($this->countInPage,0*$this->countInPage)
            ->orderBy("date","desc")
            ->orderBy("name","asc")
            ->get()
            ->getResult();

        $this->PublicationsModel->prepareToShow($publications);

        $this->page['publication']= view("public/Publications/List",[
            "list"=>$publications,
            "paginator"=>$paginator??"",
        ]);


        $this->page['pageContent']= view("public/Page/Index",$this->page);

        return  view("public/page",$this->page);
    }

}
