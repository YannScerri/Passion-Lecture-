<?php
/*
 * ETML
 * Auteurs : Yann Scerri, Dany Carneiro, Maxime Pelloquin     
 * Date de création du fichier : 18.11.2024
 * Description : Fichier addBook permettant d'ajouter un nouveau livre
 */

 include("Database.php");  
$db = new Database; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {     
    // Récupération des données du formulaire
    $title = $_POST['title'] ?? null;
    $excerpt = $_POST['bookExcerpt'] ?? null;
    $summary = $_POST['bookSummary'] ?? null;
    $year = $_POST['year'] ?? null;
    $pagesNumber = $_POST['pagesNumber'] ?? null;
    $userId = 1; // Remplacez par l'ID utilisateur actuel (ex. via session)
    $categoryId = $_POST['category'] ?? null; // Assurez-vous de convertir cette donnée en ID
    $editorId = $_POST['Editor'] ?? null; // Assurez-vous de convertir cette donnée en ID
    $authorId = $_POST['fullname'] ?? null; // Assurez-vous de convertir cette donnée en ID

    // Gestion de l'upload de l'image
    if (isset($_FILES['bookCover']) && $_FILES['bookCover']['error'] === UPLOAD_ERR_OK) {
        $coverTmpName = $_FILES['bookCover']['tmp_name'];
        $coverName = uniqid() . "_" . $_FILES['bookCover']['name'];
        $coverDestination = "uploads/" . $coverName;

        if (!move_uploaded_file($coverTmpName, $coverDestination)) {
            $coverDestination = null; // En cas d'échec
        }
    } else {
        $coverDestination = null; // Aucun fichier n'a été uploadé
    }

    // Préparation des données à insérer
    $data = [
        'titre' => $title,
        'extrait' => $excerpt,
        'resume' => $summary,
        'annee' => $year,
        'image' => $coverDestination,
        'nombre_pages' => $pagesNumber,
        'utilisateur_id' => $userId,
        'categorie_id' => $categoryId,
        'editeur_id' => $editorId,
        'auteur_id' => $authorId,
    ];

    // Appel à la méthode insertBook
    $result = $db->insertBook($data);

    if ($result) {
        echo "Le livre a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du livre.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link href="./css/style.css" rel="stylesheet">-->
    <title>Page d'ajout</title>
    <style>
        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .form-main {
            width: 70%;
        }
        .form-image {
            width: 25%;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="titre-header">
            <h1>Passion Lecture</h1>
        </div>
        <nav>
            <a href="#">Accueil</a>
            <a href="#">Liste des livres</a>
        </nav>
    </div>
    <div class="bookinfos"></div>
    <h2>Ajouter un livre</h2>
    <div class="form-container">
        <!-- Formulaire principal -->
        <form class="form-main" action="#">
            <p>
                <label for="fullName"></label>
                <input type="text" name="fullname" id="fullname" placeholder="Prénom et nom">
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
                <input type="text" name="category" id="category" placeholder="Catégorie">
            </p>
            <p>
                <label for="bookSummary"></label>
                <textarea name="bookSummary" id="bookSummary" placeholder="Résumé de l'ouvrage"></textarea>
            </p>
            <p>
                <label for="bookExcerpt"></label>
                <input type="url" name="bookExcerpt" id="bookExcerpt" placeholder="Lien vers extrait">
            </p>
            <p>
                <button type="submit">Ajouter le livre</button>
            </p>
        </form>

        <!-- Section pour l'ajout de l'image -->
        <div class="form-image">
            <h3>Image de couverture</h3>
            <p>
                <label for="bookCover"></label>
                <input type="file" name="bookCover" id="bookCover" accept="image/*">
            </p>
            <p>
                Formats acceptés : JPG, PNG, GIF
            </p>
        </div>
    </div>
    <footer>
        <p>Copyright Dany Carneiro, Yann Scerri, Maxime Pelloquin, Hanieh Mohajerani - Passion Lecture - 2024</p>
    </footer>
</body>
</html>
