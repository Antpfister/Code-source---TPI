<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 22.05.2023
/// Description : page du formulaire pour emprunter un article, en selectionnant les dates de début et de fin
-->

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title id="title">Emprunter - Gestion de prêt entre voisins</title>
    </head>
    <body>
    <?php $actif = 0?>
        <?php include "menu.php"?>
        <?php include "checkConnection.php"?>
        <?php 
            $id = $_GET['id'];

            $connector = new Database();
            $article = $connector->getArticle($id);
            $connector = null;
        ?>
        <div class="TitleEmprunt">
            <h1>Emprunt de l'article - <?= $article['artName'] ?></h1>
        </div>
        <br>
        <br>
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
                    <input type="submit" class="btn btn-primary mt-4" value="Emprunter">
                    <input type="reset" class="btn btn-primary mt-4" value="Vider">
                </form>
            </div>
            <div class="errMessage">
            <?php  if (isset($_GET['error'])) {
                
             ?>
            <p>Il y a eu une erreur! s'il vous plait recommencer. </p>
            <?php }?>
        </div>
        </div>


        <?php include 'footer.php' ?>
    </body>
</html>