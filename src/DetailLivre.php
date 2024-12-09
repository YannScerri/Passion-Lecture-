<?php 
/**
 * ETML
 * Auteur : Hanieh Mohajerani
 * Date : 19.11.2024
 * Description : Page de détail d'un livre
 */

 require_once 'Database.php';
 $db = new Database();

 //ces code pour affiches tout les livre comme admin
 //$ouvrage = $db->getOneOuvrage($_GET["ouvrage_id"]);
 //$categorie = $db->getOneCategorie($ouvrage["categorie_id"]);
 $ouvrage = $db->getOneOuvrage($_GET['id']);

//$ouvrages = $db->getAllOuvrages();
 //var_dump($ouvrage);
 //var_dump($categorie);
 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du livre : <?php echo htmlspecialchars($ouvrage['titre']); ?></title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen">

</head>
<body>
     <!-- Inclusion du header -->
     <?php include("./header.php") ?>

<!-- Contenu principal -->
<main class="Mycontainer">
    <h2> <?php echo htmlspecialchars($ouvrage['titre']); ?></h2>

    <div class="book-details">
        

   
        <!-- Section image du livre -->
        <div class="book-image-container">
             <!-- Évaluation du livre -->
            <div class="book-rating">
                <p>4.2★ noté par 52 utilisateurs</p> <!-- Exemple statique -->
            </div>

            <img src="../images/HarryQuebert.png" 
                alt="Image du livre La vérité sur l'affaire Harry Quebert" 
                class="book-image">
        </div>

        <!-- Informations sur le livre -->
        <div class="book-info">
            <p><strong>Auteur :</strong> <?php echo htmlspecialchars($ouvrage['auteur_nom']) . " " . htmlspecialchars($ouvrage['auteur_prenom']); ?></p>
            <p><strong>Éditeur :</strong> <?php echo htmlspecialchars($ouvrage['editeur_nom']); ?></p>
            <p><strong>Date de publication :</strong> <?php echo htmlspecialchars($ouvrage['annee']); ?></p>
            <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($ouvrage['categorie_nom']); ?></p>
            <p><strong>Nombre de page :</strong> <?php echo htmlspecialchars($ouvrage['nombre_pages']); ?></p>
        </div>

        <!-- Résumé du livre -->
        <div class="book-summary">
            <h3>Résumé</h3>
            <p><?php echo nl2br(htmlspecialchars($ouvrage['resume'])); ?></p>
            <br>
            <hr>
            <br>
             <!-- Formulaire pour noter le livre -->
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
            <br>
          <br>
        </div>
      
    </div>

   
</main>


<!-- Inclusion du footer -->
<?php include("./footer.php") ?>
</body>
</html>
<?php

//ces code ca marche avec le methode getAllOuvrages et pour afficher tout les livre comme admin
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