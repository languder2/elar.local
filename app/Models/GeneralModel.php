<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
class GeneralModel extends UserModel{

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }
    public function getFlashdata($arg):array|object|string
    {
        return $this->session->getFlashdata($arg);
    }
    public function getMenu($section= "public",$parent= 0){
        $q= $this->db->table("menu")->where(["section"=>$section,"parent"=>$parent,"display"=>'1'])->orderBy("sort")->get();
        $results= [];
        foreach($q->getResult() as $record){
            $results[$record->id]= $record;
            $results[$record->id]->submenu= $this->getMenu($section,$parent= $record->id);
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
    public function buildTree(array $list,string $field):array
    {
        $result= [];
        if(count ($list) == 0) return $result;
        foreach($list as $item){
            if($item->parent == 0) {
                if(!isset($result[$item->{$field}])){
                    $result[$item->{$field}]= (object)[
                        "main",
                        "sub"=>[]
                    ];
                }
                $result[$item->{$field}]->main = $item;
            }
            else
                $result[$item->parent]->sub[$item->{$field}]= $item;
        }
        return $result;
    }
    public function Tree2List(array $list):array
    {
        $result= [];
        if(count ($list) == 0) return $result;
        foreach($list as $item){
            $result[]= $item->main??$item;
            if(isset($item->sub) && count($item->sub)>0)
                $result= array_merge($result,self::Tree2List($item->sub));
        }
        return $result;
    }
}
