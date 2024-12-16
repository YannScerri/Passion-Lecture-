<?php
/**
 * ETML
 * Auteur: Dany Carneiro
 * Date: 16.12.2024
 * Description: Déconnexion de l'utilisateur
 */

 session_start();

 if(isset($_SESSION['user']) && $_SESSION['user']['isConnected']){
    $_SESSION['user']['id'] = null;
    $_SESSION['user']['pseudo'] = null;
    $_SESSION['user']['administrator'] = null;
    $_SESSION['user']['isConnected'] = false;

 }

 header('Location: ./index.php');

?>