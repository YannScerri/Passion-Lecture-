

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Page d'ajout</title>
</head>
<body>
    <?php include('./header.php')?>
    <div class="bookinfos"></div>
    <h2>Ajouter un livre</h2>
    <div class="form-container">
        <!-- Formulaire principal -->
        <form class="form-main" action="#">
            <p>
                <label for="fullName"></label>
                <input type="text" name="fullname" id="fullname" placeholder="Prénom et nom">
            </p>
            <p>
                <label for="title"></label>
                <input type="text" name="title" id="title" placeholder="Titre du livre">
            </p>
            <p> 
                <label for="Editor"></label>
                <input type="text" name="Editor" id="Editor" placeholder="Editeur">
            </p>
            <p>
                <label for="year"></label>
                <input type="text" name="year" id="year" placeholder="Année de publication">
            </p>
            <p>
                <label for="pagesNumber"></label>
                <input type="text" name="pagesNumber" id="pagesNumber" placeholder="Nombre de pages">
            </p>
            <p>
                <label for="category"></label>
                <input type="text" name="category" id="category" placeholder="Catégorie">
            </p>
            <p>
                <label for="bookSummary"></label>
                <textarea name="bookSummary" id="bookSummary" placeholder="Résumé de l'ouvrage"></textarea>
            </p>
            <p>
                <label for="bookExcerpt"></label>
                <input type="url" name="bookExcerpt" id="bookExcerpt" placeholder="Lien vers extrait">
            </p>
            <p>
                <button type="submit">Ajouter le livre</button>
            </p>
        </form>

        <!-- Section pour l'ajout de l'image -->
        <div class="form-image">
            <h3>Image de couverture</h3>
            <p>
                <label for="bookCover"></label>
                <input type="file" name="bookCover" id="bookCover" accept="image/*">
            </p>
            <p>
                Formats acceptés : JPG, PNG, GIF
            </p>
        </div>
    </div>
    <footer>
        <p>Copyright Dany Carneiro, Yann Scerri, Maxime Pelloquin, Hanieh Mohajerani - Passion Lecture - 2024</p>
    </footer>
</body>
</html>