<?php
/**
 * ETML
 * Auteur: Dany Carneiro
 * Date: 09.12.2024
 * Description: Effectuer l'action de la modification des informations d'un livre
 */

 session_start();

 include('./Database.php');

 $db = new Database();

 $book = $db->getBook($_POST['bookId']);

 $year = $_POST["year"] . "-01-01";

 $user = $_SESSION['user']['id'];

 if(!isset($_POST["bookCover"])){
    $image = $book["image"];
 } else{
    $image = $_POST["bookCover"];
 }

 //si l'auteur rentré n'existe pas, le crée
 if(!$db->doesAuthorExists($_POST["firstName"], $_POST["lastName"])){
    $db->addAuthor($_POST["firstName"], $_POST["lastName"]);
 }

 //si l'editeur n'existe pas, le crée
 if(!$db->doesEditorExists($_POST["Editor"])){
    $db->addEditor($_POST["Editor"]);
 }

 $editor = $db->getEditorID($_POST['Editor']);

 $author = $db->getAuthorID($_POST["firstName"], $_POST["lastName"]);

 //modification du livre
 $db->modifyBook($_POST["bookId"], $_POST["title"], $_POST["bookExcerpt"], $_POST["bookSummary"], $year, $image, $_POST["pagesNumber"], $user, $_POST["category"], $editor, $author);

 header('Location: ./index.php');
?>