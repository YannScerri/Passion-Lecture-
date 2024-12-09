<?php 
/**
 * ETML
 * Auteur : Hanieh Mohajerani
 * Date : 19.11.2024
 * Description : Page de détail d'un livre
 */

 require_once './Database.php';
 $db = new Database();

 $ouvrage = $db->getOneOuvrage($_GET['id']);
 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du livre : <?php echo htmlspecialchars($ouvrage['titre']); ?></title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
     <!-- Inclusion du header -->
     <?php include("./header.php") ?>

<!-- Contenu principal -->
<main class="container">
    <!-- Affichage des détails du livre -->
    <h1> <?php echo htmlspecialchars($ouvrage['titre']); ?></h1>

    <div class="book-details">
      
     <!-- Évaluation du livre -->
     <div class="book-rating">
            <p>4.2★ noté par 52 utilisateurs</p> <!-- Exemple statique -->
        </div>
        <!-- TODO: CHERCHER L'IMAGE PAR RAPPORT A L'ID Image du livre -->
        <img src="./images/HarryQuebert.png" 
                 alt="Image du livre La vérité sur l'affaire Harry Quebert" 
                 class="book-image">


        
        <!-- Informations sur le livre -->
        <p><strong>Auteur :</strong> <?php echo htmlspecialchars($ouvrage['auteur_nom']) . " " . htmlspecialchars($ouvrage['auteur_prenom']); ?></p>
        <p><strong>Éditeur :</strong> <?php echo htmlspecialchars($ouvrage['editeur_nom']); ?></p>
        <p><strong>Date de publication :</strong> <?php echo htmlspecialchars($ouvrage['annee']); ?></p>
        <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($ouvrage['categorie_nom']); ?></p>
        <p><strong>Nombre de page :</strong> <?php echo htmlspecialchars($ouvrage['nombre_pages']); ?></p>
        
        <!-- Résumé du livre -->
        <div class="book-summary">
            <h2>Résumé</h2>
            <p><?php echo nl2br(htmlspecialchars($ouvrage['resume'])); ?></p>
        </div>

       <hr>
    </div>

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

    <!-- Lien pour retourner à la page d'accueil -->
    <div class="back-to-home">
        <a href="./index.php" class="btn-back">Retour à l'accueil</a>
    </div>
</main>

<!-- Inclusion du footer -->
<?php include("./footer.php") ?>
</body>
</html>