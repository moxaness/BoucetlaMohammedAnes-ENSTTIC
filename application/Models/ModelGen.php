<?php
USE Config\Database;

include_once __DIR__ . '/ClientModel.php';
include_once __DIR__ . '/ProduitModel.php';
include_once __DIR__ . '/FactureModel.php';

class Model{
    public $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function clientModel(){
        return $clm=new ClientModel($this->db);
    }
    public function produitModel(){
        return $prm=new ProduitModel($this->db);
    }
    public function factureModel(){
        return $fam=new FactureModel($this->db);
    }
    public function userModel(){
        return $usm=new UserModel($this->db);
    }
}
?>