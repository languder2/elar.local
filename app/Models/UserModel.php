<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use CodeIgniter\Validation\ValidationInterface;
use Config\Services;
class UserModel extends Model{

    protected Session $session ;
    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->session= Services::session();
    }
    public function hasAuth():bool{
        if($this->session->get("adminAuthStatus")) return true;
        return false;
    }
    public function exit():bool{
        $this->session->destroy();
        return true;
    }
    public function auth($authForm = false):bool{
        $user= $this->db->query("SELECT * FROM users WHERE login='".esc($authForm['login'])."'")->getFirstRow();
        if(empty($user)) {
            $this->session->setFlashdata(["ErrorMessage" => "login not found"]);
            return false;
        }
        if(!password_verify($authForm['password'],$user->password)){
            $this->session->setFlashdata(["ErrorMessage" => "invalid password"]);
            return false;
        }
        if(empty($user->status)){
            $this->session->setFlashdata(["ErrorMessage" => "User not active"]);
            return false;
        }
        $this->session->set([
           "adminAuthStatus"=>true,
           "adminAuthUID"=>$user->id,
           "adminAuthULogin"=>$user->login,
           "adminAuthUPerm"=>$user->perm,
        ]);
        return true;
    }
}
