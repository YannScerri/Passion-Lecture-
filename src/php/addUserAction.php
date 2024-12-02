<?php
/// Auteur : Maxime Pelloquin
/// Date : 25.11.2024
/// Ecole : ETML
/// Description : Code php ajoutant un utilisateur à la base de donnée

// Inclure la classe Database
include('./Database.php');

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $administrator = $_POST['administrator'];

    // Créer une instance de la classe Database
    $db = new Database();

    // Appeler la fonction addUser pour ajouter l'utilisateur
    $db->addUser($pseudo, $password, $administrator);

    // Redirection ou message de succès
    echo "Utilisateur ajouté avec succès !";

    // redirection vers la page d'ajout d'utilisateur
    header('Location: ./index.php');
}
?>
