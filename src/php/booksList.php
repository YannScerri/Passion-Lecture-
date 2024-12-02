<?php
include("header.php");
include("./Database.php");
$db = new Database();
?>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste Des Livres</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        
        <main>

        <?php
        $categories = $db->getAllCategory();
        //"echo "<pre>";
        //var_dump($db->getBooksByCategory("Police"));
        //echo "<pre>";
        ?>

    <?php
    // Récupérer toutes les catégories
    $categories = $db->getAllCategory();

    //-- TODO mise en page --\\


    // Vérification si des catégories existent
    if (!empty($categories)) {
        foreach ($categories as $category) {
            $categoryName = $category['nom'];
            
            // Récupérer les livres pour cette catégorie
            $books = $db->getBooksByCategory($categoryName);
            
            // Vérification si des livres sont retournés pour cette catégorie
            if (!empty($books)) {
                echo "<h2>Livres pour la catégorie : $categoryName</h2>";
                foreach ($books as $book) {
                    echo "<div class='bookFromBookList'>";
                    echo "<img src='{$book['photo_du_livre']}' alt='Image du livre' width='100'>";
                    echo "<h3>{$book['nom_du_livre']}</h3>";
                    echo "<p>Auteur : {$book['nom_de_l_auteur']}</p>";
                    echo "<p>Ajouté par : {$book['pseudo_ajouteur']}</p>";
                    echo "</div>";
                }
            } 
        }
    } else {
        echo "<p>Aucune catégorie disponible.</p>";
    }
    ?>
</main>

        <?php include("./footer.php") ?>
    </body>
</html>