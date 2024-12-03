<?php
/*
 * ETML
 * Auteur : Dany Carneiro, Maxime Pelloquin, Yann Scerri, Hanieh Mohajerani
 * Date : 25.11.2024
 * Description : Fichier profile permettant de voir son profil ou le profil de quelqun d'autre (version avec session)
 */

session_start(); // Démarre la session

// Inclure la classe Database
require_once 'Database.php';

// Simuler une session utilisateur si aucune n'existe
if (!isset($_SESSION['userId'])) {
    $_SESSION['userId'] = 1; // ID utilisateur simulé (exemple : 1)
}

// Vérifier si un utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    die("Vous devez être connecté pour accéder à cette page.");
}

// Initialiser l'objet Database
$db = new Database();

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['userId'];

// Récupérer les données de l'utilisateur
$userData = $db->getUserById($userId);

// Vérifier si l'utilisateur existe
if (!$userData) {
    die("Utilisateur non trouvé.");
}

// Récupérer les livres ajoutés et notés par l'utilisateur
$uploadedBooks = $db->getBooksUploadedByUser($userId);
$ratedBooks = $db->getBooksRatedByUser($userId);

// Possibilité de changer le pseudo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newPseudo'])) {
    $newPseudo = htmlspecialchars($_POST['newPseudo']);
    $db->updateUserPseudo($userId, $newPseudo);
    header("Location: profile.php"); // Recharger la page 
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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
<hr>
    <h1>Profil de <?php echo htmlspecialchars($userData['pseudo']); ?> </h1> 
    
    <!-- Section d'informations utilisateur -->
    <h2></h2>
    <p>Nombre d'avis postés : <?php echo $userData['review_count']; ?></p>
    <p>Nombre de livres uploadés : <?php echo $userData['upload_count']; ?></p>

    <!-- Formulaire de modification du pseudo -->
    <form method="POST">
        <label for="newPseudo">Modifier votre pseudo :</label>
        <input type="text" name="newPseudo" id="newPseudo" required>
        <button type="submit">Valider</button>
    </form>

    <!-- Affichage des livres ajoutés -->
    <h2>Livres ajoutés</h2>
    <?php if (!empty($uploadedBooks)): ?>
        <ul>
            <?php foreach ($uploadedBooks as $book): ?>
                <li>
                    <h3><?php echo htmlspecialchars($book['titre']); ?></h3>
                    <p><strong>Extrait :</strong> <?php echo htmlspecialchars($book['extrait']); ?></p>
                    <p><strong>Nombre de pages :</strong> <?php echo $book['nombre_pages']; ?></p>
                    <img src="images/<?php echo htmlspecialchars($book['image']); ?>" alt="Image du livre" style="width:100px; height:auto;">
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun livre ajouté.</p>
    <?php endif; ?>

    <!-- Affichage des livres notés -->
    <h2>Livres notés</h2>
    <ul>
        <?php foreach ($ratedBooks as $book): ?>
            
            <li><?php echo htmlspecialchars($book['titre']); ?> - Note : <?php echo $book['note']; ?></li>
            
        <?php endforeach; ?>
    </ul>
<hr>
    <footer>
    <p>Copyright Dany Carneiro, Yann Scerri, Maxime Pelloquin, Hanieh Mohajerani - Passion Lecture - 2024</p>
</footer>
</body>
</html>
