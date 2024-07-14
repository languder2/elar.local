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
            "sections"  => "UPDATE sections SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(sections,CONCAT(sections.id),'$'))",
            "authors"   => "UPDATE authors  SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(authors,CONCAT(authors.id),'$'))",
            "advisors"  => "UPDATE advisors SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(authors,CONCAT(advisors.id),'$'))",
            "tags"      => "UPDATE tags     SET cnt= (SELECT COUNT(id) FROM publications WHERE JSON_CONTAINS(tags,CONCAT(tags.id),'$'))",
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

    public function prepareToShow(&$list):bool
    {
        if(!$list) return false;
        $ops= (object)[
            "authors"=>(object)[
                "field"=>"authors",
                "list"=>[],
                "ids"=>[]
            ],
            "advisors"=>(object)[
                "field"=>"advisor",
                "list"=>[],
                "ids"=>[]
            ],
            "tags"=>(object)[
                "field"=>"tags",
                "list"=>[],
                "ids"=>[]
            ],
            "types"=>(object)[
                "field"=>"type",
                "list"=>[],
                "ids"=>[]
            ],
            "sections"=>(object)[
                "field"=>"sections",
                "list"=>[],
                "ids"=>[]
            ]
        ];

        foreach ($list as $key=>$publication){
            foreach ($ops as $code=>$op){

                $publication->{$op->field}= json_decode($publication->{$op->field},true);

                if(is_array($publication->{$op->field}))
                    $ops->{$code}->ids= array_merge($ops->{$code}->ids,$publication->{$op->field});

                elseif($publication->{$op->field})
                    $ops->{$code}->ids[]= $publication->{$op->field};

                $list[$key]= $publication;
            }
        }

        foreach ($ops as $code=>$op) {
            if(empty($op->ids)) continue;
            $res = $this->db
                ->table($code)
                ->whereIn("id", array_unique($op->ids))
                ->get()->getResult();

            foreach ($res as $rec)
                $ops->{$code}->list[$rec->id] = $rec;

            foreach ($list as $key => $publication){

                if (is_array($publication->{$op->field}))
                    foreach ($publication->{$op->field} as $tas => $row)
                        $publication->{$op->field}[$tas] = $ops->{$code}->list[$row] ?? $row;

                elseif ($publication->{$op->field})
                    $publication->{$op->field} = $ops->{$code}->list[$publication->{$op->field}];

                $list[$key] = $publication;
            }
        }
        return true;
    }



}
