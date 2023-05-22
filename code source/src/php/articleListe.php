<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : page  de liste des articles du site enregistrer avec une barre de rechecher qui trie la liste en fonction du lieu rechercher 
-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title id="title">Liste article - Gestion de prêt entre voisins</title>
    </head>
    <body>
        <?php $actif = 2?>
        <?php include "menu.php"?>
        <?php include "checkConnection.php"?>
        <div class="TitleListeArticle">
            <h1>Liste des articles</h1>
        </div>
        <div class="btnAddArticle">
            <form action="addArticle.php">
                <button type="submit" id="send" class="connButton">Ajouter un article</button>
            </form>
        </div>
        <br>
        <br>
        <form action = "checkRecherchebarre.php" method = "get">
            <input type = "search" name = "terme">
            <input type = "submit" name = "btn" value = "Rechercher">
        </form>
        <?php if(isset($_GET['Result'])){
            echo $_GET['Result'];
        } ?>
        <div class="errMessage">
            <?php  if (isset($_GET['error'])) {

             ?>
            <p>Vous n'avez rien mis dans la barre de recherche !! s'il vous plaie recommencer.</p>
            <?php }?>
        </div>
        <br>
        <br>
        <?php
        $connector = new Database();
        $articles = $connector->getAllArticlesAndInfos();
        $connector = null;

        foreach ($articles as $article) {
        ?>
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
            ?>
        <br>
        <br>
        <?php include 'footer.php' ?>
    </body>
</html>