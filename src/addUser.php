<?php
/// Auteur : Maxime Pelloquin
/// Date : 25.11.2024
/// Ecole : ETML
/// Description : Page web incluant un formulaire permettant d'ajouter un utlisateur

    include("./Database.php");
    $db = new Database();
    $users = $db->getAllUsers();
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

    <form action="process_register.php" method="POST">
    <label for="pseudo">Pseudo :</label>
    <input type="text" id="pseudo" name="pseudo" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <label for="admin">Administrateur :</label>
        <select id="admin" name="admin" required>
            <option value="1">Oui</option>
            <option value="0">Non</option>
        </select>

    <label for="date_entree">Date d'entrée :</label>
    <input type="date" id="date_entree" name="date_entree" required>

    <button type="submit">Créer un compte</button>
</form>

    <p><a href="index.php">Retour à la page d'accueil</a></p>
</body>
</html>

