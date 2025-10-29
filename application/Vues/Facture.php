<?php
USE Config\Database;

include_once __DIR__ . '/../../Config/Database.php';

class FactureView {
    public $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function display($factures) {
        echo "
        <h2 style='color: #007bff;'>Liste des factures</h2><br>
        <a href='?action=ajouterFacture' style='color: #007bff; text-decoration: none; margin-right: 10px;'>Ajouter une facture</a>
        <a href='/boucetlaMohammedAnes/application/Controleurs/ControleurGen.php' style='color: #007bff; text-decoration: none;'>Retour à l'accueil</a><br><br>
        <table style='width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);'>
            <tr style='background: #007bff; color: white;'>
                <th style='padding: 10px; border: 1px solid #ddd;'>ID Facture</th>
                <th style='padding: 10px; border: 1px solid #ddd;'>Client</th>
                <th style='padding: 10px; border: 1px solid #ddd;'>Prix Total</th>
                <th style='padding: 10px; border: 1px solid #ddd;'>Produits achetés</th>
                <th style='padding: 10px; border: 1px solid #ddd;'>Actions</th>
            </tr>";
        
        foreach ($factures as $facture) {
            $req2 = $this->db->con->prepare('SELECT produit.nom, produitFacture.quantite, produit.prix 
                FROM produitFacture 
                JOIN produit ON produitFacture.id_produit = produit.id
                WHERE produitFacture.id_facture = :id_facture');
            $req2->execute(['id_facture' => $facture['id']]);
            $produits = $req2->fetchAll(PDO::FETCH_ASSOC);
            
            $produits_details = "";
            foreach ($produits as $produit) {
                $produits_details .= "{$produit['nom']} (Quantité: {$produit['quantite']}, Prix: {$produit['prix']} * {$produit['quantite']} = " . $produit['prix'] * $produit['quantite'] . " DZD)<br>";
            }
            
            echo "
            <tr>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$facture['id']}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$facture['client_nom']}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$facture['prix']} €</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$produits_details}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>
                    <a href='?action=modifierFacture&id={$facture['id']}' style='color: #007bff; text-decoration: none;'>Modifier</a> | 
                    <a href='?action=supprimerFacture&id={$facture['id']}' style='color: #007bff; text-decoration: none;'>Supprimer</a>
                </td>
            </tr>";
        }
        
        echo "</table><br>";
    }

    public function addFormClient() {
        echo "
        <h2 style='color: #007bff;'>Ajouter un client</h2>
        <form action='' method='post' style='background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 400px;'>
            <label style='display: block; margin-bottom: 10px;'>Nom:
                <input type='text' name='nom' required style='width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;'>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Email:
                <input type='email' name='email' required style='width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;'>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Téléphone:
                <input type='text' name='telephone' required style='width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;'>
            </label>
            <input type='submit' name='Ajouter_client' value='Ajouter client' style='background: #007bff; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; width: 100%;'>
        </form>";
    }

    public function addForm($clients, $produits) {
        echo "
        <h2 style='color: #007bff;'>Ajouter une facture</h2>
        <form action='' method='post' style='background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 600px;'>
            <label style='display: block; margin-bottom: 10px;'>Client:
                <select name='id_client' required style='width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;'>
                    <option value=''>Choisir un client</option>";
        foreach ($clients as $client) {
            echo "<option value='{$client['id']}'>{$client['nom']}</option>";
        }
        echo "
                </select>
            </label>
            <h3 style='color: #007bff;'>Produits:</h3>";
        foreach ($produits as $produit) {
            echo "
            <div style='margin-bottom: 10px;'>
                <label>
                    <input type='checkbox' name='produits[{$produit['id']}]' value='{$produit['id']}' style='margin-right: 5px;'>
                    {$produit['nom']} (Stock: {$produit['quantite']}, Prix: {$produit['prix']} DZD)
                </label>
                <label style='margin-left: 10px;'>Quantité:
                    <input type='number' name='quantites[{$produit['id']}]' min='1' max='{$produit['quantite']}' value='1' style='width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;'>
                </label>
            </div>";
        }
        echo "
            <input type='submit' name='Ajouter_facture' value='Ajouter la facture' style='background: #007bff; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; width: 100%;'>
        </form>
        <a href='?action=ajouterClient' style='color: #007bff; text-decoration: none;'>Ajouter un client</a><br>
        <a href='?action=gestionFactures' style='color: #007bff; text-decoration: none;'>Retour à la liste des factures</a>";
    }

    public function editForm($facture, $client, $produits, $produits_facture, $clients) {
        echo "
        <h2 style='color: #007bff;'>Modifier une facture</h2>
        <form action='' method='post' style='background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 600px;'>
            <input type='hidden' name='id' value='{$facture['id']}'>
            <label style='display: block; margin-bottom: 10px;'>Client:
                <select name='id_client' required style='width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;'>";
        foreach ($clients as $client_option) {
            $selected = ($client_option['id'] == $facture['id_client']) ? 'selected' : '';
            echo "<option value='{$client_option['id']}' $selected>{$client_option['nom']}</option>";
        }
        echo "
                </select>
            </label>
            <h3 style='color: #007bff;'>Produits :</h3>";
        foreach ($produits as $produit) {
            $found = false;
            foreach ($produits_facture as $produit_facture) {
                if ($produit_facture['id_produit'] == $produit['id']) {
                    $found = true;
                    break;
                }
            }
            $checked = $found ? 'checked' : '';
            $quantite_value = $found ? $produit_facture['quantite'] : 1; 
            echo "
            <div style='margin-bottom: 10px;'>
                <label>
                    <input type='checkbox' name='produits[{$produit['id']}]' value='{$produit['id']}' $checked style='margin-right: 5px;'>
                    {$produit['nom']} (Stock: {$produit['quantite']}, Prix: {$produit['prix']} DZD)
                </label>
                <label style='margin-left: 10px;'>Quantité:
                    <input type='number' name='quantites[{$produit['id']}]' min='1' max='{$produit['quantite']}' value='$quantite_value' style='width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;'>
                </label>
            </div>";
        }
        echo "
            <input type='submit' name='Modifier_facture' value='Modifier la facture' style='background: #007bff; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; width: 100%;'>
        </form>
        <a href='?action=gestionFactures' style='color: #007bff; text-decoration: none;'>Retour à la liste des factures</a>";
    }
}
?>
