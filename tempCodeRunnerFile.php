<?php

use Config\Database;
use application\Controleurs\AuthController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/Config/Database.php';

require __DIR__ . '/application/Controleurs/AuthCon.php';


 
$db=new Database();
$authC=new AuthController($db);
    if (isset($_GET['connecter']) && isset($_GET['username']) && isset($_GET['password'])) {
        $username = $_GET['username'];
        $username = htmlspecialchars($username);
        $password = $_GET['password'];
        $authC->authenticate($username, $password);
    } else {
        $authC->showLoginForm();
    }


?>