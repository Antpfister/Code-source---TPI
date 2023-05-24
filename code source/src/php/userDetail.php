<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 12.05.2023
/// Description : Page de profil pour voir les détail du profil de l'utilisateur. l'utilisateur est obliger de se connecter pour voir cette page sinon il est rediriger.
-->
<!DOCTYPE html>
<html>
    <head>

        <!-- Tag meta -->
        <meta charset="utf-8">
        <!-- CSS -->
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title id="title">Profil - Gestion de prêt entre voisins</title>
        
    </head>
    <body>
    <?php $actif = 4?>
        <?php include "menu.php" ?>
        <?php include "checkConnection.php" ?>
        <?php

        $userName = $_SESSION["userName"];
        $connector = new Database();
        $user = $connector->getUser($_SESSION["idUser"]);
        $connector = null;

        $connector = new Database();
        $articles = $connector->getAllArticlesAndInfos();
        $connector = null;  
        
        $connector = new Database();
        $Emprunts = $connector->getAllLoansAndInfos();
        $connector = null;  
        ?>
            
        <?php echo "<h1>Détails de l'utilisateur ".$user['useName']."</h1>"?>
        <form action="disconnect.php">
            <button type="submit" id="send" class="connButton">Se déconnecter</button>
        </form>
        <br>
        <br>
        <div class="infoUser">
            <h4>Créer le <?= $user["useRegisterDate"] ?></h4>
            <p>Localisation : <?= $user["useLocal"] ?></p>
            <p>Nombre d'article créer par l'utilisateur <?= $user["useNbArticles"] ?></p>
            <p>Nombre d'emprunt que l'utilisateur à actuellement :  <?= $user["useNbLoan"] ?></p>
        </div>
        <div class="userEmprlist">
        <h2>liste d'article Emprunter</h2>
            <?php    
                foreach ($Emprunts as $Emprunt) {
                    if($Emprunt['FKUser'] == $_SESSION['idUser']){
                        
            ?>
                    <div class="userEmprlistconn">
                        <div class="imgarticle">
                            <a class="imglien" href="article.php?id=<?= $Emprunt["FKArticle"] ?>">
                            <img class="imgarticle" src="../../resources/images/<?= $Emprunt["artPicture"] ?>" alt="">
                            </a>
                        </div>
                        <div class="infoarticles">
                            <strong><?= $Emprunt['artName'] ?></strong>
                            <p>Du <?= $Emprunt['loaBeginDate'] ?> jusqu'au <?= $Emprunt['loaEndDate'] ?>.</p>
                        </div>
                        <div class="btnSuppArticle">
                            <form action='suppEmprunt.php' method='get'>
                                <input type='hidden' name="id" value='<?php echo $Emprunt["FKArticle"]; ?>'>
                                <input type="submit" value="Arrêter l'emprunt">
                            </form>
                        </div>
                    </div>
            <?php 
                    }    
                }

            ?>
            <br>
            <br>
        </div>
        <br>
        <br>
        <div class="userEmprlist">
            <h2>liste de article créer</h2>
            <?php    
                foreach ($articles as $article) {
                    if($article['idUser'] == $_SESSION['idUser']){
            ?>
                    <div class="userEmprlistconn">
                        <div class="imgarticle">
                            <a class="imglien" href="article.php?id=<?= $article["idArticle"] ?>">
                            <img class="imgarticle" src="../../resources/images/<?= $article["artPicture"] ?>" alt="">
                            </a>
                        </div>
                        <div class="infoarticles">
                            <strong><?= $article['artName'] ?></strong>
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
                        </div>
                    </div>
            <?php 
                    }    
                }

            ?>
            <br>
            <br>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <?php include 'footer.php' ?>

    </body>
</html>