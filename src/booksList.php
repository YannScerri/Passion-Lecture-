<?php
include("./Database.php");
$db = new Database();
?>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste Des Livres</title>
        <link rel="stylesheet" href="./css/style.css">
    </head>

    <body>
        <?php include("./header.php");?>
        <div class="bookListTitle">
            <h1>Liste des Livres</h1>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['isConnected']) :?>
                <button><a href="./addBook.php">Ajouter un livre</a></button>
            <?php endif;?>
        </div>
        <main>
            <div class = "main_booksList">
                <?php
                // Récupérer toutes les catégories
                $categories = $db->getAllCategories();

                // Vérification si des catégories existent
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $categoryName = $category['nom'];
                        
                        // Récupérer les livres pour cette catégorie
                        $books = $db->getBooksByCategory($categoryName);
                        
                        // Vérification si des livres sont retournés pour cette catégorie
                        if (!empty($books)) {
                            echo "<h2>Livres pour la catégorie : $categoryName</h2>";
                            echo "<div class='books-grid'>"; // Conteneur des livres

                            foreach ($books as $book) {
                                $rating = $db->getBookRatingAndVotes($book["ouvrage_id"]);
                                echo "<div class='book-card'>";
                                    echo "<a href='DetailLivre.php?id={$book['ouvrage_id']}' class='book-content'>";
                                        echo "<img src='{$book['photo_du_livre']}' alt='Image du livre'>";
                                        echo "<h3>{$book['nom_du_livre']}</h3>";
                                        echo "<p>Auteur : {$book['nom_de_l_auteur']}</p>";
                                        echo '<p>'. number_format((float)$rating["moyenne_note"], 1) . '★ (' . $rating["nombre_votes"] .')</p>';
                                    echo "</a>";
                                    echo "<p class='pseudo-section'>Ajouté par : <a href='profile.php?id=" . $book['utilisateur_id'] . "' class='pseudo-link'>{$book['pseudo_ajouteur']}</a></p>";
                                echo "</div>";
                            }

                            echo "</div>";
                        } 
                    }
                } else {
                    echo "<p>Aucune catégorie disponible.</p>";
                }
                ?>
            </div>
        </main>
        <?php include("./footer.php") ?>
    </body>
</html>