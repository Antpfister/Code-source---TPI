<!DOCTYPE html>

<html>
    <head>
        <!--
        /// ETML
        /// Auteur : Anthony Pfister
        /// Date : 12.05.2023
        /// Description : page  d'accueil du site. Information sur l'utilisation du site. 
        -->
        <meta charset="utf-8">
        <link rel="stylesheet" href="../../resources/CSS/style.css?v=<?php echo time(); ?>">
        <title id="title">Home - Gestion de prêt entre voisins</title>
    </head>
    <body>
        <!--indicateur pour le navigateur-->
        <?php $actif = 1?>
        <!--incrustation navigateur-->
        <?php include "menu.php"?>

        <!--Titre Page-->
        <div class="title">
            <h1>Gestion de prêt entre voisins</h1>
        </div>
        <!--Contenaire d'image-->
        <div class="image_accueil">
            <img src="../../resources/images/img_accueil.jpg" >
            <p>image freepik<p>
        </div>
        <!--Contenaire Information-->
        <div class="Description">
            <p>
                Bienvenue sur la page d'accueil du site "Gestion de prêt entre voisins".
                Ici, vous pouvez retrouver des articles utiles que vous pouvez emprunter aux dates que vous voulez. Connectez-vous d'abord pour pouvoir accéder aux fonctionnalités.

            </p>
        </div>

        <!--incrustation pied de page-->
        <?php include "footer.php"?>
    </body>
</html>