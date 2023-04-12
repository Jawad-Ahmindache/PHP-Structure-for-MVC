<?php
namespace Jahmindache\Core\Model;
use Jahmindache\Core\Model\EloquentMaker;

class AppModel {
    
    protected $db;


    public function __construct(string $host,string $db,string $username,string $password){
        $this->db = new EloquentMaker;

        $this->db->connect($host,$db,$username,$password);
        
    }

    
    /**
     * Retourne un objet EloquentMaker qui crée la connexion à la base de donnée
     *
     * @return EloquentMaker
     */
    public function getEloquentMaker(){
        return $this->db;
    }

    /**
     * Retourne la connexion à la base de donnée contenue dans le EloquentMaker
     * @return Capsule
     */
    public function getDB(){
        return $this->db->getEloquent();
    }
    
}
