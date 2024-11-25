<?php 
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 19.11.2024
 * Description : Page d'acceuil de passion lecture comprenant une description du site et une liste des 5 derniers livres ajoutés
 */

 include 'Database.php';

 $db = new Database();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen">
</head>
<body>
    <!-- inclusion du header-->
    <?php include("./header.php")?>

    <h2>Bienvenue à Passion Lecture ! </h2>
    <p>Ce site vous permet de noter les livres que vou savez lus et de partager vos notes au monde entier ! <br>
        Vous pouvez rechercher des livres en cliquant sur "Liste de livres" et parcourir les différents livres que vous pouvez noter. Si le livre que vous souhaiter noter n'est pas présent, pas de problème, vous pouvez ajouter vous-même les livres que vous souhaitez. <br>
    </p>



    <!-- inclusion du footer-->
    <?php include("./footer.php")?>
</body>
</html>