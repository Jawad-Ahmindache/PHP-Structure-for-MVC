<?php
namespace Jahmindache\Core\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Permet d'initialiser une nouvel objet de connexion bdd via Eloquent
 */
class EloquentMaker {

    private $db;

    public function __construct(){
        $this->db = new Capsule;
        
    }

    public function getEloquent(){
        return $this->db;
    }

    public function connect(string $host,string $db,string $username,string $password){
        $this->db->addConnection([

            "driver" => "mysql",
         
            "host" =>   $host,
         
            "database" => $db,
         
            "username" => $username,
         
            "password" => $password
         
         ]);
         $this->db->setAsGlobal();

         $this->db->bootEloquent();
         
    }
}
