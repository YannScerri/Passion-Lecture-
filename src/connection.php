<?php
include("./Database.php");
include("./header.php")
?>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connection</title>
        <link rel="stylesheet" href="./css/style.css">
        <style>
    </style>
    </head>

    <body>
        <main>
            <form class="form-container" action="process_login.php" method="post">

                <label for="pseudo">pseudo</label>
                <input type="pseudo" id="pseudo" name="pseudo" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                <span id="error-message" class="error"></span>

                <button type="submit" id="btnConnect">Se connecter</button>
            </form>
        </main>

        <?php include("./footer.php") ?>

    </body>
</html>