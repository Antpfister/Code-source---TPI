<!DOCTYPE html>

<html>
    <head>
        <!--
        /// ETML
        /// Auteur : Anthony Pfister
        /// Date : 15.05.2023
        /// Description : page de liste des articles du site enregistrer avec une barre de rechecher qui trie la liste en fonction du lieu recherché
        -->
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title id="title">Liste article - Gestion de prêt entre voisins</title>
    </head>
    <body>
        <!--indicateur pour le navigateur-->
        <?php $actif = 2?>
        <!--incrustation navigateur-->
        <?php include "menu.php"?>
        <!--Check si l'utilisateur est connecté-->
        <?php include "checkConnection.php"?>
        <!--Titre Page-->
        <div class="TitleListeArticle">
            <h1>Liste des articles</h1>
        </div>
        <!--Bouton Ajout article-->
        <div class="btnAddArticle">
            <form action="addArticle.php">
                <button type="submit" id="send" class="connButton">Ajouter un article</button>
            </form>
        </div>
        <br>
        <br>
        <!--Formulaire barre de recherche-->
        <form action = "checkRecherchebarre.php" method = "get" class="search">
            <input type = "search" name = "terme" class="searchTerm" placeholder="Chercher un article par rapport à sa localisation ?">
            <input type = "submit" name = "btn" value = "Rechercher" class="searchButton">
        </form>
        <!--Message d'erreur-->
        <?php  if (isset($_GET['error'])) {
        ?>
            <div class="errMessage">
                <p>Vous n'avez rien mis dans la barre de recherche !! s'il vous plaie recommencer.</p>
            </div>
        <?php }?>
        <br>
        <br>
        <?php
        /// regarde si il y a eu une recherche d'article 
        if(isset($_SESSION['Result'])){
        
        $Results = $_SESSION['Result'];
        /// boucle d'affichage pour chaque article
        foreach ($Results as $Result) {
            /// recherche l'article avec son identifiant
            $connector = new Database();
            $ResArticle = $connector->getArticle($Result['idArticle']);
            $connector = null;

            ?>
            <!--Contenaire d'information d'article-->
            <div class="connListeArticle">
                <div class="imgarticle">
                    <a class="imglien" href="article.php?id=<?= $ResArticle["idArticle"] ?>">
                    <img class="imgarticle" src="../../resources/images/<?= $ResArticle["artPicture"] ?>" alt="">
                    </a>
                </div>
                <div class="infoarticles">
                    <strong><?= $ResArticle['artName'] ?></strong>
                    <?php 
                    if($ResArticle['artStatus'] == 1){
                    ?>
                        <h3 class="disponible">Disponible</h3>
                    
                    <?php
                    }else{
                    ?>
                        <h3 class="emprunter">Emprunter</h3>
                    <?php
                    }
                    ?>
                    <p><?= $ResArticle['artDescription'] ?></p>
                    <h3><?= 'Créer par '.$ResArticle['useName'] . ', se situe à ' . $ResArticle['useLocal'] ?></h3>
                </div>
                <br>
                <br>
            </div>
            <?php 
            /// vide le resultat de la barre de recherche 
            unset($_SESSION['Result']);
        }
        } 
        else {
            /// récupère toutes les données de tous les articles 
            $connector = new Database();
            $articles = $connector->getAllArticlesAndInfos();
            $connector = null;    
            /// Boucle pour chaque article
            foreach ($articles as $article) {
            ?>

            <!--Contenaire pour information article-->
            <div class="connListeArticle">
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
                    <p><?= $article['artDescription'] ?></p>
                    <h3><?= 'Créer par '.$article['useName'] . ', se situe à ' . $article['useLocal'] ?></h3>
                </div>
                <br>
                <br>
            </div>
            <?php 
            }
        }
            ?>
        <br>
        <br>
        <!--incrustation pied de page-->
        <?php include 'footer.php' ?>
    </body>
</html>