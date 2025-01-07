<?php
/// Auteur : Dany Carneiro
/// Date : 07.01.2025
/// Ecole : ETML
/// Description : Code php ajoutant un administrateur à la base de donnée

// Inclure la classe Database
include('./Database.php');

// Créer une instance de la classe Database
$db = new Database();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $admin= 1;


    // Appeler la fonction addUser pour ajouter l'utilisateur
    $db->addUser($pseudo, $password, $admin);

    // Redirection ou message de succès
    echo "Utilisateur ajouté avec succès !";

    // redirection vers la page d'ajout d'utilisateur
    header('Location: ./index.php');
}
?>