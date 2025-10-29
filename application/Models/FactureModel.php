<?php
USE Config\Database;

include_once __DIR__ . '/../../Config/Database.php';

class FactureModel{
    public $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function getAllFactures(){
        $req = $this->db->con->query('SELECT f.id,f.id_client, c.nom AS client_nom, f.prix
        FROM facture f
        JOIN client c ON f.id_client = c.id');
    return $factures = $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFactureToEdit($facture_id){
        $facture_id = $_GET['id'];

        $req2 = $this->db->con->prepare('SELECT * FROM facture WHERE id = :id');
        $req2->bindParam(':id', $facture_id, PDO::PARAM_INT);
        $req2->execute();
        return $facture = $req2->fetch(PDO::FETCH_ASSOC);
    }
    public function getClientInFactureToEdit($facture){
        $req_client = $this->db->con->prepare('SELECT id, nom FROM client WHERE id = :id_client');
        $req_client->bindParam(':id_client', $facture['id_client'], PDO::PARAM_INT);
        $req_client->execute();
        return $client = $req_client->fetch(PDO::FETCH_ASSOC);
    }
    public function getProduits(){
        
    $req_produits = $this->db->con->query('SELECT id, nom, quantite, prix FROM produit');
    return $produits = $req_produits->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProduitInFacture($facture_id){
        $req_prod_facture = $this->db->con->prepare('SELECT pf.id_produit, pf.quantite, p.nom, p.prix FROM produitFacture pf JOIN produit p ON pf.id_produit = p.id WHERE pf.id_facture= :id_facture');
    $req_prod_facture->bindParam(':id_facture', $facture_id, PDO::PARAM_INT);
    $req_prod_facture->execute();
    return $produits_facture = $req_prod_facture->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getClients(){
        $req_clients = $this->db->con->query('SELECT id, nom FROM client');
    return $clients = $req_clients->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>