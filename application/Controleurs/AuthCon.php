<?php
namespace application\Controleurs;

USE PDO;
USE PDOException;
USE application\Vues\AuthView;

include_once __DIR__ . '/../../Config/Database.php';
include_once __DIR__ . '/../Vues/Auth.php';
class AuthController{
    public $db;
    public function __construct($db) {
        $this->db=$db;
    }
    public function authenticate($username,$password){
        $req1=$this->db->con->prepare('SELECT * FROM utilisateurs WHERE username=:username AND password=:password');
        $req1->bindParam(':username', $username ,  PDO::PARAM_STR);  
        $req1->bindParam(':password', $password, PDO::PARAM_STR);  
        $req1->execute();
        
        $res=$req1->fetch(PDO::FETCH_ASSOC);
        if($res){
            $_SESSION['role'] = $res['role'];
            $_SESSION['username'] = $res['username'];
            $_SESSION['password'] = $res['password'];
            header('Location: /boucetlaMohammedAnes/application/Controleurs/ControleurGen.php');
            exit();
        }else{
              $av=new AuthView('username ou mot de passe incorrect');
              echo $av->loginForm();
        }
    }
    public function showLoginForm(){
        $av=new AuthView('');
        echo $av->loginForm();
    }
}

?>