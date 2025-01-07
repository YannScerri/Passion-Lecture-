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
        <button class="disconnectButton"><a href="./Disconnect.php">Se déconnecter</a></button>
    <?php else: ?>
        <button class="disconnectButton"><a href="./connection.php">Se connecter</a></button>
    <?php endif;?>

    <!-- lien vers la connexion ou le profil de l'utilisateur sur l'icone-->
    <?php if(!$_SESSION['user']['isConnected']) : ?>
        <a href="./connection.php"  class="userLink"><img src="./images_utilities/user.png" alt="icône de connexion" class="userIcon"></a>
    <?php else:?>
        <a href="./profile.php"  class="userLink"><img src="./images_utilities/user.png" alt="icône de connexion" class="userIcon"></a>
    <?php endif;?>

</div>