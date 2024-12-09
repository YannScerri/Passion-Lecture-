<?php
/// Auteur : Maxime Pelloquin
/// Date : 25.11.2024
/// Ecole : ETML
/// Description : Page web incluant un formulaire permettant d'ajouter un utlisateur

    include("./Database.php");
    $db = new Database();
    $users = $db->getAllUsers();
    echo "<pre>";
    var_dump($users);
    echo "</pre>";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
</head>
<body>

    <h2>Ajouter un nouvel utilisateur</h2>

    <form action="addUserAction.php" method="POST">
        <label for="pseudo">Login :</label>
        <input type="text" id="pseudo" name="pseudo" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        
        <label for="administrator">Administrateur :</label>
        <select id="administrator" name="administrator" required>
            <option value="1">Oui</option>
            <option value="0">Non</option>
        </select>
        
        <button type="submit">Ajouter l'utilisateur</button>
    </form>
    <p><a href="index.php">Retour à la page d'accueil</a></p>
</body>
</html>