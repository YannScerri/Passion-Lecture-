<?php
/// Auteur : Maxime Pelloquin
/// Date : 07.11.2024
/// Ecole : ETML
/// Description : Ce script gère l'authentification de l'utilisateur en vérifiant ses identifiants et en démarrant une session s'il est authentifié.

include("./Database.php");
session_start();

// Vérifie si la requête est envoyée par la méthode POST (lorsque le formulaire de connexion est soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['pseudo'];
    $password = $_POST['password'];
    
    $db = new Database();
    $user = $db->getUserByLogin($user);
    
    // Vérifie si l'utilisateur existe et si le mot de passe correspond
    if ($user && password_verify($password, $user['password'])) {
        // L'utilisateur est authentifié, créer une session
        $_SESSION['user'] = [
            'pseudo' => $user['pseudo'],
            'administrator' => $user['administrator']
        ];

        
        // Redirige l'utilisateur vers la page d'accueil après une connexion réussie
        header("Location: index.php");
        exit();
    } else {
        // Message d'erreur en cas de login ou mot de passe incorrect
        echo "Login ou mot de passe incorrect.";
        echo "<a href=\"index.php\">Accueil</a>";
    }
}
?>