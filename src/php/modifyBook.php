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

//résupère les informations du livre à modifier
$bookId = $_GET['bookId'];

$book = $db->getBook($bookId);

$author = $db->getAuthorName($book['auteur_id']);

$editor = $db->getEditorName($book['editeur_id']);

$bookCategory = $db->getCategoryName($book['categorie_id']);

//récupère uniquement l'année de la date du livre
$year = DateTime::createFromFormat('Y-m-d', $book["annee"])->format('Y');

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
    <h2>Modifier un livre</h2>
    <div class="form-container">
        <!-- Formulaire principal -->
        <form class="form-main" action="./modifyBookAction.php" method="POST" enctype="multipart/form-data">
            <?php
            $html = "";
            $html .= '<input type="hidden" id="bookId" name="bookId" value="' . $bookId . '">';
            $html .= "<p>";
            $html .= '<label for="firstName"></label>';
            $html .= '<input type="text" name="firstName" id="firstName" placeholder="Prénom de l\'auteur" value="' . $author['prenom'] . '">';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="lastName"></label>';
            $html .= '<input type="text" name="lastName" id="lastName" placeholder="Nom de l\'auteur" value="' . $author['nom'] . '">';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="title"></label>';
            $html .= '<input type="text" name="title" id="title" placeholder="Titre du livre" value="' . $book['titre'] . '">';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="Editor"></label>';
            $html .= '<input type="text" name="Editor" id="Editor" placeholder="Editeur" value="' . $editor['nom'] . '">';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="year"></label>';
            $html .= '<input type="text" name="year" id="year" placeholder="Année de publication" value="' . $year . '">';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="pagesNumber"></label>';
            $html .= '<input type="text" name="pagesNumber" id="pagesNumber" placeholder="Nombre de pages" value="' . $book['nombre_pages'] . '">';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="category"></label>';
            $html .= '<select name="category" id="category">';
            $html .= '<option value="' . $book['categorie_id'] . '">' . $bookCategory['nom'] . '</option>';

            $id = "";
            $categoryName = "";
            //affichage de chaque catégorie présente dans la base de données
            foreach($categories as $category){

                if($category['categorie_id'] == $book['categorie_id']){
                    continue;
                }

                $html .= '<option value="' . $category["categorie_id"] . '">' . $category["nom"] . '</option>';
            }
                    
            $html .= '</select>';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="bookSummary"></label>';
            $html .= '<textarea name="bookSummary" id="bookSummary" placeholder="Résumé de l\'ouvrage">'. $book['resume'] . '</textarea>';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<label for="bookExcerpt"></label>';
            $html .= '<input type="url" name="bookExcerpt" id="bookExcerpt" placeholder="Lien vers extrait" value="' . $book['extrait'] . '">';
            $html .= '</p>';
            $html .= '<div class="form-image">';
            $html .= '<h3>Image de couverture</h3>';
            $html .= '<p>';
            $html .= '<label for="bookCover"></label>';
            $html .= '<input type="file" name="bookCover" id="bookCover" accept="image/*" value="' . $book['image'] . '">';
            $html .= '</p>';
            $html .= '<p>';
            $html .= 'Formats acceptés : JPG, PNG, GIF';
            $html .= '</p>';
            $html .= '<p>';
            $html .= '<button type="submit">Modifier le livre</button>';
            $html .= '</p>';

            echo $html;
            ?>
        </form>

        </div>
    </div>
    <?php include('./footer.php')?>
</body>
</html>