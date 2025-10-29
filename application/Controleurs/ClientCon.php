<?php
USE Config\Database;

include_once __DIR__ . '/../Models/ModelGen.php';
include_once __DIR__ . '/../Models/ClientModel.php';
include_once __DIR__ . '/../Vues/Client.php';
class ClientController{
    public $m;
    public $cm;
    public $db;
    public function __construct(Database $db) {
        $this->m = new Model($db);
        $this->cm=$this->m->clientModel();
        $this->db=new Database($db);
    }
    public function displayClients(){
        $clients=$this->cm->getAllClients();
        $v=new ClientView();
        $v->display($clients);
    }
    public function deleteClient($client_id){
        $req2 = $this->db->con->prepare('DELETE FROM client WHERE id=:id');
        $req2->bindParam(':id', $client_id, PDO::PARAM_INT);
        $req2->execute();
        header('Location: /boucetlaMohammedAnes/application/Controleurs/ControleurGen.php?action=gestionClients');
        exit();
    }
    public function editClient($client_id){
        $id=$client_id;
        $client=$this->cm->getClientToEdit($id);
        $v=new ClientView();
        $v->editForm($client);
        if (isset($_POST['Modifier_client']) && isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['telephone'])) {
            $client_id = $_POST['id']; 
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = htmlspecialchars($email); 
            $nom = $_POST['nom'];
            $nom = filter_var($nom, FILTER_SANITIZE_STRING);
            $nom = htmlspecialchars($nom); 
            $telephone = $_POST['telephone'];

            $req2 = $this->db->con->prepare('UPDATE client SET nom = :nom, email = :email, telephone = :telephone WHERE id = :id');
            $req2->bindParam(':nom', $nom, PDO::PARAM_STR);
            $req2->bindParam(':email', $email, PDO::PARAM_STR);
            $req2->bindParam(':telephone', $telephone, PDO::PARAM_STR);
            $req2->bindParam(':id', $client_id, PDO::PARAM_INT);
            $req2->execute();

            if ($req2) {
                echo "Client modifié avec succès!";
                header('Location: ?action=gestionClients');
                exit();
            }
        }
    }
    public function addClient(){
        $v=new ClientView();
        $v->addForm();
        if (isset($_POST['Ajouter_client']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['telephone'])) {
           
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = htmlspecialchars($email); 
      
            $nom = $_POST['nom'];
            $nom = filter_var($nom, FILTER_SANITIZE_STRING);
            $nom = htmlspecialchars($nom); 
      
            $telephone = $_POST['telephone'];
      
            
            $req2 = $this->db->con->prepare('INSERT INTO client (nom, email, telephone) VALUES (:nom, :email, :telephone)');
            $req2->bindParam(':nom', $nom, PDO::PARAM_STR);
            $req2->bindParam(':email', $email, PDO::PARAM_STR);
            $req2->bindParam(':telephone', $telephone, PDO::PARAM_STR);
      
            $req2->execute();
      
            if ($req2) {
                echo "Client ajouté avec succès!";
                if($_SESSION['role']=='admin'){
                    header('Location: ?action=gestionClients');
                    exit();
                }
            } else {
                echo "Erreur lors de l'ajout du client.";
            }
        }
    }
}
?>