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

        date_default_timezone_set('Europe/Paris');
        $curDate = date('d.m.Y');
        ?>
            
        <?php echo "<h1>Détails de l'utilisateur ".$user['useName']."</h1>"?>
        <form action="disconnect.php">
            <button type="submit" id="send" class="connButton">Se déconnecter</button>
        </form>
        <br>
        <br>
        <div id="notifMessage" class="notifMessage">
            <p>Il reste moins de 2 jours avant la fin d'un emprunt !!!</p>
        </div>
        <div class="infoUser">
            <h4>Créer le <?= $user["useRegisterDate"] ?></h4>
            <p>Localisation : <?= $user["useLocal"] ?></p>
            <p>Nombre d'article créer par l'utilisateur <?= $user["useNbArticles"] ?></p>
            <p>Nombre d'emprunt que l'utilisateur a actuellement :  <?= $user["useNbLoan"] ?></p>
        </div>
        <div class="userEmprlist">
        <h2>Liste des articles Emprunter actuellement :</h2>
            <?php    
                foreach ($Emprunts as $Emprunt) {

                    $Emprunt['loaBeginDate'] = date('d.m.Y',strtotime($Emprunt['loaBeginDate']));
                    $Emprunt['loaEndDate'] = date('d.m.Y',strtotime($Emprunt['loaEndDate']));

                    if($Emprunt['fkUser'] == $_SESSION['idUser']){
                        
                        $limiteDate = date('d.m.Y', strtotime($Emprunt['loaEndDate']."-2 day"));
                        
                        
                        $strlimiteDate = strtotime($limiteDate);
                        $strcurdate = strtotime($curDate);
                        $strLoaEndDate = strtotime($Emprunt['loaEndDate']);



                        if ($strlimiteDate <= $strcurdate ){
                            if($strLoaEndDate <= $strcurdate){
                                
                            echo '<meta http-equiv="refresh" content="0, URL=suppEmprunt.php?id='.$Emprunt["fkArticle"].'" >';
                            }else{
                                ?>
                                <script>
                                function activerConteneur() {
                                    var conteneur = document.getElementById('notifMessage');
                                    conteneur.style.display = 'block';
                                }
                                activerConteneur();
                                </script>
                            <?php
                            }
                        } 
            ?>
            <div class="userEmprlistconn">
                <div class="imgarticle">
                    <a class="imglien" href="article.php?id=<?= $Emprunt["fkArticle"] ?>">
                    <img class="imgarticle" src="../../resources/images/<?= $Emprunt["artPicture"] ?>" alt="">
                    </a>
                </div>
                <div class="infoarticles">
                    <strong><?= $Emprunt['artName'] ?></strong>
                    <p>Du <?= $Emprunt['loaBeginDate'] ?> jusqu'au <?= $Emprunt['loaEndDate']?>.</p>
                </div>
                <div class="btnSuppArticle">
                    <form action='suppEmprunt.php' method='get'>
                        <input type='hidden' name="id" value='<?php echo $Emprunt["fkArticle"]; ?>'>
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
            <h2>Liste des articles créer :</h2>
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
                        <br>
                        <br>
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