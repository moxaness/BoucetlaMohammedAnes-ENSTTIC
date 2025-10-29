<?php

class ClientView {

    public function display($clients) {
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Liste des clients</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                    background-color: #f9f9f9;
                }
                h2 {
                    color: #007bff;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                    margin-right: 10px;
                }
                a:hover {
                    text-decoration: underline;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    background: #fff;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                    border: 1px solid #ddd;
                }
                th {
                    background: #007bff;
                    color: white;
                }
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                tr:hover {
                    background-color: #f1f1f1;
                }
            </style>
        </head>
        <body>
            <h2>Liste des clients</h2><br>
            <a href='?action=ajouterClient'>Ajouter un client</a><br>
            <a href='/boucetlaMohammedAnes/application/Controleurs/ControleurGen.php'>Retour à l'accueil</a><br>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Action</th>
                </tr>";
        foreach ($clients as $client) {
            echo "
                <tr>
                    <td>{$client['id']}</td>
                    <td>{$client['nom']}</td>
                    <td>{$client['email']}</td>
                    <td>{$client['telephone']}</td>
                    <td>
                        <a href='?action=modifierClient&id={$client['id']}'>Modifier</a> | 
                        <a href='?action=supprimerClient&id={$client['id']}'>Supprimer</a>
                    </td>
                </tr>";
        }
        echo "
            </table>
        </body>
        </html>";
    }

    public function addForm() {
        echo "
        <h2>Ajouter un client</h2>
        <form action='' method='post' style='
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            max-width: 400px;
        '>
            <label style='display: block; margin-bottom: 10px;'>Nom: 
                <input type='text' name='nom' required style='
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                '>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Email: 
                <input type='email' name='email' required style='
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                '>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Téléphone: 
                <input type='text' name='telephone' required style='
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                '>
            </label>
            <input type='submit' name='Ajouter_client' value='Ajouter client' style='
                background: #007bff;
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                border-radius: 5px;
                width: 100%;
            '>
        </form>
        <a href='?action=gestionClients' style='
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        '>Retour à la liste des clients</a>";
    }

    public function editForm($client) {
        echo "
        <h2>Modifier le client</h2>
        <form action='' method='post' style='
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            max-width: 400px;
        '>
            <input type='hidden' name='id' value='{$client['id']}'>
            <label style='display: block; margin-bottom: 10px;'>Nom: 
                <input type='text' name='nom' value='{$client['nom']}' required style='
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                '>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Email: 
                <input type='email' name='email' value='{$client['email']}' required style='
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                '>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Téléphone: 
                <input type='text' name='telephone' value='{$client['telephone']}' required style='
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                '>
            </label>
            <input type='submit' name='Modifier_client' value='Modifier client' style='
                background: #007bff;
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                border-radius: 5px;
                width: 100%;
            '>
        </form>
        <a href='?action=gestionClients' style='
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        '>Retour à la liste des clients</a>";
    }

}
?>
