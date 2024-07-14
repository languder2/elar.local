<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\PublicationsModel;

class Publications extends BaseController
{
    protected array $page;
    protected int $countInPage = 20;

    protected array $json= [
        "sections",
        "authors",
        "tags",
    ];

    protected array $toCountUpdate= [
        "sections",
        "types",
        "authors",
        "tags",
    ];

    protected PublicationsModel $PublicationsModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger):bool
    {
        parent::initController($request, $response, $logger);
        $this->page['menuTop']= view("admin/template/menuTop",["menu"=>$this->model->getMenu("admin")]);
        $this->PublicationsModel= model(PublicationsModel::class);
        return true;
    }
    public function adminList($page= 1): string
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

        $count=  $this->db
            ->table("publications")
            ->like($filter)
            ->get()->getNumRows();

        $maxPages= ceil($count / $this->countInPage);

        if($maxPages<$page) $page = $maxPages;
        if($page<1) $page = 1;

        $this->page['paginator']= view("admin/template/paginator",[
            "maxPages"=>$maxPages,
            "currentPage"=>$page,
            "baseLink"=>base_url("/admin/publications/page-"),
        ]);

        $this->page['list']= $this->db
            ->table("publications")
            ->like($filter)
            ->orderBy("id","DESC")
            ->limit($this->countInPage,$this->countInPage*($page-1))
            ->get()->getResult();

        foreach ($this->page['list'] as $key=>$publication){
            foreach ($this->json as $json)
                if(!empty($publication->{$json}))
                    $publication->{$json}= json_decode($publication->{$json});
            $this->page['list'][$key]= $publication;
        }

        /** get sections:  tree->list  */
        $this->page['data']['sections']= $this->model->convertTree2List(
            $this->db->table("sections")
                ->orderBy("parent")->orderBy("name")
                ->get()->getResult()
        );

        /** get types:  list  */
        $this->page['data']['types']=
            $this->db->table("types")
                ->orderBy("name")
                ->get()->getResult();

        /** get authors:  list  */
        $this->page['authors']= $this->model->getList("authors","id","name");

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
            $this->db->table("sections")
                ->orderBy("parent")->orderBy("name")
                ->get()->getResult()
        );

        /** get types:  list  */
        $this->page['data']['types']=
            $this->db->table("types")
                ->orderBy("name")
                ->get()->getResult();


        if($this->session->has("form")){

            $this->page['data']['form']= $this->session->getFlashdata("form");

            $this->page['data']['validator']= $this->session->getFlashdata("validator");

            $this->page['data']['validatorErrors']= $this->session->getFlashdata("validatorErrors");

        }
        elseif($action=="edit"){
            $publication= $this->db->table("publications")->where(['id'=>$id])->get()->getFirstRow();

            if(!empty($publication->authors)) {
                $authors= json_decode($publication->authors);
                $authors= $this->db->table("authors")->whereIn('id',$authors)->get()->getResult();
                $authors= $this->model->getList("authors", "id","name",$authors);
                $publication->authors= implode(", ",$authors);
            }

            if(!empty($publication->tags)) {
                $tags= json_decode($publication->tags);
                $tags= $this->db->table("tags")->whereIn('id',$tags)->get()->getResult();
                $tags= $this->model->getList("tags", "id","name",$tags);
                $publication->tags= implode(", ",$tags);
            }
            if(!empty($publication->advisor)) {
                $advisors= json_decode($publication->advisor);
                $advisors= $this->db->table("advisors")->whereIn('id',$advisors)->get()->getResult();
                $advisors= $this->model->getList("advisors", "id","name",$advisors);
                $publication->advisor= implode(", ",$advisors);
            }

            $this->page['data']['form']= (object)[
                "data"=> $publication,
            ];
        }

        $this->page['data']['ckeditor']= view("admin/template/CKEditor");
        $this->page['pageContent']= view("admin/Publications/Form",$this->page['data']);
        return view(ADMIN."/template/page",$this->page);
    }

    public function formProcessing():string|RedirectResponse
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);
        $form= (object)$this->request->getVar('form');
        $id= $this->request->getVar('id');

        $rules= [
            'form.data.name' => 'required',
            'form.data.authors' => 'required',
            'form.data.section' => 'required',
            'form.data.type' => 'required',
        ];
        $messages= [
            'form.data.name'=>[
                "required"=>"Укажите название",
            ],
            'form.data.authors'=>[
                "required"=>"Укажите автора",
            ],
            'form.data.section'=>[
                "required"=>"Укажите раздел",
            ],
            'form.data.type'=>[
                "required"=>"Укажите источник",
            ],
        ];

        $valid = $this->validate($rules,$messages);


        $form->data= (object)$form->data;

        /* обработка разделов */
        $section= $this->db
            ->table("sections")
            ->where(['id'=>$form->data->section])
            ->get()->getFirstRow();

        if($section->parent)
            $form->data->sections[]= $section->parent;

        $form->data->sections[]= $section->id;

        $form->data->sections= json_encode($form->data->sections,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);

        /* обработка pdf файла */
        $file = $this->request->getFile('pdf');
        if($file->isValid() && !$file->hasMoved()){
            if(file_exists(WRITEPATH . "uploads/publications/tmp.pdf"))
                unlink(WRITEPATH . "uploads/publications/tmp.pdf");

            $form->data->fileName= str_replace(" ","_",$file->getName());
            $form->data->pdf= WRITEPATH . "uploads/publications/tmp.pdf";
            $file->move(WRITEPATH . 'uploads/publications/', "tmp.pdf");
        }

        if(empty($form->data->pdf)){
            $valid= 0;
        }

        /* ошибка формы */
        if (!$valid) {
            $this->session->setFlashdata("form",$form);
            $this->session->setFlashdata("validatorErrors",(object)$this->validator->getErrors());
            if($form->action=="add")
                return redirect()->to(base_url("/admin/publications/add"));
            else
                return redirect()->to(base_url("/admin/publications/edit/$id"));
        }

        if(!isset($form->data->display))
            $form->data->display= 0;

        /* обработка авторов */
        $form->data->authors=
            $this->PublicationsModel->getRelationships(
                "authors",
                "name",
                $form->data->authors
            );

        /* обработка научного реководителя */
        if(!empty($form->data->advisor))
            $form->data->advisor=
                $this->PublicationsModel->getRelationships(
                    "advisors",
                    "name",
                    $form->data->advisor
                );

        /* обработка тегов */
        if(!empty($form->data->tags))
            $form->data->tags=
                $this->PublicationsModel->getRelationships(
                    "tags",
                    "name",
                    $form->data->tags
                );

        /* добавление публикации */
        if($form->action=="add"){
            $this->db->table("publications")->insert($form->data);
            $insertID= $this->db->insertID();
            $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Публикация добавлена: #$insertID: ".$form->data->name]);

            $pdf= "pdf/".$insertID."_publication.pdf";
            $fileName= $insertID."_publication.pdf";

            if(file_exists($pdf))
                unlink($pdf);
            rename($form->data->pdf, $pdf);

            $this->db->table("publications")->update(["pdf"=>$pdf,"fileName"=>$fileName],["id"=>$insertID]);
        }

        /* изменение публикации */
        if($form->action=="edit"){
            $publication= $this->db->table("publications")->where(['id'=>$id])->get()->getFirstRow();
            if($form->data->pdf != $publication->pdf){

                $pdf= "pdf/".$id."_publication.pdf";
                if(file_exists($pdf)) unlink($pdf);
                if(file_exists($publication->pdf)) unlink($publication->pdf);
                rename($form->data->pdf, $pdf);

                $form->data->pdf= $pdf;
                $form->data->fileName= $id."_publication.pdf";
            }

            $this->db->table("publications")->update($form->data,["id"=>$id]);

            $this->session->setFlashdata("message",(object)[
                "type"=>"success",
                "class"=>"callout-success",
                "message"=>"Публикация изменена: #: $id: ".($publication->name!=$form->data->name?" $publication->name -> ":" ").$form->data->name,
            ]);
        }


        /* пересчет счетчиков */
        foreach ($this->toCountUpdate as $by){
            $this->PublicationsModel->recountPublications($by);
        }
        return redirect()->to(base_url("/admin/publications/"));
    }

    public function delete($id=false):RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $current= $this->db->table("publications")->where(['id'=>$id])->get()->getFirstRow();


        $this->db->table("publications")->delete(["id"=>$id]);

        /* пересчет счетчиков */
        foreach ($this->toCountUpdate as $by)
            $this->PublicationsModel->recountPublications($by);

        if(file_exists($current->pdf)) unlink($current->pdf);

        $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Публикация удалена: #$current->id $current->name"]);

        return redirect()->to(base_url("/admin/publications/"));
    }

    public function changeVisible():bool
    {
        $form= (object)$this->request->getVar();
        if(empty($form->id) or !isset($form->display)) return false;
        $this->db->table("publications")->update(["display"=>$form->display],["id"=>$form->id]);
        return true;
    }

    public function setFilter():RedirectResponse|string
    {
        if(!$this->model->hasAuth())
            return view("admin/template/page",["pageContent"=>view("admin/User/Auth")]);

        $filter= $this->request->getVar('filter')??[];

        $this->session->set("sectionsFilter",$filter);
        return redirect()->to(base_url("/admin/sections/"));
    }
    public function publication($id=false):string|RedirectResponse
    {
        /* meta */
        $this->page['data']["title"]= "Электронный научный архив МелГУ: ";

        $this->page['includes']=(object)[
            'js'=>[""],
            'css'=>["/css/public/publications.css"],
        ];

        /* получение публикацию */
        $publication= $this->db->table("publications")
            ->where("id",$id)
            ->get()
            ->getFirstRow();

        /* преобразование json в массивы */
        foreach ($this->json as $json)
            if(!empty($publication->{$json}))
                $publication->{$json}= json_decode($publication->{$json});

        /* проверка если публикации с таким id нет */
        if(empty($publication))
            return redirect()->to(base_url("/"));

        /* подготовка источника */
        if(!empty($publication->type))
            $publication->type= $this->db
                ->table("types")
                ->where("id",$publication->type)
                ->get()->getFirstRow();

        /* определение размера файла */
        if(!empty($publication->pdf))
            $publication->filesize= $this->model->sizePDF($publication->pdf);

        /* подготовка разделов */
        if(!empty($publication->sections))
            $publication->sections= $this->db->table("sections")
                ->whereIn("id",$publication->sections)
                ->orderBy("parent","asc")
                ->get()->getResult();

        /* получение авторов*/
        if(!empty($publication->authors))
            $publication->authors= $this->db->table("authors")
                ->whereIn("id",$publication->authors)
                ->get()->getResult();

        /* получение тегов */
        if(!empty($publication->tags))
            $publication->tags= $this->db->table("tags")
                ->whereIn("id",$publication->tags)
                ->get()->getResult();

        /* получение руководителя*/
        if(!empty($publication->advisor))
            $publication->advisor= $this->db->table("advisors")
                ->where("name",$publication->advisor)
                ->get()->getFirstRow();

        /* вывод */
        $this->page['pageContent']= view("public/Publications/Single",["publication"=>$publication]);
        return view("public/page",$this->page);
    }

    public function publicFilter($clear,$type,$id):RedirectResponse|string
    {
        $filter = [];

        if($clear)
            $this->session->remove("publicationsFilterWhere");

        if(!$clear && $this->session->has("publicationsFilterWhere"))
            $filter = $this->session->get("publicationsFilterWhere");

        if($type){
            $filter["JSON_CONTAINS($type,'$id','$')"]= 1;
            $this->session->set("publicationsFilterWhere",$filter);
        }

        return redirect()->to(base_url("publications"));
    }

    public function list($currentPage= 1):string|RedirectResponse
    {
        $includes=(object)[
            'js'=>[],
            'css'=>[
                "css/public/publications.css",
                "css/public/pagination.css",
            ],
        ];

        /* get filters  */
        if($this->session->has("publicationsFilterWhere"))
            $where= $this->session->get("publicationsFilterWhere");

        /* filters box  */
        $filtersBox= view("public/Publications/Filters",[
            "action"=> base_url("search-publications"),
            "search"=> $search??null,
        ]);

        /* likes */
        if($this->session->has("publications_search")){
            $search= $this->session->get("publications_search");
            $likes[]= (object)[
                "field"     =>  "name",
                "search"    =>  $search,
                "side"      =>  "both",
            ];
        }

        /* search box */
        $searchBox= view("public/Publications/Search",[
            "action"=> base_url("search-publications"),
            "search"=> $search??null,
        ]);

        /* get sort */
        if($this->session->has("publicationsSort"))
            $sorts= $this->session->get("publicationsSort");
        else
            $sorts=(object)[
                "date"=>"desc",
            ];

        /* sort view */
        $sortBox= view("public/Templates/Sort",[
            "baseurl"=>base_url("publications/"),
            "sort"=> $sorts,
        ]);

        $publications= $this->db->table("publications");

        $paginator= $this->model->getListWithPagination(
            $publications,
            $where??[],
            $likes??[],
            $sorts??[],
            (object)[
                "link"      =>  base_url("publications/page-"),
                "current"   =>  $currentPage,
                "inPage"    =>  $this->countInPage,
            ]
        );


        $this->PublicationsModel->prepareToShow($publications);

        $publicationsBox= view("public/Publications/List",[
            "list"      =>  $publications,
            "paginator" =>  $paginator,
        ]);


        $pageContent= view("public/Publications/PageContent",[
            "sort"      =>  $sortBox,
            "search"    =>  $searchBox,
            "list"      =>  $publicationsBox,
        ]);

        return view("public/page",[
            "includes"      =>  $includes,
            "pageContent"   =>  $pageContent
        ]);
    }

    public function setPublicSort($sort = false, $sortDirection= "asc"):RedirectResponse
    {
        $publicationsSort= (object)[$sort=>$sortDirection];
        $this->session->set("publicationsSort",$publicationsSort);
        return redirect()->route('publications');
    }
    public function setPublicSearch():RedirectResponse
    {
        $search= $this->request->getVar("search");

        if(empty($search))
            $this->session->remove("publications_search");

        else
            $this->session->set("publications_search",$search);
        return redirect()->route('publications');
    }

}