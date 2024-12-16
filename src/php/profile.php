<?php
/*
 * ETML
 * Auteur : Dany Carneiro, Maxime Pelloquin, Yann Scerri, Hanieh Mohajerani
 * Date : 25.11.2024
 * Description : Fichier profile permettant de voir son profil ou le profil de quelqu'un d'autre
 */

// Inclure la classe Database
require_once 'Database.php';

// Simuler une session utilisateur si aucune n'existe
if (!isset($_SESSION['userId'])) {
    $_SESSION['userId'] = 1; // ID utilisateur simulé (exemple : 1)
}

// Initialiser l'objet Database
$db = new Database();

// Déterminer quel utilisateur afficher (utilisateur connecté ou autre)
$userId = $_SESSION['userId'];
$isVisiting = false; // Indique si on visite un autre profil

if (isset($_GET['id']) && is_numeric($_GET['id'])) { //vérification de l'id 
    $userId = intval($_GET['id']); // Profil à visiter
    $isVisiting = ($userId !== $_SESSION['userId']); // Vérifie si c'est un profil différent
}


// Récupérer les données de l'utilisateur
$userData = $db->getUserById($userId);

// Vérifier si l'utilisateur existe
if (!$userData) {
    die("Utilisateur non trouvé.");
}

// Récupérer les livres ajoutés et notés par l'utilisateur
$uploadedBooks = $db->getBooksUploadedByUser($userId);
$ratedBooks = $db->getBooksRatedByUser($userId);

// Possibilité de changer le pseudo (uniquement pour le profil de l'utilisateur connecté)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newPseudo']) && !$isVisiting) {
    $newPseudo = htmlspecialchars($_POST['newPseudo']);
    $db->updateUserPseudo($_SESSION['userId'], $newPseudo);
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
    <!-- Indication sur l'état de connexion -->
    <?php if ($isVisiting): ?>
        <p>Vous visitez le profil de <strong><?php echo htmlspecialchars($userData['pseudo']); ?></strong>.</p>
    <?php else: ?>
        <p>Vous êtes connecté en tant que <strong><?php echo htmlspecialchars($userData['pseudo']); ?></strong>.</p>
    <?php endif; ?>

    <h1>Profil de <?php echo htmlspecialchars($userData['pseudo']); ?> </h1> 
    
    <!-- Section d'informations utilisateur -->
    <p>Nombre d'avis postés : <?php echo $userData['review_count']; ?></p>
    <p>Nombre de livres uploadés : <?php echo $userData['upload_count']; ?></p>

    <!-- Formulaire de modification du pseudo (uniquement pour l'utilisateur connecté) -->
    <?php if (!$isVisiting): ?>
        <form method="POST">
            <label for="newPseudo">Modifier votre pseudo :</label>
            <input type="text" name="newPseudo" id="newPseudo" required>
            <button type="submit">Valider</button>
        </form>
    <?php endif; ?>

    <!-- Affichage des livres ajoutés s'il y'en a -->
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

    <!-- Affichage des livres notés s'il y'en a -->
<h2>Livres notés</h2>
<?php if (!empty($ratedBooks)): ?>
    <ul>
        <?php foreach ($ratedBooks as $book): ?>
            <li>
                <h3><?php echo htmlspecialchars($book['titre']); ?></h3>
                <p><strong>Extrait :</strong> <?php echo htmlspecialchars($book['extrait']); ?></p>
                <p><strong>Nombre de pages :</strong> <?php echo $book['nombre_pages']; ?></p>
                <p><strong>Note :</strong> <?php echo $book['note']; ?>/5</p>
                <img src="images/<?php echo htmlspecialchars($book['image']); ?>" alt="Image du livre" style="width:100px; height:auto;">
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?> 
    <p>Aucun livre noté.</p>
<?php endif; ?>

<hr>
<footer>
    <p>Copyright Dany Carneiro, Yann Scerri, Maxime Pelloquin, Hanieh Mohajerani - Passion Lecture - 2024</p>
</footer>
</body>
</html>
