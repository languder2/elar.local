<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use CodeIgniter\Validation\ValidationInterface;
use Config\Services;
class SourcesModel extends GeneralModel {
    protected Session $session ;
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->session= Services::session();
    }
    public function SourcesAdd($form){

        $sql=[
            "title"=>$form->title,
            "description"=>$form->description,
        ];
        $this->db->table("sources")->insert($sql);
        $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Источник добавлен: #".$this->db->insertID().": $form->id"]);
        return true;
    }
    public function SourcesChange($form){
        $sql=[
            "title"=>$form->title,
            "description"=>$form->description,

        ];
        $this->db->table("sources")->update($sql,["id"=>$form->id]);
        $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Источник изменен: #$form->id: $form->title"]);
        return true;
    }
    public function getSourcesList($filter= []):array{
        $q= $this->db->table("sources")
            ->like($filter);
        $q= $q->get();
        $results= [];
        foreach($q->getResult() as $record){
            $record->id = $record->id;
            $record->title = $record->title;
            $record->cnt = $record->cnt;
            $results[$record->id]= $record;
        }
        return $results;
    }

    public function getFormErrors($validator){
        $results= [];
        $errors= $validator->getErrors();
        if($errors){
            $results= array_diff($errors, ['required']);
            if(in_array("required",$errors))
                $results= $results+['required'=>"Заполните обязательные поля"];
        }
        return $results;
    }

    public function dbGetRow($table= false,$where= false, $jArr= []):bool|object|NULL{
        if($table === false or $where === false) return false;
        $q= $this->db->table($table)->where($where)->get();
        if(!$q->getNumRows()) return false;
        $q= $q->getFirstRow();
        self::rowJsonDecode($q,$jArr);
        return $q;
    }

    function rowJsonDecode(&$row,$jArr):bool{
        if(!is_object($row) or count($jArr) === 0) return false;
        foreach ($jArr as $field)
            if(!empty($row->{$field}))
                $row->{$field}= json_decode($row->{$field});
        return true;
    }

    public function dbDelete($table= false,$where= false):bool{
        if($table === false or $where === false) return false;
            $this->db->table($table)->delete($where);
        return true;
    }

    function dbUpdateFiled($table,$field,$where):bool{
        $this->db->table($table)->update($field,$where);
        return true;
    }
}