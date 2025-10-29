<?php
USE Config\Database;

include_once __DIR__ . '/../Models/ModelGen.php';
include_once __DIR__ . '/../Models/FactureModel.php';
include_once __DIR__ . '/../Vues/Facture.php';

class FactureController{
    public $m;
    public $fm;
    public $db;
    public function __construct(Database $db) {
        $this->m = new Model($db);
        $this->fm=$this->m->factureModel();
        $this->db=new Database($db);
    }
    public function displayFactures(){
        $factures=$this->fm->getAllFactures();
        $f=new FactureView();
        $f->display($factures);
    }
    public function deleteFacture($facture_id){
        $facture_id = $_GET['id'];
        $req_produits_facture = $this->db->con->prepare('SELECT id_produit, quantite FROM produitFacture WHERE id_facture = :id_facture');
        $req_produits_facture->execute(['id_facture' => $facture_id]);
        $produits_facture = $req_produits_facture->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach ($produits_facture as $produit) {
        
            $req_produit = $this->db->con->prepare('SELECT quantite FROM produit WHERE id = :id_produit');
            $req_produit->execute(['id_produit' => $produit['id_produit']]);
            $produit_info = $req_produit->fetch(PDO::FETCH_ASSOC);
            
            
            $new_stock = $produit_info['quantite'] + $produit['quantite'];
    
          
            $req_update_stock = $this->db->con->prepare('UPDATE produit SET quantite = :new_stock WHERE id = :id_produit');
            $req_update_stock->execute([
                'new_stock' => $new_stock,
                'id_produit' => $produit['id_produit']
            ]);
        }
    
        
        $req_delete_pro_par_facture = $this->db->con->prepare('DELETE FROM produitFacture WHERE id_facture = :id_facture');
        $req_delete_pro_par_facture->execute(['id_facture' => $facture_id]);
    
       
        $req_delete_facture = $this->db->con->prepare('DELETE FROM facture WHERE id = :id_facture');
        $req_delete_facture->execute(['id_facture' => $facture_id]);
    
        
        header('Location: /boucetlaMohammedAnes/application/Controleurs/ControleurGen.php?action=gestionFactures');
        exit();
    }
    public function editFacture($facture_id){
        $id=$facture_id;
        $facture=$this->fm->getFactureToEdit($id);
        $client=$this->fm->getClientInFactureToEdit($facture);
        $produits=$this->fm->getProduits();
        $produits_facture=$this->fm->getProduitInFacture($id);
        $clients=$this->fm->getClients();
        $f=new FactureView();
        $f->editForm($facture,$client,$produits,$produits_facture,$clients);
        if (isset($_POST['Modifier_facture']) && isset($_POST['id']) && isset($_POST['id_client']) && !empty($_POST['produits']) && !empty($_POST['quantites'])) {
            $facture_id = $_POST['id'];
            $client_id = $_POST['id_client'];
            $produits = $_POST['produits'];
            $quantites = $_POST['quantites'];
    
            foreach ($produits_facture as $produit_facture) {
              
                $old_produit_id = $produit_facture['id_produit'];
                $old_quantity = $produit_facture['quantite'];
    
               
                $req_update_stock = $this->db->con->prepare('UPDATE produit SET quantite = quantite + :old_quantity WHERE id = :id_produit');
                $req_update_stock->bindParam(':old_quantity', $old_quantity, PDO::PARAM_INT);
                $req_update_stock->bindParam(':id_produit', $old_produit_id, PDO::PARAM_INT);
                $req_update_stock->execute();
            }
    
          
            $req_delete_old_products = $this->db->con->prepare('DELETE FROM produitFacture WHERE id_facture = :id_facture');
            $req_delete_old_products->bindParam(':id_facture', $facture_id, PDO::PARAM_INT);
            $req_delete_old_products->execute();
    
           
            $prix_tot = 0;  
    
            foreach ($produits as $produit_id) {
                $quantite = $quantites[$produit_id];
    
                $req_produit = $this->db->con->prepare('SELECT quantite FROM produit WHERE id = :id_produit');
                $req_produit->bindParam(':id_produit', $produit_id, PDO::PARAM_INT);
                $req_produit->execute();
                $produit = $req_produit->fetch(PDO::FETCH_ASSOC);
    
                if ($produit['quantite'] < $quantite) {
                    echo "Stock insuffisant pour le produit {$produit['nom']}<br>";
                    exit;  
                }
    
                
                $req_check_prod_facture = $this->db->con->prepare('SELECT quantite FROM produitFacture WHERE id_facture = :id_facture AND id_produit = :id_produit');
                $req_check_prod_facture->bindParam(':id_facture', $facture_id, PDO::PARAM_INT);
                $req_check_prod_facture->bindParam(':id_produit', $produit_id, PDO::PARAM_INT);
                $req_check_prod_facture->execute();
                $existing_prod = $req_check_prod_facture->fetch(PDO::FETCH_ASSOC);
    
                if ($existing_prod) {
                  
                    $previous_quantity = $existing_prod['quantite'];
                    $quantity_difference = $quantite - $previous_quantity;
    
                    $req_update_prod_facture = $this->db->con->prepare('UPDATE produitFacture SET quantite = :quantite WHERE id_facture = :id_facture AND id_produit = :id_produit');
                    $req_update_prod_facture->bindParam(':quantite', $quantite, PDO::PARAM_INT);
                    $req_update_prod_facture->bindParam(':id_facture', $facture_id, PDO::PARAM_INT);
                    $req_update_prod_facture->bindParam(':id_produit', $produit_id, PDO::PARAM_INT);
                    $req_update_prod_facture->execute();
    
                    $req_update_stock = $this->db->con->prepare('UPDATE produit SET quantite -= :quantity_diff WHERE id = :id_produit');
                    $req_update_stock->bindParam(':quantity_diff', $quantity_difference, PDO::PARAM_INT);
                    $req_update_stock->bindParam(':id_produit', $produit_id, PDO::PARAM_INT);
                    $req_update_stock->execute();
                } else {
                 
                    $req_insert_prod_facture = $this->db->con->prepare('INSERT INTO produitFacture(id_facture, id_produit, quantite) VALUES(:id_facture, :id_produit, :quantite)');
                    $req_insert_prod_facture->bindParam(':id_facture', $facture_id, PDO::PARAM_INT);
                    $req_insert_prod_facture->bindParam(':id_produit', $produit_id, PDO::PARAM_INT);
                    $req_insert_prod_facture->bindParam(':quantite', $quantite, PDO::PARAM_INT);
                    $req_insert_prod_facture->execute();
    
          
                    $req_update_stock = $this->db->con->prepare('UPDATE produit SET quantite = :quantite WHERE id = :id_produit');
                    $req_update_stock->bindParam(':quantite', $quantite, PDO::PARAM_INT);
                    $req_update_stock->bindParam(':id_produit', $produit_id, PDO::PARAM_INT);
                    $req_update_stock->execute();
                }
    
      
                $req_prod_price = $this->db->con->prepare('SELECT prix FROM produit WHERE id = :id_produit');
                $req_prod_price->bindParam(':id_produit', $produit_id, PDO::PARAM_INT);
                $req_prod_price->execute();
                $produit_info = $req_prod_price->fetch(PDO::FETCH_ASSOC);
                $prix_tot += $produit_info['prix'] * $quantite;
            }
    
            
            $req_update_prix_tot = $this->db->con->prepare('UPDATE facture SET prix = :prix_tot WHERE id = :id_facture');
            $req_update_prix_tot->bindParam(':prix_tot', $prix_tot, PDO::PARAM_STR);
            $req_update_prix_tot->bindParam(':id_facture', $facture_id, PDO::PARAM_INT);
            $req_update_prix_tot->execute();
    
            echo "Facture modifiée avec succès!<br>";
        }
    }
    public function addFacture(){
        $clients=$this->fm->getClients();
        $produits=$this->fm->getProduits();
        $f=new FactureView();
        $f->addForm($clients,$produits);
        if (isset($_POST['Ajouter_facture']) && isset($_POST['id_client']) && !empty($_POST['produits']) && !empty($_POST['quantites'])) {
            $client_id = $_POST['id_client'];
            $produits = $_POST['produits'];
            $quantites = $_POST['quantites'];
    
           
            $prix_tot = 0;
            foreach ($produits as $produit_id) {
                $quantite = $quantites[$produit_id];
                $req_produit = $this->db->con->prepare('SELECT prix, quantite FROM produit WHERE id = :id_produit');
                $req_produit->execute(['id_produit' => $produit_id]);
                $produit = $req_produit->fetch(PDO::FETCH_ASSOC);
                
                if ($produit['quantite'] >= $quantite) {
                    $prix_tot += $produit['prix'] * $quantite;
                } else {
                    echo "Stock insuffisant pour le produit {$produit['nom']}<br>";
                    exit; 
                }
            }
    
            
            $req_facture = $this->db->con->prepare('INSERT INTO facture(id_client, prix) VALUES(:id_client, :prix_tot)');
            $req_facture->bindParam(':id_client', $client_id, PDO::PARAM_INT);
            $req_facture->bindParam(':prix_tot', $prix_tot, PDO::PARAM_STR);
            $req_facture->execute();
            
           
            $facture_id = $this->db->con->lastInsertId();
    
           
            foreach ($produits as $produit_id) {
                $quantite = $quantites[$produit_id];
    
                
                $req_produit_facture = $this->db->con->prepare('INSERT INTO produitFacture(id_facture, id_produit, quantite) VALUES(:id_facture, :id_produit, :quantite)');
                $req_produit_facture->execute([
                    'id_facture' => $facture_id,
                    'id_produit' => $produit_id,
                    'quantite' => $quantite
                ]);
    
                
                $req_update_stock = $this->db->con->prepare('UPDATE produit SET quantite -= :quantite WHERE id = :id_produit');
                $req_update_stock->execute([
                    'quantite' => $quantite,
                    'id_produit' => $produit_id
                ]);
            }
    
            echo "Facture ajoutée avec succès!<br>";
            
        }
    }
    public function addClient(){
        $v=new FactureView();
        $v->addFormClient();
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
                    echo "<script>
                    window.history.go(-2); 
                </script>"; 
            } else {
                echo "Erreur lors de l'ajout du client.";
            }
        }
    }
}
?>