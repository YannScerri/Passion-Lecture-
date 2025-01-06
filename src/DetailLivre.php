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
 $rating = $db->getBookRatingAndVotes($_GET['id']);

 $year = date_create($ouvrage['annee']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du livre : <?php echo htmlspecialchars($ouvrage['titre']); ?></title>
    <!-- Lien vers le fichier CSS -->


    <link rel="stylesheet" type="text/css" href="./css/style.css" media="screen">


</head>
<body>
     <!-- Inclusion du header -->
     <?php include("./header.php") ?>

<!-- Contenu principal -->
    <main class="Mycontainer">
        <div class="detailTitle">
            <h2> <?php echo htmlspecialchars($ouvrage['titre']); ?></h2>

            <div class="buttons">
                <!-- affichage du bouton de suppression si l'utilisateur qui visite la page est celui qui a ajouté le livre ou si c'est un administrateur-->
                <?php if($_SESSION['user']['isConnected'] && $_SESSION['user']['id'] == $ouvrage['utilisateur_id'] || $_SESSION['user']['isConnected'] && $_SESSION['user']['administrator'] == 1) : ?>
                    <button type="button"><a href="./deleteBook.php?idBook=<?php echo $_GET['id']?>">Supprimer le livre</a></button>
                    <button type="button"><a href="./modifyBook.php?bookId=<?php echo $_GET['id']?>">Modifier le livre</a></button>
                <?php endif;?>
            </div>
        </div>

        <div class="book-details">
               
            <!-- Section image du livre -->
            <div class="book-image-container">
                <!-- Évaluation du livre -->
                <div class="book-rating">
                    <p><?php echo number_format((float)$rating["moyenne_note"], 1); ?>★ noté par <?php echo $rating["nombre_votes"]; ?> utilisateurs</p>
                </div>

                <!-- Image dynamique du livre -->  
                <img src="<?php echo htmlspecialchars($ouvrage['image'] ?? 'default_image.png'); ?>" alt="Image du livre <?php echo htmlspecialchars($ouvrage['titre'] ?? 'Livre inconnu'); ?>" class="book-image">
            </div>
                <!-- Conteneur pour les informations -->
            <div class="book-info-container">
                <p><strong>Auteur :</strong> <?php echo htmlspecialchars($ouvrage['auteur_nom']) . " " . htmlspecialchars($ouvrage['auteur_prenom']); ?></p>
                <p><strong>Éditeur :</strong> <?php echo htmlspecialchars($ouvrage['editeur_nom']); ?></p>
                <p><strong>Année de publication :</strong> <?php echo htmlspecialchars(date_format($year, "Y")); ?></p>
                <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($ouvrage['categorie_nom']); ?></p>
                <p><strong>Nombre de page :</strong> <?php echo htmlspecialchars($ouvrage['nombre_pages']); ?></p>
                <p><strong>Ajouté par :</strong> <a href="profile.php?user=<?php echo htmlspecialchars($ouvrage['utilisateur_id']); ?>">
                    <?php echo htmlspecialchars($ouvrage['utilisateur_pseudo']); ?></a></p>
            </div>
                <!-- Résumé du livre -->
            <div class="book-summary">
                <h3>Résumé</h3>
                <p><?php echo nl2br(htmlspecialchars($ouvrage['resume'])); ?></p>
                <hr>
                <!-- Formulaire pour noter le livre -->
                <div class="book-rating-form">
                    <form action="./rateBook.php" method="post">
                        <input type="hidden" value="<?php echo $ouvrage['ouvrage_id']?>" name="bookId">
                        <input type="hidden" value="<?php echo $ouvrage['utilisateur_id']?>" name="userId">
                        <label for="rating">Noter ce livre :</label>
                        <select id="rating" name="rating">
                            <option value="1">★☆☆☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="4">★★★★☆</option>
                            <option value="5">★★★★★</option>
                        </select>
                        <button type="submit" class="submit-btn">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </main>


<!-- Inclusion du footer -->
<?php include("./footer.php") ?>
</body>
</html>