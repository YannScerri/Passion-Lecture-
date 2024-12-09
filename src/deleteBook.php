<?php
/**
 * ETML
 * Auteur: Dany Carneiro Jeremias
 * Date: 26.11.2024
 * Description: Fichier qui effectue la suppression d'un livre
 */

 session_start();

 include('./Database.php');

 $db = new Database();

 $id = $_GET['idBook'];

 unlink($db->getBookImage($id));

 $db-> deleteBook($id);

 header('Location: ./index.php');
?>