<?php
/*
 * ETML
 * Auteur : Dany Carneiro, Maxime Pelloquin, Yann Scerri, Hanieh Mohajerani
 * Date : 25.11.2024
 * Description : Fichier addBook permettant d'ajouter un nouvel ouvrage
 */

 include("Database.php");
 $db = new Database();

 //simuler un utilisateur
 $userID = 1;
 $user = $db->getUSerByID($userID);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $newPseudo = $_POST['pseudo'];
    $db->updateUserPseudo($userId, $newPseudo);
    header("Location: profile.php"); // Recharge la page pour refléter les modifications
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <link rel="stylesheet" href="css/style.css">
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
</body>
</html>