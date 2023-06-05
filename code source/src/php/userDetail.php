<!DOCTYPE html>

<html>
    <head>
        <!--
        /// ETML
        /// Auteur : Anthony Pfister
        /// Date : 12.05.2023
        /// Description : Page de profil pour voir les détail du profil de l'utilisateur. l'utilisateur est obliger de se connecter pour voir cette page sinon il est redirigé.
        ///-              Affichage liste d'article créer et emprunter. Bouton supprimer l'emprunt depuis cette page.
        -->
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title id="title">Profil - Gestion de prêt entre voisins</title>
        
    </head>
    <body>
        <!--indicateur pour le navigateur-->
        <?php $actif = 4?>
        <!--incrustation navigateur-->
        <?php include "menu.php" ?>
        <!--Check si l'utilisateur est connecté-->
        <?php include "checkConnection.php" ?>
        <?php
        /// récupère toutes les données de l'utilisateur, article et emprunt
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

        /// initialise la date
        date_default_timezone_set('Europe/Paris');
        $curDate = date('d.m.Y');
        ?>

        <!--Titre Page-->    
        <?php echo "<h1>Détails de l'utilisateur ".$user['useName']."</h1>"?>

        <!--Bouton Déconnection-->
        <form action="disconnect.php">
            <button type="submit" id="send" class="connButton">Se déconnecter</button>
        </form>
        <br>
        <br>
        <!--Message d'erreur-->
        <div class="errMessage">
            <?php  if (isset($_GET['error'])) {

             ?>
            <p>L'article n'est pas disponible !</p>
            <?php }?>
        </div>
        <br>
        <br>
        <!--Baudeau de notification si activer-->
        <div id="notifMessage" class="notifMessage">
            <p>Il reste moins de 2 jours avant la fin d'un emprunt !!!</p>
        </div>
        <!--contenaire information utilisateur-->
        <div class="infoUser">
            <h4>Créer le <?= $user["useRegisterDate"] ?></h4>
            <p>Localisation : <?= $user["useLocal"] ?></p>
            <p>Nombre d'article créer par l'utilisateur <?= $user["useNbArticles"] ?></p>
            <p>Nombre d'emprunt que l'utilisateur a actuellement :  <?= $user["useNbLoan"] ?></p>
        </div>
        <!--contenaire Liste Empunt de l'utilisateur-->
        <div class="userEmprlist">
        <h2>Liste des articles Emprunter actuellement :</h2>
            <?php
                /// Boucle pour chaque emprunt    
                foreach ($Emprunts as $Emprunt) {
                    /// met les dates dans le bon format
                    $Emprunt['loaBeginDate'] = date('d.m.Y',strtotime($Emprunt['loaBeginDate']));
                    $Emprunt['loaEndDate'] = date('d.m.Y',strtotime($Emprunt['loaEndDate']));
                    
                    /// check si l'emprunt est bien lier à l'utilisateur
                    if($Emprunt['fkUser'] == $_SESSION['idUser']){
                        /// créer la date limite pour l'affichage de la notification
                        $limiteDate = date('d.m.Y', strtotime($Emprunt['loaEndDate']."-2 day"));
                        
                        /// met les dates dans un format plus compréhensible pour la boucle if
                        $strlimiteDate = strtotime($limiteDate);
                        $strcurdate = strtotime($curDate);
                        $strLoaEndDate = strtotime($Emprunt['loaEndDate']);


                        /// check si la date limite est plus petite que la date actuelle
                        if ($strlimiteDate <= $strcurdate ){
                            /// check si la date de fin de l'emprunt est plus petite que la date actuelle 
                            if($strLoaEndDate <= $strcurdate){
                                /// l'emprunt se fait supprimer sur la page suppEmprunt
                            echo '<meta http-equiv="refresh" content="0, URL=suppEmprunt.php?id='.$Emprunt["fkArticle"].'" >';
                            }else{
                                ?>

                                <!--script javascript pour l'activation du bandeau de notification-->
                                <script>
                                /**
                                 * Affiche le contenaire du bandeau de notification 
                                 */
                                function activerConteneur() {
                                    var conteneur = document.getElementById('notifMessage');
                                    conteneur.style.display = 'block';
                                }
                                // active a fonction
                                activerConteneur();
                                </script>

                                <?php
                            }
                        } 

            ?>
            <!--Contenaire information de l'article qui est emprunter-->
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
        <!--Contenaire de la liste des article créer-->
        <div class="userEmprlist">
            <h2>Liste des articles créer :</h2>
            <?php    
            /// Boucle pour chaque article  
                foreach ($articles as $article) {
                    /// vérifie si l'article est lier à l'utilisateur
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
        <!--incrustation pied de page-->
        <?php include 'footer.php' ?>

    </body>
</html>