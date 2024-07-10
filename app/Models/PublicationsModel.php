<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use CodeIgniter\Model;
class PublicationsModel extends Model{

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }

    public function AuthorAudit($list):bool
    {
        foreach ($list as $author)
            if($this->db->table('authors')->where("fio",$author)->get()->getNumRows() === 0)
                $this->db->table('authors')->insert(["fio"=>$author]);
        return  true;
    }

    public function recountPublications($by= false,$id= false):bool
    {
        if($by === false) return false;

        $query= match($by){
            default => false,
            "types" => "UPDATE types SET cnt= (SELECT COUNT(id) FROM publications WHERE type= types.id)",
            "sections"=> "UPDATE sections SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(sections,CONCAT('\"',sections.id,'\"'),'$'))"
        };

        if($id)
            $query.= " WHERE id=$id";

        $this->db->query($query);

        return true;
    }



}
