<?php 
/**
 * ETML
 * Auteur : Hanieh Mohajerani
 * Date : 19.11.2024
 * Description : Page de détail d'un livre
 */

// Inclure la classe Database
require_once 'Database.php';


// Créer une instance de la classe Database
$db = new Database();

// Récupérer l'ID du livre depuis l'URL (par exemple, ?id=123)
if (isset($_GET['id'])) {
    $idLivre = $_GET['id'];

    // Appeler la méthode pour récupérer les informations du livre
    $livre = $db->getOneOuvrage($idLivre);
} else {
    // Si l'ID n'est pas passé, rediriger ou afficher une erreur
    echo "Livre non trouvé.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail d'un livre</title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- Inclusion du header -->
    <?php include("./header.php") ?>

    <!-- Contenu principal -->
    <main class="container">
        <!-- Affichage du titre du livre -->
        <h1><?php echo htmlspecialchars($livre['titre']); ?></h1>

        <div class="book-details">
            <div class="book-rating">
                <p>4.2★ noté par 52 utilisateurs</p> <!-- Note à adapter selon la base de données -->
            </div>
            <div class="book-info">
                <!-- Image du livre à récupérer depuis la base de données -->
                <img src="images/<?php echo htmlspecialchars($livre['image']); ?>" alt="Image du livre" class="book-image">

                <ul>
                    <li><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur_nom']) . " " . htmlspecialchars($livre['auteur_prenom']); ?></li>
                    <li><strong>Édition :</strong> <?php echo htmlspecialchars($livre['editeur_nom']); ?></li>
                    <li><strong>Date de parution :</strong> <?php echo htmlspecialchars($livre['annee']); ?></li>
                    <li><strong>Catégorie :</strong> <?php echo htmlspecialchars($livre['categorie_nom']); ?></li>
                    <li><strong>Nombre de pages :</strong> <?php echo htmlspecialchars($livre['nombre_pages']); ?></li>
                </ul>
            </div>
        </div>

        <div class="book-summary">
            <h2>Résumé</h2>
            <p>
                <?php echo nl2br(htmlspecialchars($livre['resume'])); ?>
            </p>
        </div>

        <div class="book-rating-form">
            <label for="rating">Noter ce livre :</label>
            <select id="rating" name="rating">
                <option value="1">★☆☆☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="3">★★★☆☆</option>
                <option value="4">★★★★☆</option>
                <option value="5">★★★★★</option>
            </select>
            <button type="submit" class="submit-btn">Valider</button>
        </div>

        <!-- Lien vers la page d'accueil -->
        <div class="back-to-home">
            <a href="index.php" class="btn-back">Retour à l'accueil</a>
        </div>
    </main>

    <!-- Inclusion du footer -->
    <?php include("./footer.php") ?>
</body>
</html>
