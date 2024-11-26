<?php 
/**
 * ETML
 * Auteur : Hanieh Mohajerani
 * Date : 19.11.2024
 * Description : Page de détail d'un livre
 */

 require_once 'Database.php';
 $db = new Database();

 //$ouvrage = $db->getOneOuvrage($_GET["ouvrage_id"]);
// $categorie = $db->getOneCategorie($categorie["categorie_id"]);

$ouvrages = $db->getAllOuvrages();
// var_dump($ouvrage);
// var_dump($categorie);
 
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
        <h1>livres</h1>

        <div class="book-details">
            <div class="book-rating">
                <p>4.2★ noté par 52 utilisateurs</p> <!-- Note à adapter selon la base de données -->
            </div>
            <div class="book-info">
               
 <?php foreach ($ouvrages as $livre): ?>
        <div class="book">
            <h2><?php echo htmlspecialchars($livre['titre']); ?></h2>
             <!-- Image du livre à récupérer depuis la base de données -->
             <img src="images/<?php echo htmlspecialchars($livre['image']); ?>" alt="Image du livre" class="book-image">
            <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur_nom']) . " " . htmlspecialchars($livre['auteur_prenom']); ?></p>
            <p><strong>Éditeur :</strong> <?php echo htmlspecialchars($livre['editeur_nom']); ?></p>
            <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($livre['categorie_nom']); ?></p>
            <p><strong>Date de publication :</strong> <?php echo htmlspecialchars($livre['annee']); ?></p>
            <a href="livre_detail.php?id=<?php echo $livre['ouvrage_id']; ?>">Voir les détails</a>
            <div class="book-summary">
            <h2>Résumé</h2>
            <p>
                <?php echo nl2br(htmlspecialchars($livre['resume'])); ?>
            </p>
        </div>

        <div class="book-rating">
                <p>4.2★ noté par 52 utilisateurs</p> <!-- Note à adapter selon la base de données -->
            </div>
        </div>
    <?php endforeach; ?>
</main>

<?php include("./footer.php") ?>
            </div>
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
<?php

//test code si ca marche avec le methode getAllOuvrages 
/*
<?php
require_once 'Database.php';

// Créer une instance de la classe Database
$db = new Database();

// Récupérer tous les livres
$ouvrages = $db->getAllOuvrages();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des livres</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php include("./header.php") ?>

<main class="container">
<!-- Affichage du titre du livre -->
    <h1>Liste des livres</h1>

    <?php foreach ($ouvrages as $livre): ?>
        <div class="book">
            <h2><?php echo htmlspecialchars($livre['titre']); ?></h2>
            <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur_nom']) . " " . htmlspecialchars($livre['auteur_prenom']); ?></p>
            <p><strong>Éditeur :</strong> <?php echo htmlspecialchars($livre['editeur_nom']); ?></p>
            <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($livre['categorie_nom']); ?></p>
            <p><strong>Date de publication :</strong> <?php echo htmlspecialchars($livre['annee']); ?></p>
            <a href="livre_detail.php?id=<?php echo $livre['ouvrage_id']; ?>">Voir les détails</a>
        </div>
    <?php endforeach; ?>
</main>

<?php include("./footer.php") ?>

</body>
</html>

*/