<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 12.05.2023
/// Description : page  d'accueil du site. 
-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../../resources/CSS/style.css?v=<?php echo time(); ?>">
        <title id="title">Home - Gestion de prêt entre voisins</title>
    </head>
    <body>
        <?php $actif = 1?>
        <?php include "menu.php"?>
        <div class="title">
            <h1>Gestion de prêt entre voisins</h1>
        </div>
        <div class="image_accueil">
            <img src="../../resources/images/img_accueil.jpg" >
            <p>image freepik<p>
        </div>
        <div class="Description">
            <p>
                Bienvenu sur la page d'accueil du site "Gestion de prêt entre voisins".
                Ici, vous pouvez retrouver des articles utile que vous pouvez emprunter au date que vous voulez.

            </p>
        </div>


        <?php include "footer.php"?>
    </body>
</html>