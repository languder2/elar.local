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
}
