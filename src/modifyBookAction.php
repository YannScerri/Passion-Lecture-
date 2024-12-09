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

 $image = $_FILES['bookCover'];

 //si aucune image n'a été ajoutée dans le formulaire, l'image déjà dans la base de données est sélectionnée
 //si une image est rentrée, supprime l'ancienne et stocke la nouvelle
if (isset($_FILES['bookCover']) && $_FILES['bookCover']['error'] === 0) {
    $dest = './images/' . date("YmdHis");
    $dest .= $image['name'];
    move_uploaded_file($image['tmp_name'], $dest);
    unlink($db->getBookImage($_POST['bookId']));
} else {
    $dest = $book["image"];
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
 $db->modifyBook($_POST["bookId"], $_POST["title"], $_POST["bookExcerpt"], $_POST["bookSummary"], $year, $dest, $_POST["pagesNumber"], $user, $_POST["category"], $editor, $author);

 header('Location: ./index.php');
?>