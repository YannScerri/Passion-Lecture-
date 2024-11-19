<?php 
/**
 * ETML
 * Auteur : Hanieh Mohajerani
 * Date : 19.11.2024
 * Description : Page de afichage detail de livre
 */

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail d'un livre</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen">
</head>
<body>
    <!-- inclusion du header-->
    <?php include("./header.php")?>
    <main class="container">
    <h1>La vérité sur l’affaire Harry Quebert</h1>
    <div class="book-details">
        <div class="book-rating">
            <p>4.2★ noté par 52 utilisateurs</p>
        </div>
        <div class="book-info">
            <img src="placeholder.jpg" alt="Image du livre" class="book-image">
            <ul>
                <li><strong>La vérité sur l’affaire Harry Quebert</strong></li>
                <li><strong>Auteur :</strong> Joël Dicker</li>
                <li><strong>Édition :</strong> Rosie Wolf</li>
                <li><strong>Date de parution :</strong> 2012</li>
                <li><strong>Catégorie :</strong> Policier</li>
                <li><strong>Nombre de pages :</strong> 336</li>
            </ul>
        </div>
    </div>
    <div class="book-summary">
        <h2>Résumé</h2>
        <p>
            À la fin du mois d’août 1975, Nola Kellergan, âgée de 15 ans, disparaît mystérieusement du village fictif d’Aurora dans le New Hampshire. 
            Une vieille dame, qui a vu un homme poursuivre la jeune fille dans la forêt, se fait tuer quelques minutes plus tard. L’affaire est classée sans suite...
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
</main>

    



    <!-- inclusion du footer-->
    <?php include("./footer.php")?>
</body>
</html>