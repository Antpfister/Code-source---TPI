<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : page d'information d'un article 
-->

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../../resources/css/style.css">
        <title id="title">Article - Gestion de prêt entre voisins</title>
    </head>
    <body>
        <?php include "menu.php"?>
        <?php include "checkConnection.php"?>
        
        <?php 
            $id = $_GET['id'];

            $connector = new Database();
            $article = $connector->getArticle($id);
            $user = $connector->getUser($article["idUser"]);
            $connector = null;
        ?>
        <div class="TitleListeArticle">
            <h1>Article info - <?= $article['artName'] ?></h1>
        </div>
        <div class="errMessage">
            <?php  if (isset($_GET['error'])) {

             ?>
            <p>L'article n'est pas disponible !</p>
            <?php }?>
        </div>
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
                ?>
                    <h3 class="emprunter">Emprunter</h3>
                <?php
                }
                ?>
                <p><?= $article['artDescription'] ?></p>
                <h3><?= 'Créer par '.$user['useName'] . ', se situe à ' . $user['useLocal'] ?></h3>
        </div>
        <br>
        <br>
        <div class="btnSuppArticle">
            <form action='suppArticle.php' method='get'>
                <input type='hidden' name="picture" value='<?php echo $article["artPicture"]; ?>'>
                <input type='hidden' name="id" value='<?php echo $article["idArticle"]; ?>'>
                <input type="submit" value="Supprimer l'article">
            </form>
        </div>
        <div class="btnModifArticle">
            <form action='modifArticle.php' method='get'>
                <input type='hidden' name="id" value='<?php echo $article["idArticle"]; ?>'>
                <input type="submit" value="Modifier cette article">
            </form>
        </div>
        <br>
        <br>
        <?php include 'footer.php' ?>
    </body>
</html>