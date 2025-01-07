<?php
/// Auteur :Dany Carneiro
/// Date : 07.01.2025
/// Ecole : ETML
/// Description : Page web incluant un formulaire permettant d'ajouter un utlisateur adminisatrateur

    include("./Database.php");
    $db = new Database();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un administrateur</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <h2>Ajouter un nouvel administrateur</h2>

    <form class = form-container action="createAdminAction.php" method="POST">
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Créer un compte</button>
    </form>

    <p><a href="index.php">Retour à la page d'accueil</a></p>
</body>
</html>