<?php
USE Config\Database;

include_once __DIR__ . '/../Models/ModelGen.php';
include_once __DIR__ . '/../Models/ProduitModel.php';
include_once __DIR__ . '/../Vues/Produit.php';

class ProduitController{
    public $m;
    public $pm;
    public $db;
    public function __construct(Database $db) {
        $this->m = new Model($db);
        $this->pm=$this->m->produitModel();
        $this->db=new Database($db);
    }
    public function displayProduits(){
        $produits=$this->pm->getAllProduits();
        $v=new ProduitView();
        $v->display($produits);
    }
    public function deleteProduit($produit_id){
        $produit_id=$_GET['id'];
        $req2=$this->db->con->prepare('DELETE FROM produit WHERE id=:id');
        $req2->bindParam(':id',$produit_id,PDO::PARAM_INT);
        $req2->execute();
        header('Location: /boucetlaMohammedAnes/application/Controleurs/ControleurGen.php?action=gestionProduits');
        exit();
    }
    public function editProduit($produit_id){
        $id=$produit_id;
        $produit=$this->pm->getProduitToEdit($id);
        $v=new ProduitView();
        $v->editForm($produit);
        if(isset($_POST['Modifier_produit'])&&isset($_POST['id'])&&isset($_POST['nom'])&&isset($_POST['quantite'])&&isset($_POST['prix'])){
            $produit_id=$_POST['id'];
            $qt_stock = $_POST['quantite'];
            $qt_stock = filter_var($qt_stock, FILTER_SANITIZE_NUMBER_INT);
            $qt_stock = htmlspecialchars($qt_stock); 
            $nom = $_POST['nom'];
            $nom = filter_var($nom, FILTER_SANITIZE_STRING);
            $nom = htmlspecialchars($nom); 
            $prix = $_POST['prix'];
            
             
            $req2=$this->db->con->prepare('UPDATE produit SET nom=:nom,quantite=:quantite,prix=:prix WHERE id=:id');

            $req2->bindParam(':nom',$nom,PDO::PARAM_STR);
            $req2->bindParam(':quantite',$qt_stock,PDO::PARAM_INT);
            $req2->bindParam(':prix',$prix,PDO::PARAM_STR);
            $req2->bindParam(':id',$produit_id,PDO::PARAM_INT);
            $req2->execute();
            if($req2){
                echo "Produit modifié avec succès!";
            }
        }
    }
    public function addProduit(){
        $v=new ProduitView();
        $v->addForm();
        if(isset($_POST['Ajouter_produit'])&&isset($_POST['nom'])&&isset($_POST['quantite'])&&isset($_POST['prix'])){
            
            $qt_stock = $_POST['quantite'];
            $qt_stock = filter_var($qt_stock, FILTER_SANITIZE_NUMBER_INT);
            $qt_stock = htmlspecialchars($qt_stock); 
            $nom = $_POST['nom'];
            $nom = filter_var($nom, FILTER_SANITIZE_STRING);
            $nom = htmlspecialchars($nom); 
            $prix = $_POST['prix'];
            
            
            $req2=$this->db->con->prepare('INSERT INTO produit(nom,quantite,prix)VALUES(:nom,:quantite,:prix)');
 
            $req2->bindParam(':nom',$nom,PDO::PARAM_STR);
            $req2->bindParam(':quantite',$qt_stock,PDO::PARAM_INT);
            $req2->bindParam(':prix',$prix,PDO::PARAM_STR);
            $req2->execute();
            if($req2){
                echo "Produit ajouté avec succès!";
                
             
            }
        }
    }
}
?>