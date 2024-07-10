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
                        "main"=>(object)[],
                        "sub"=>[]
                    ];
                }
                $result[$item->{$field}]->main = $item;
            }
            else
                if(isset($result[$item->parent]->sub))
                    $result[$item->parent]->sub[$item->{$field}]= $item;
        }
        return $result;
    }
    public function convertTree2List(array $list,bool $build= true, string $field= 'id'):array
    {
        $result= [];

        if(count ($list) == 0) return $result;

        if($build)
            $list= self::buildTree($list,$field);

        foreach($list as $item){
            $result[]= $item->main??$item;
            if(isset($item->sub) && count($item->sub)>0)
                $result= array_merge($result,self::convertTree2List($item->sub,false));
        }

        return $result;
    }

    public function sizePDF($pdf):string
    {
        if(!file_exists($pdf)) return 0;
        $size= filesize($pdf);
        $a = array("B", "KB", "MB", "GB", "TB", "PB");
        $pos = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size,2)." ".$a[$pos];
    }

    public function createPassword($password):string
    {
        $password= password_hash($password, PASSWORD_BCRYPT);
        return  $password;

    }

    public function getList($table= false,$key= false,$field= false,?array $list= []):array
    {
        $results= [];
        if(!$list)
            $list= $this->db->table($table)->get()->getResult();

        foreach($list as $item)
            $results[$item->{$key}]= $field?$item->{$field}:$item->id;

        return $results;
    }
}


