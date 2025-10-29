<?php

USE Config\Database;

session_start();
if (!isset($_SESSION['username']) || 
    !isset($_SESSION['password']) || 
    !isset($_SESSION['role'])) {
    header('Location: /boucetlaMohammedAnes/index.php');
    exit();
}

include_once __DIR__ . '/../Vues/VueGen.php';
include_once __DIR__ . '/UtilisateurCon.php';
include_once __DIR__ . '/ClientCon.php';
include_once __DIR__ . '/ProduitCon.php';
include_once __DIR__ . '/FactureCon.php';

class Controller {
    public $username;
    public $password;
    public $role;
    public $userr;
    public $client;
    public $produit;
    public $facture;
    public $vuee;

    public function __construct($db) {
        $this->username = $_SESSION['username'];
        $this->password = $_SESSION['password'];
        $this->role = $_SESSION['role'];
        $this->userr = new UserController($db);
        $this->client = new ClientController($db);
        $this->produit = new ProduitController($db);
        $this->facture = new FactureController($db);
        $this->vuee = new View($_SESSION['role']);
    }
}

$db = new Database();
$user = new Controller($db);

// Handle actions based on roles
switch ($_SESSION['role']) {
    case 'admin':
        // Default dashboard
        if (!isset($_GET['action'])) {
            $user->vuee->dashboard();
            break;
        }
        
        // Handle actions for admin
        switch ($_GET['action']) {
            case 'gestionUtilisateur':
                $user->userr->displayUsers();
                break;
            case 'ajouterUtilisateur':
                $user->userr->addUser();
                break;
            case 'supprimerUtilisateur':
                if (isset($_GET['id'])) $user->userr->deleteUser($_GET['id']);
                break;
            case 'modifierUtilisateur':
                if (isset($_GET['id'])) $user->userr->editUser($_GET['id']);
                break;
            case 'gestionClients':
                $user->client->displayClients();
                break;
            case 'ajouterClient':
                $user->client->addClient();
                break;
            case 'supprimerClient':
                if (isset($_GET['id'])) $user->client->deleteClient($_GET['id']);
                break;
            case 'modifierClient':
                if (isset($_GET['id'])) $user->client->editClient($_GET['id']);
                break;
            case 'gestionProduits':
                $user->produit->displayProduits();
                break;
            case 'ajouterProduit':
                $user->produit->addProduit();
                break;
            case 'supprimerProduit':
                if (isset($_GET['id'])) $user->produit->deleteProduit($_GET['id']);
                break;
            case 'modifierProduit':
                if (isset($_GET['id'])) $user->produit->editProduit($_GET['id']);
                break;
            case 'gestionFactures':
                $user->facture->displayFactures();
                break;
            case 'ajouterFacture':
                $user->facture->addFacture();
                break;
            case 'supprimerFacture':
                if (isset($_GET['id'])) $user->facture->deleteFacture($_GET['id']);
                break;
            case 'modifierFacture':
                if (isset($_GET['id'])) $user->facture->editFacture($_GET['id']);
                break;
        }
        break;

    case 'agentSup':
        // Default dashboard
        if (!isset($_GET['action'])) {
            $user->vuee->dashboard();
            break;
        }

        // Handle actions for agentSup
        switch ($_GET['action']) {
            case 'gestionProduits':
                $user->produit->displayProduits();
                break;
            case 'ajouterProduit':
                $user->produit->addProduit();
                break;
            case 'supprimerProduit':
                if (isset($_GET['id'])) $user->produit->deleteProduit($_GET['id']);
                break;
            case 'modifierProduit':
                if (isset($_GET['id'])) $user->produit->editProduit($_GET['id']);
                break;
        }
        break;

    case 'agent':
        // Default dashboard
        if (!isset($_GET['action'])) {
            $user->vuee->dashboard();
            break;
        }

        // Handle actions for agent
        switch ($_GET['action']) {
            case 'gestionFactures':
                $user->facture->displayFactures();
                break;
            case 'ajouterFacture':
                $user->facture->addFacture();
                break;
            case 'supprimerFacture':
                if (isset($_GET['id'])) $user->facture->deleteFacture($_GET['id']);
                break;
            case 'modifierFacture':
                if (isset($_GET['id'])) $user->facture->editFacture($_GET['id']);
                break;
        }
        break;

    default:
        // If role is not recognized, redirect to login page
        header('Location: /boucetlaMohammedAnes/index.php');
        exit();
}

// Logout logic
if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    session_destroy();
    header('Location: /boucetlaMohammedAnes/index.php');
    exit();
}

echo "<br><a href='/boucetlaMohammedAnes/index.php?action=deconnexion'>Se déconnecter</a>";

?>
