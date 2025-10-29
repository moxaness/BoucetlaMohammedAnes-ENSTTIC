<?php
class UserView {
    public function display($users) {
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Liste des Utilisateurs</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
            <h2 style='color: #007bff;'>Liste des utilisateurs</h2>
            <a href='?action=ajouterUtilisateur' style='text-decoration: none; color: #007bff; margin-right: 15px;'>Ajouter un utilisateur</a>
            <a href='/boucetlaMohammedAnes/application/Controleurs/ControleurGen.php' style='text-decoration: none; color: #007bff;'>Retour à l'accueil</a>
            <table style='width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);'>
                <tr style='background: #007bff; color: #fff;'>
                    <th style='padding: 10px; border: 1px solid #ddd;'>ID</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Username</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Password</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Role</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Action</th>
                </tr>";
        foreach ($users as $user) {
            echo "
                <tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$user['id']}</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$user['username']}</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$user['password']}</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$user['role']}</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>
                        <a href='?action=modifierUtilisateur&id={$user['id']}' style='color: #007bff; text-decoration: none;'>Modifier</a> | 
                        <a href='?action=supprimerUtilisateur&id={$user['id']}' style='color: #ff5722; text-decoration: none;'>Supprimer</a>
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
        <h2 style='color: #007bff;'>Ajouter un utilisateur</h2>
        <form action='' method='post' style='background: #fff; padding: 20px; width: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 5px;'>
            <label style='display: block; margin-bottom: 10px;'>Username: 
                <input type='text' name='username' required style='width: 100%; padding: 10px; margin-top: 5px;'>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Mot de passe: 
                <input type='password' name='password' required style='width: 100%; padding: 10px; margin-top: 5px;'>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Le rôle de l'utilisateur: 
                <select name='role' required style='width: 100%; padding: 10px; margin-top: 5px;'>
                    <option value='admin'>Admin</option>
                    <option value='agentSup'>Agent Superviseur</option>
                    <option value='agent'>Agent normal</option>
                </select>
            </label>
            <input type='submit' name='Ajouter_utilisateur' value='Ajouter utilisateur' style='background: #007bff; color: #fff; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%;'>
        </form>
        <a href='?action=gestionUtilisateur' style='text-decoration: none; color: #007bff; display: block; margin-top: 10px;'>Retour à la liste des utilisateurs</a>";
    }

    public function editForm($user) {
        echo "
        <h2 style='color: #007bff;'>Modifier l'utilisateur</h2>
        <form action='' method='post' style='background: #fff; padding: 20px; width: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 5px;'>
            <input type='hidden' name='id' value='{$user['id']}'>
            <label style='display: block; margin-bottom: 10px;'>Username: 
                <input type='text' name='username' value='{$user['username']}' required style='width: 100%; padding: 10px; margin-top: 5px;'>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Mot de passe: 
                <input type='password' name='password' value='{$user['password']}' required style='width: 100%; padding: 10px; margin-top: 5px;'>
            </label>
            <label style='display: block; margin-bottom: 10px;'>Le rôle de l'utilisateur: 
                <select name='role' required style='width: 100%; padding: 10px; margin-top: 5px;'>
                    <option value='admin'" . ($user['role'] == 'admin' ? ' selected' : '') . ">Admin</option>
                    <option value='agentSup'" . ($user['role'] == 'agentSup' ? ' selected' : '') . ">Agent Superviseur</option>
                    <option value='agent'" . ($user['role'] == 'agent' ? ' selected' : '') . ">Agent normal</option>
                </select>
            </label>
            <input type='submit' name='Modifier_utilisateur' value='Modifier utilisateur' style='background: #007bff; color: #fff; padding: 10px; border: none; border-radius: 5px; cursor: pointer; width: 100%;'>
        </form>
        <a href='?action=gestionUtilisateur' style='text-decoration: none; color: #007bff; display: block; margin-top: 10px;'>Retour à la liste des utilisateurs</a>";
    }
}
?>
