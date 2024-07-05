<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use CodeIgniter\Validation\ValidationInterface;
use Config\Services;
class PublicModel extends GeneralModel {
    protected Session $session ;
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->session= Services::session();
    }
    public function getSectionsList($filter= []):array{
        $q= $this->db->table("sections")->where(["parent"=>0]);
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
        }
        return $results;
    }

    public function getChapterList($id):array{
        $q= $this->db->table("sections")->where(["parent"=>$id]);
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
        }
        return $results;
    }

    public function getTitleSection($id):array{
        $q= $this->db->table("sections")->where(["id"=>$id]);
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
        }
        return $results;
    }
    public function getSubChapterList($id):array{
        $q= $this->db->table("collections")->where(["parent"=>$id]);
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
        }
        return $results;
    }
    public function getCollectionsList($id):array{
        $q= $this->db->table("collections");
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
        }
        return $results;
    }
    public function getCollectList($id):array{
        $q= $this->db->table("publications")->where(['id'=>$id]);
        $q= $q->get();
        $results= [];
        if($q->getNumRows()==0) return $results;
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
        }
        return $results;
    }
    public function getPublication($id):array{
        $q= $this->db->table("publications")->where(['id'=>$id]);
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $record->tags = json_decode($record->tags);
            $record->sections = json_decode($record->sections);
            $record->collections = json_decode($record->collections);
            $results[$record->id]= $record;
        }
        return $results;
    }
    public function getSubTitleChapter($id):array{
        $q= $this->db->table("sections")->where(["id"=>$id]);
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
        }
        return $results;
    }
    function rowJsonDecode(&$row,$jArr):bool{
        if(!is_object($row) or count($jArr) === 0) return false;
        foreach ($jArr as $field)
            if(!empty($row->{$field}))
                $row->{$field}= json_decode($row->{$field});
        return true;
    }
}