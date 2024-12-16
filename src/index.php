<?php 
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 19.11.2024
 * Description : Page d'acceuil de passion lecture comprenant une description du site et une liste des 5 derniers livres ajoutés
 */

session_start();

 include './Database.php';

 $db = new Database();

 $lastBooks = $db->get5LastBooks(); 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" media="screen">
</head>
<body>
    <!-- inclusion du header-->
    <?php include("./header.php");?>

    <h2>Bienvenue à Passion Lecture ! </h2>
    <div class="welcomeText">
        <p>Ce site vous permet de noter les livres que vous savez lus et de partager vos notes au monde entier ! <br>
            Vous pouvez rechercher des livres en cliquant sur "Liste des livres" et parcourir les différents livres que vous pouvez noter. Si le livre que vous souhaiter noter n'est pas présent, pas de problème, vous pouvez ajouter vous-même les livres que vous souhaitez. <br>
        </p>
    </div>

    <h2>Les 5 derniers livres ajoutés</h2>
    <div class="lastBooks">
        <?php
            //Affichage des 5 derniers livres
            foreach($lastBooks as $book){

                $html = '<div class="book">';
                $html .= '<img src="' . $book["image"] . '" alt="couverture du livre" class="bookImg">';
                $html .= "<a href='./DetailLivre.php?id=" . $book['ouvrage_id'] . "'><h3 class='bookTitle'>" . $book["titre"] . '</h3></a>';
                $html .= '<p class="bookAuthor">Auteur : ' . $book["prenom"] . " " . $book["nom"] . '</p>';
                $html .= "<a href='./profile.php?id=" . $book['utilisateur_id'] . "'<p class='bookUser'>Ajouté par : " . $book["pseudo"] . '</p>';
                echo var_dump($book);
                $html .= '</div>';

                echo $html;
            }
        ?>
    </div>


    <!-- inclusion du footer-->
    <?php include("./footer.php")?>
</body>
</html>