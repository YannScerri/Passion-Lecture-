<?php
/// Auteur : Maxime Pelloquin
/// Date : 25.11.2024
/// Ecole : ETML
/// Description : Code php ajoutant un utilisateur à la base de donnée

// Inclure la classe Database
include('./Database.php');

// Créer une instance de la classe Database
$db = new Database();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $admin = intval($_POST['admin']); // Convertir en entier
    $date_entree = $_POST['date_entree']; // Date fournie par l'utilisateur


    // Appeler la fonction addUser pour ajouter l'utilisateur
    $db->addUser($pseudo, $password, $admin, $date_entree);

    // Redirection ou message de succès
    echo "Utilisateur ajouté avec succès !";

    // redirection vers la page d'ajout d'utilisateur
    header('Location: ./index.php');
}
?>
