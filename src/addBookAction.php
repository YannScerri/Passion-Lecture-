<?php
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 02.12.2024
 * Description : Action d'ajout d'un livre
 */

session_start();

include('./Database.php');

$db = new Database();

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les valeurs du formulaire
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $title = $_POST['title'];
    $editor = $_POST['Editor'];
    $year = $_POST['year'];
    $pagesNumber = $_POST['pagesNumber'];
    $category = $_POST['category'];
    $bookSummary = $_POST['bookSummary'];
    $bookExcerpt = $_POST['bookExcerpt'];
    $image = $_FILES['bookCover'];

    //Vérifie si l'auteur existe déja. Si ce n'est pas le cas, crée un nouvel auteur puis récupère son id
    if(!$db->doesAuthorExists($firstName, $lastName)){

        $db->addAuthor($firstName, $lastName);
    }

    $authorID = $db->getAuthorID($firstName, $lastName);


    //Vérifie si l'éditeur existe déja. Si ce n'est pas le cas, crée un nouvel éditeur puis récupère son id
    if($db->doesEditorExists($editor)){

        $db->addEditor($editor);
    }

    $editorId = $db->getEditorID($editor);


    //récupère l'identifiant de l'utilisateur
    $userID = $_SESSION['user']['id'];

    //met le bon format de date
    $year = $year . '-01-01';


    // Gestion de l'upload de l'image
    if (isset($_FILES['bookCover']) && $_FILES['bookCover']['error'] === 0) {
        $dest = '../images/' . date("YmdHis");
        $dest .= $image['name'];
        move_uploaded_file($image['tmp_name'], $dest);
    }


    // Insérer les données dans la base
    $db->insertBook($title, $bookExcerpt, $bookSummary, $year, $dest, $pagesNumber, $userID, $category, $editorId, $authorID);

    // Redirection après l'ajout
    header("Location: index.php");
} ?>