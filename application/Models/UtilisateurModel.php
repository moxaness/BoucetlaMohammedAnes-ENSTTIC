<?php
USE Config\Database;

include_once __DIR__ . '/../../Config/Database.php';
class UserModel{
    public $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }
    public function getAllUsers(){
        $req2=$this->db->con->query('SELECT * FROM utilisateurs');
        return $clients=$req2->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserToEdit($user_id){
        $req2 = $this->db->con->prepare('SELECT * FROM utilisateurs WHERE id = :id');
        $req2->bindParam(':id', $user_id, PDO::PARAM_INT);
        $req2->execute();
        return $client = $req2->fetch(PDO::FETCH_ASSOC);
    }
}
?>