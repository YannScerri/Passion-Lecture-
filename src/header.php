<?php
session_start()
?>
<div class="header">
    <div class="content-header">
        <div class="titre-header">
            <a href="./index.php"><h1>Passion Lecture</h1></a>
        </div>

        <nav>
            <a href="./index.php">Accueil</a>
            <a href="./booksList.php">Liste des livres</a>
        </nav>
    </div>

    <!-- affichage du bouton de déconnexion si l'utilisateur est connecté -->
    <?php if($_SESSION['user']['isConnected']) : ?>
        <button><a href="./Disconnect.php">Se déconnecter</a></button>
    <?php endif; ?>
    <a href="./connection.php"  class="userLink"><img src="./images/user.png" alt="icône de connexion" class="userIcon"></a>

</div>