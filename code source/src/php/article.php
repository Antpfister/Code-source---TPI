<!DOCTYPE html>
<html>
    <head>
        <!--
        /// ETML
        /// Auteur : Anthony Pfister
        /// Date : 15.05.2023
        /// Description : Page d'information d'un article sélectionné. Depuis cette page, le bouton supprimer et modifier sont accessible qu'avec l'utilisateur qui l'as créer
        /// -             et le bouton emprunter renvoye un message d'erreur si l'article est déjà emprunté.
        -->
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title id="title">Article - Gestion de prêt entre voisins</title>
    </head>
    <body>
        <!--indicateur pour le navigateur-->
        <?php $actif = 0?>
        <!--incrustation navigateur-->
        <?php include "menu.php"?>
        <!--Check si l'utilisateur est connecté-->
        <?php include "checkConnection.php"?>
        
        <?php 
            // récupère l'id de l'article.
            $id = $_GET['id'];
            // récupère les données de l'article et de l'utilisateur via requète SQL.
            $connector = new Database();
            $article = $connector->getArticle($id);
            $user = $connector->getUser($article["idUser"]);
            $connector = null;
        ?>
        <!--Titre Page-->
        <div class="TitleArticle">
            <h1>Article info - <?= $article['artName'] ?></h1>
        </div>
        <!--Message d'erreur-->
        <?php  if (isset($_GET['error'])) {
        ?>
            <div class="errMessage">
                <p>L'article n'est pas disponible !</p>
            </div>
        <?php }?>
        <!--Contenaire pour les informations de l'article-->
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
        <!--Check si l'utilisateur actuelle est le créateur de l'article. Si oui, alors les boutons supprimer et modifier sont visibles.-->
        <?php if($_SESSION["idUser"] == $article["idUser"]) {
            ?>
        <!--Bouton Supprimer-->
        <div class="btnSuppArticle">
            <form action='suppArticle.php' method='get'>
                <input type='hidden' name="picture" value='<?php echo $article["artPicture"]; ?>'>
                <input type='hidden' name="id" value='<?php echo $article["idArticle"]; ?>'>
                <input type="submit" value="Supprimer l'article" class="connButton">
            </form>
        </div>
        <br>
        <!--Bouton Modifier-->
        <div class="btnModifArticle">
            <form action='modifArticle.php' method='get'>
                <input type='hidden' name="id" value='<?php echo $article["idArticle"]; ?>'>
                <input type="submit" value="Modifier l'article" class="connButton">
            </form>
        </div>
        <br>
        <?php }?>
        <!--Bouton Emprunter-->
        <div class="btnEmprArticle">
            <form action='empruntArticle.php' method='get'>
                <input type='hidden' name="id" value='<?php echo $article["idArticle"]; ?>'>
                <input type="submit" value="Emprunter l'article" class="connButton">
            </form>
        </div>
        <br>
        <!--incrustation pied de page-->
        <?php include 'footer.php' ?>
    </body>
</html>