<!DOCTYPE html>

<html>
    <head>
        <!--
            /// ETML
            /// Auteur : Anthony Pfister
            /// Date : 22.05.2023
            /// Description : page du formulaire pour emprunter un article, en selectionnant les dates de début et de fin.
            ///               Affichage d'un message d'erreur si les dates saisis ne sont pas cohèrente avec la date du jour.
        -->
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title id="title">Emprunter - Gestion de prêt entre voisins</title>
    </head>
    <body>
    <?php $actif = 0?>
        <!--incrustation navigateur-->
        <?php include "menu.php"?>
        <!--Check si l'utilisateur est connecté-->
        <?php include "checkConnection.php"?>

        <?php 
            // récupère l'id de l'article.
            $id = $_GET['id'];

            // récupère les données de l'article
            $connector = new Database();
            $article = $connector->getArticle($id);
            $connector = null;
        ?>
        <!--Titre Page-->
        <div class="TitleEmprunt">
            <h1>Emprunt de l'article - <?= $article['artName'] ?></h1>
        </div>
        <br>
        <br>
        <!--Contenaire pour les informations de l'articles-->
        <div class="infoArticle">
            <div class="imgArticle">
                <img class="imgarticle" src="../../resources/images/<?= $article["artPicture"] ?>" alt="">
            </div>
            <?php 
            if($article['artStatus'] == 1){
            ?>
                <h3 class="disponible">Disponible</h3>
            
            <?php
            }else{
            
                echo '<meta http-equiv="refresh" content="0, URL=article.php?error=1&id='.$id.'">';
            
            }
            ?>
            <p><?= $article['artDescription'] ?></p>
            <br>
            <br>
            <!--formulaire d'emprunt d'article-->
            <div class="divformEmprArticle">
                <form method="post" action="checkEmprunt.php" enctype="multipart/form-data">
                    <label for="Name">Date de début :</label>
                    <input type="Date" name="DateBegin" >
                    <br>
                    <br>
                    <label for="Name">Date de fin :</label>
                    <input type="Date" name="DateEnd" >
                    <br>
                    <br>
                    <input type='hidden' name="id" value='<?php echo $article["idArticle"]; ?>'>
                    <input type="submit"  value="Emprunter" class="connButton">
                    <input type="reset"  value="Vider" class="connButton">
                </form>
            </div>
        </div>
        <!--Message d'erreur-->
        <?php  if (isset($_GET['error'])) {
        ?>
            <div class="errMessage">
                <p>Il y a eu une erreur! s'il vous plait recommencer. </p>
            </div>
        <?php }?>
        <!--incrustation pied de page-->
        <?php include 'footer.php' ?>
    </body>
</html>