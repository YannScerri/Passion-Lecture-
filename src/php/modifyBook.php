<?php
/*
 * ETML
 * Auteur : Dany Carneiro
 * Date : 03.12.2024
 * Description : Fichier permettant de modifier les données d'un livre
 */


// Inclure la base de données
include("Database.php");

// Créer une instance de la base de données
$db = new Database;

// Récupérer les catégories
$categories = $db->getAllCategories();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Page d'ajout</title>
</head>
<body>
    <?php include('./header.php')?>
    <div class="bookinfos"></div>
    <h2>Ajouter un livre</h2>
    <div class="form-container">
        <!-- Formulaire principal -->
        <form class="form-main" action="./addBookAction.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="firstName"></label>
                <input type="text" name="firstName" id="firstName" placeholder="Prénom de l'auteur">
            </p>
            <p>
                <label for="lastName"></label>
                <input type="text" name="lastName" id="lastName" placeholder="Nom de l'auteur">
            </p>
            <p>
                <label for="title"></label>
                <input type="text" name="title" id="title" placeholder="Titre du livre">
            </p>
            <p> 
                <label for="Editor"></label>
                <input type="text" name="Editor" id="Editor" placeholder="Editeur">
            </p>
            <p>
                <label for="year"></label>
                <input type="text" name="year" id="year" placeholder="Année de publication">
            </p>
            <p>
                <label for="pagesNumber"></label>
                <input type="text" name="pagesNumber" id="pagesNumber" placeholder="Nombre de pages">
            </p>
            <p>
                <label for="category"></label>
                <select name="category" id="category">
                    <option value="">--Choisisez une catégorie--</option>
                    <?php

                    $id = "";
                    $categoryName = "";
                    //affichage de chaque catégorie présente dans la base de données
                    foreach($categories as $category){

                            echo '<option value="' . $category["categorie_id"] . '">' . $category["nom"] . '</option>';
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="bookSummary"></label>
                <textarea name="bookSummary" id="bookSummary" placeholder="Résumé de l'ouvrage"></textarea>
            </p>
            <p>
                <label for="bookExcerpt"></label>
                <input type="url" name="bookExcerpt" id="bookExcerpt" placeholder="Lien vers extrait">
            </p>
                <div class="form-image">
                <h3>Image de couverture</h3>
                <p>
                    <label for="bookCover"></label>
                    <input type="file" name="bookCover" id="bookCover" accept="image/*">
                </p>
                <p>
                    Formats acceptés : JPG, PNG, GIF
                </p>
            <p>
                <button type="submit">Ajouter le livre</button>
            </p>
        </form>

        </div>
    </div>
    <?php include('./footer.php')?>
</body>
</html>