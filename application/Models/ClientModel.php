<?php
USE Config\Database;

include_once __DIR__ . '/../../Config/Database.php';
class ClientModel{
    public $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function getAllClients(){
        $req2=$this->db->con->query('SELECT * FROM client');
        return $clients=$req2->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getClientToEdit($client_id){
        $req2 = $this->db->con->prepare('SELECT * FROM client WHERE id = :id');
        $req2->bindParam(':id', $client_id, PDO::PARAM_INT);
        $req2->execute();
        return $client = $req2->fetch(PDO::FETCH_ASSOC);
    }
}
?>