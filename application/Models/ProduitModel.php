<?php
USE Config\Database;

include_once __DIR__ . '/../../Config/Database.php';

class ProduitModel{
    public $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function getAllProduits(){
        $req2=$this->db->con->query('SELECT * FROM produit');
    return $produits=$req2->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProduitToEdit($produit_id){
        $produit_id=$_GET['id'];
    $req2=$this->db->con->prepare('SELECT * FROM produit WHERE id=:id');
    $req2->bindParam(':id',$produit_id,PDO::PARAM_INT);
    $req2->execute();
    return $produit=$req2->fetch(PDO::FETCH_ASSOC);
    }
}
?>