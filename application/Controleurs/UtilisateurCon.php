<?php
USE Config\Database;

include_once __DIR__ . '/../Models/ModelGen.php';
include_once __DIR__ . '/../Models/UtilisateurModel.php';
include_once __DIR__ . '/../Vues/Utilisateur.php';

class UserController{
    public $m;
    public $um;
    public $db;
    public function __construct(Database $db) {
        $this->m = new Model($db);
        $this->um=$this->m->userModel();
        $this->db=new Database($db);
    }
    public function displayUsers(){
        $users=$this->um->getAllUsers();
        $v=new UserView();
        $v->display($users);
    }
    public function deleteUser($user_id){
        $req2 = $this->db->con->prepare('DELETE FROM utilisateurs WHERE id=:id');
        $req2->bindParam(':id', $user_id, PDO::PARAM_INT);
        $req2->execute();
        header('Location: /boucetlaMohammedAnes/application/Controleurs/ControleurGen.php?action=gestionUtilisateur');
        exit();
    }
    public function editUser($user_id){
        $id=$user_id;
        $user=$this->um->getUserToEdit($id);
        $v=new UserView();
        $v->editForm($user);
        if (isset($_POST['Modifier_utilisateur']) && isset($_POST['id']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['role'])) {
            $user_id = $_POST['id']; 
            $username = $_POST['username'];
            $email = htmlspecialchars($username); 
            $password = $_POST['password'];
            $password = htmlspecialchars($password);
            $role = $_POST['role'];
            $role = filter_var($role, FILTER_SANITIZE_STRING);
            $role = htmlspecialchars($role); 
            $req2 = $this->db->con->prepare('UPDATE utilisateurs SET username = :username, password = :password, role = :role WHERE id = :id');
            
            $req2->bindParam(':username', $username, PDO::PARAM_STR);
            $req2->bindParam(':password', $password, PDO::PARAM_STR);
            $req2->bindParam(':role', $role, PDO::PARAM_STR);
            $req2->bindParam(':id', $user_id, PDO::PARAM_INT);
            $req2->execute();

            if ($req2) {
                echo "user modifié avec succès!";
                header('Location: ?action=gestionUtilisateur');
                exit();
            }
        }
    }
    public function addUser(){
        $v=new UserView();
        $v->addForm();
        if (isset($_POST['Ajouter_utilisateur']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['role'])) {
           
            $username = $_POST['username'];
            $username = htmlspecialchars($username); 
            $password = $_POST['password'];
            $password = htmlspecialchars($password);
            $role = $_POST['role'];
            $role = filter_var($role, FILTER_SANITIZE_STRING);
            $role = htmlspecialchars($role);
      
            
            $req2 = $this->db->con->prepare('INSERT INTO utilisateurs (username, password, role) VALUES (:username, :password, :role)');
            $req2->bindParam(':username', $username, PDO::PARAM_STR);
            $req2->bindParam(':password', $password, PDO::PARAM_STR);
            $req2->bindParam(':role', $role, PDO::PARAM_STR);
      
            $req2->execute();
      
            if ($req2) {
                echo "Utilisateur ajouté avec succès!";
                
                header('Location: ?action=gestionUtilisateur');
                exit();
            } else {
                echo "Erreur lors de l'ajout du utilisateur.";
            }
        }
    }
}
?>