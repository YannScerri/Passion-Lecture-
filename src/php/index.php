<?php 
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 19.11.2024
 * Description : Page d'acceuil de passion lecture comprenant une description du site et une liste des 5 derniers livres ajoutés
 */


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

    <div class="intro">
        <p>Passion Lecture est un site vous permettant de donner une note à un livre que vous avez lu et de le partager au monde ! <br>
            Vous pouvez également voir les notes que d'autres utilisateurs ont donné afin de vous renseigner sur un livre que vous voudriez lire.
        </p>
    </div>

    <div class="last-books">
        <div class="book">
            
        </div>
    </div>



    <!-- inclusion du footer-->
    <?php include("./footer.php")?>
</body>
</html>