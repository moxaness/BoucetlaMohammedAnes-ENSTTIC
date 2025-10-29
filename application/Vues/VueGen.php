<?php
class View{
    public $role;
    public function __construct($r){
        $this->role=$r;
    }
    public function dashboard(){
        switch ($this->role){
            case 'admin': 
             echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Admin Dashboard</title>
                <link rel='stylesheet' href='/boucetlaMohammedAnes/application/Css/VueGen.css'>
            </head>
            <body class='admin'>
                <h1>Bienvenue admin</h1>
                <a href='?action=gestionUtilisateur'>Gestion Utilisateurs</a><br>
                <a href='?action=gestionClients'>Gestion Clients</a><br>
                <a href='?action=gestionProduits'>Gestion Produits</a><br>
                <a href='?action=gestionFactures'>Gestion Factures</a><br>
        
            </body>
            </html>
        ";break;
        case 'agentSup':
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>agent superviseur Dashboard</title>
                <link rel='stylesheet' href='/boucetlaMohammedAnes/application/Css/VueGen.css'>
            </head>
            <body class='agentSup'>
                <h1>Bienvenue Agent Superviseur</h1>
                <a href='?action=gestionProduits'>Gestion produits</a><br>
            </body>
            </html>
        ";
        break;
        case 'agent':
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>agent normal Dashboard</title>
                <link rel='stylesheet' href='/boucetlaMohammedAnes/application/Css/VueGen.css'>
            </head>
            <body class='agent'>
                <h1>Bienvenue Agent Normal</h1>
                <a href='?action=gestionFactures'>Gestion Factures</a><br>
            </body>
            </html>
        ";
            break;
            
        default : echo "Role inexistant"; 
        break;
        }
    }
}
?>