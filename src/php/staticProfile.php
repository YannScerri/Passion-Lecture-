<?php
/*
 * ETML
 * Auteur : Dany Carneiro, Maxime Pelloquin, Yann Scerri, Hanieh Mohajerani
 * Date : 25.11.2024
 * Description : Fichier staticProfile permettant de voir son profil ou le profil de quelqun d'autre (version sans session)
 */

 include("Database.php");
 $db = new Database(false);

 //simuler un utilisateur
 $userID = 1;
 $user = $db->getUSerByID($userID);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $newPseudo = $_POST['pseudo'];
}


// ID de l'utilisateur simulé
$userId = 1; // Exemple statique, à remplacer par un système de sessions

// Récupérer les données de l'utilisateur
$userData = $db->getUserById($userId);

// Vérifier si les données de l'utilisateur ont été trouvées
if (!$userData) {
    die("Utilisateur non trouvé.");
}

// Récupérer un livre ajouté et un livre noté
$booksUploaded = $db->getBooksUploadedByUser($userId);
$booksRated = $db->getBooksRatedByUser($userId);

// Obtenir le premier livre ajouté (s'il existe)
$bookUploaded = $booksUploaded[0] ?? null;

// Obtenir le premier livre noté (s'il existe)
$bookRated = $booksRated[0] ?? null;

// Si le formulaire est soumis pour changer le pseudo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newPseudo'])) {
    $newPseudo = htmlspecialchars($_POST['newPseudo']); // Protéger les entrées utilisateur
$db->updateUserPseudo($userId, $newPseudo);
    header("Location: profile.php"); // Recharge la page pour refléter les modifications
    exit();
    header("Location: profile.php"); // Recharger la page pour éviter la resoumission du formulaire
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <link rel="stylesheet" href="css/style.css">
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
            <a href="logout.php">Déconnexion</a>
        </nav>
<div class="header">
    <div class="titre-header">
        <h1>Passion Lecture</h1>
</div>

    <main>
        <h2><?php echo htmlspecialchars($user['pseudo']); ?></h2>

        <div class="user-details">
            <form method="POST" action="profile.php">
                <p>Pseudo :
                    <input type="text" name="pseudo" value="<?php echo htmlspecialchars($user['pseudo']); ?>">
                </p>
                <p>Nombre d'avis : <?php echo $user['review_count']; ?></p>
                <p>Nombre d'ouvrages proposés : <?php echo $user['upload_count']; ?></p>
                <button type="submit">Valider</button>
                <button type="button" onclick="window.location.href='index.php'">Annuler les modifications</button>
            </form>
        </div>
    </main>

    <footer>
        <p>Copyright Dany Carneiro, Yann Scerri, Maxime Pelloquin, Hanieh Mohajerani - Passion Lecture - 2024</p>
    </footer>
    <nav>
        <a href="#">Accueil</a>
        <a href="#">Liste des livres</a>
    </nav>
</div>
    <h1>Profil</h1>
    
    <!-- Section d'informations utilisateur -->
    <h2><?php echo htmlspecialchars($userData['pseudo']); ?></h2>
    <p>Nombre d'avis postés : <?php echo $userData['review_count']; ?></p>
    <p>Nombre de livres uploadés : <?php echo $userData['upload_count']; ?></p>

    <!-- Formulaire de modification du pseudo -->
    <form method="POST">
        <label for="newPseudo">Modifier votre pseudo :</label>
        <input type="text" name="newPseudo" id="newPseudo" required>
        <button type="submit">Valider</button>
    </form>

    <hr>

    <!-- Section d'affichage d'un livre ajouté -->
    <h3>Un livre ajouté :</h3>
    <?php if ($bookUploaded): ?>
        <p>
            <strong>Titre :</strong> <?php echo htmlspecialchars($bookUploaded['titre']); ?><br>
            <strong>Extrait :</strong> <?php echo htmlspecialchars($bookUploaded['extrait']); ?><br>
            <strong>Année :</strong> <?php echo htmlspecialchars($bookUploaded['annee']); ?><br>
            <strong>Nombre de pages :</strong> <?php echo htmlspecialchars($bookUploaded['nombre_pages']); ?><br>
            <strong>Image :</strong> <img src="<?php echo htmlspecialchars($bookUploaded['image']); ?>" alt="Image du livre">

        </p>
    <?php else: ?>
        <p>Aucun livre ajouté pour le moment.</p>
    <?php endif; ?>

    <hr>

    <!-- Section d'affichage d'un livre noté -->
    <h3>Un livre noté :</h3>
    <?php if ($bookRated): ?>
        <p>
            <strong>Titre :</strong> <?php echo htmlspecialchars($bookRated['titre']); ?><br>
            <strong>Note :</strong> <?php echo htmlspecialchars($bookRated['note']); ?>/5<br>
        </p>
    <?php else: ?>
        <p>Aucun livre noté pour le moment.</p>
    <?php endif; ?>
</body>
</html>
