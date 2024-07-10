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

    public function recountPublications($by= false,$id= false):bool
    {
        if($by === false) return false;
        $query= match($by){
            default => false,
            "types"     => "UPDATE types    SET cnt= (SELECT COUNT(id) FROM publications WHERE type= types.id)",
            "sections"  => "UPDATE sections SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(sections,sections.id,'$'))",
            "authors"   => "UPDATE authors  SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(authors,authors.id,'$'))",
            "advisors"  => "UPDATE advisors  SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(authors,advisors.id,'$'))",
            "tags"      => "UPDATE tags     SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(tags,tags.id,'$'))",
        };

        if(!$query) return false;

        if($id)
            $query.= " WHERE id=$id";

        $this->db->query($query);

        return true;
    }

    public function getRelationships(string $table,string $field, string $data):string
    {
        $data= explode(",",$data);
        $results= [];
        foreach ($data as $author){
            $res= $this->db
                ->table($table)
                ->select("id")
                ->where($field,trim($author))
                ->get()->getFirstRow();
            if(!empty($res))
                $results[] = $res->id;
            else{
                $this->db
                    ->table($table)
                    ->insert([$field=>trim($author)]);
                $results[] = $this->db->insertID();
            }
        }
        return json_encode($results,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
    }

    public function test():string
    {
        return "test";
    }




}
