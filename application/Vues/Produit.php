<?php
class ProduitView {
    public function display($produits) {
        echo "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                }
                h2 {
                    color: #007bff;
                }
                a {
                    text-decoration: none;
                    color: #007bff;
                    margin-right: 15px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    background: #fff;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    text-align: center;
                }
                th {
                    background: #007bff;
                    color: white;
                }
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                input[type='text'], input[type='number'] {
                    padding: 8px;
                    width: 100%;
                    margin: 5px 0;
                    box-sizing: border-box;
                }
                input[type='submit'] {
                    background-color: #007bff;
                    color: white;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    width: 100%;
                }
                input[type='submit']:hover {
                    background-color: #0056b3;
                }
                .form-container {
                    background: white;
                    padding: 20px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    width: 50%;
                    margin: 0 auto;
                    border-radius: 5px;
                }
                .return-link {
                    text-decoration: none;
                    color: #007bff;
                    margin-top: 10px;
                    display: block;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <h2>Liste des produits</h2><br>
            <a href='?action=ajouterProduit'>Ajouter un produit</a><br>
            <a href='/boucetlaMohammedAnes/application/Controleurs/ControleurGen.php'>Retour à l'accueil</a><br>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Quantité en stock</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>";
        
        foreach ($produits as $produit) {
            echo "
                <tr>
                    <td>{$produit['id']}</td>
                    <td>{$produit['nom']}</td>
                    <td>{$produit['quantite']}</td>
                    <td>{$produit['prix']}</td>
                    <td>
                        <a href='?action=modifierProduit&id={$produit['id']}'>Modifier</a> | 
                        <a href='/boucetlaMohammedAnes/application/Controleurs/ControleurGen.php?action=supprimerProduit&id={$produit['id']}'>Supprimer</a>
                    </td>
                </tr>";
        }
        echo "</table><br>";
        echo "</body></html>";
    }

    public function addForm() {
        echo "
        <div style='background: white; padding: 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); width: 50%; margin: 0 auto; border-radius: 5px;'>
            <h2 style='color: #007bff;'>Ajouter un produit</h2>
            <form action='' method='post'>
                <label>Nom: <input type='text' name='nom' required style='padding: 8px; width: 100%; margin: 5px 0; box-sizing: border-box;'></label><br>
                <label>Quantité: <input type='number' name='quantite' required style='padding: 8px; width: 100%; margin: 5px 0; box-sizing: border-box;'></label><br>
                <label>Prix: <input type='number' name='prix' step='0.01' required style='padding: 8px; width: 100%; margin: 5px 0; box-sizing: border-box;'></label><br>
                <input type='submit' name='Ajouter_produit' value='Ajouter produit' style='background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%;'><br>
            </form>
            <a href='?action=gestionProduits' style='text-decoration: none; color: #007bff; margin-top: 10px; display: block; text-align: center;'>Retour à la liste des produits</a>
        </div>";
    }
    
    public function editForm($produit) {
        echo "
        <div style='background: white; padding: 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); width: 50%; margin: 0 auto; border-radius: 5px;'>
            <h2 style='color: #007bff;'>Modifier un produit</h2>
            <form action='' method='post'>
                <input type='hidden' name='id' value='{$produit['id']}'>
                <label>Nom: <input type='text' name='nom' value='{$produit['nom']}' required style='padding: 8px; width: 100%; margin: 5px 0; box-sizing: border-box;'></label><br>
                <label>Quantité: <input type='number' name='quantite' value='{$produit['quantite']}' required style='padding: 8px; width: 100%; margin: 5px 0; box-sizing: border-box;'></label><br>
                <label>Prix: <input type='number' name='prix' step='0.01' value='{$produit['prix']}' required style='padding: 8px; width: 100%; margin: 5px 0; box-sizing: border-box;'></label><br>
                <input type='submit' name='Modifier_produit' value='Modifier produit' style='background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%;'><br>
            </form>
            <a href='?action=gestionProduits' style='text-decoration: none; color: #007bff; margin-top: 10px; display: block; text-align: center;'>Retour à la liste des produits</a>
        </div>";
    }
    
}
