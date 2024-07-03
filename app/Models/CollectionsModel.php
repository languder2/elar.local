<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use CodeIgniter\Validation\ValidationInterface;
use Config\Services;
class CollectionsModel extends GeneralModel {
    protected Session $session ;
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->session= Services::session();
    }
    public function CollectionsAdd($form){

        $sql=[
            "title"=>$form->title,
            "description"=>$form->description,
        ];
        $this->db->table("collections")->insert($sql);
        $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Коллекция добавлена: #".$this->db->insertID().": $form->id"]);
        return true;
    }
    public function CollectionsChange($form){
        $sql=[
            "title"=>$form->title,
            "description"=>$form->description,

        ];
        $this->db->table("collections")->update($sql,["id"=>$form->id]);
        $this->session->setFlashdata("message",(object)["type"=>"success","class"=>"callout-success","message"=>"Коллекция изменена: #$form->id: $form->title"]);
        return true;
    }

    function prepareExamList(&$profile,$exams):bool
    {
        $result= (object)["required"=>[],"variable"=>[]];
        if($profile->exams)
            foreach ($profile->exams as $key=>$exam){
                if(isset($exam->required) && isset($exams[$key]))
                    $result->required[$exams[$key]->name]= $exam->score;
                if(isset($exam->variable) && isset($exams[$key]))
                    $result->variable[$exams[$key]->name]= $exam->score;
            }
        $profile->exams= $result;
        return true;
    }

    public function getProfileCards($table= false,$assoc= false,$where= false, $jArr= [],$sort= false):bool|array{
        $exams= self::dbGetList("examSubjects","id",false,false,false);
        $profiles= self::dbGetList($table,$assoc,$where, $jArr,$sort);
        $types= self::dbGetList("edTypes","id");
        $formByDefault= self::dbGetRow("edForms",["byDefault"=>1])->code;
        if(count($profiles))
            foreach ($profiles as $key=>$profile){
                self::prepareExamList($profile,$exams);
                $profiles[$key]= view("public/profiles/card",[
                    "profile"=>$profile,
                    "types"=>$types,
                    "formByDefault"=>$formByDefault,
                ]);
            }
        return $profiles;
    }

    public function updateProfileForms($table= false,$assoc= false,$where= false, $jArr= [],$sort= false){
        $forms= self::dbGetList("edForms","code",false,false,"sort");
        $formByDefault= self::dbGetRow("edForms",["byDefault"=>1])->code;
        $profiles= self::dbGetList($table,$assoc,$where, $jArr,$sort);
        foreach ($profiles as $profile){
            $pForm= (object)[];
            foreach ($forms as $form=>$rec)
                if(
                    $profile->places->budget->{$form} or
                    $profile->places->contract->{$form} or
                    $profile->prices->{$form}
                )
                    $pForm->{$form}= 1;
                else
                    $pForm->{$form}= 0;
            self::dbUpdateFiled(
                "edProfiles",
                ["forms"=>json_encode($pForm)],
                ["id"=>$profile->id]
            );
        }
    }

    public function getTitleCollection():array{
        $q= $this->db->table("collections")->get();
        $results= [];
        foreach($q->getResult() as $record)
            $results[$record->title]= $record;
        return $results;
    }

    public function getCountCollection():array{
        $q= $this->db->table("collections")->get();
        $results= [];
        foreach($q->getResult() as $record)
            $results[$record->cnt]= $record;
        return $results;
    }

    public function getDescriptionCollection():array{
        $q= $this->db->table("collections")->get();
        $results= [];
        foreach($q->getResult() as $record)
            $results[$record->description]= $record;
        return $results;
    }

    public function getCollectionsList($filter= []):array{
        $q= $this->db->table("collections")
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