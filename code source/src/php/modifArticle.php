<!DOCTYPE html>

<html>
    <head>
        <!--
        /// ETML
        /// Auteurs : Anthony Pfister
        /// Date : 17.05.2023
        /// Description : Page de modification d'un article, l'utilisateur doit renseigner les nouvelle information qu'il veut modifier. Si certaines partie ne sont pas rempli alors la modification ne la prend pas en compte
        ///               et la partie est inchangé.
        -->
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title>Modifier article - Gestion de prêt entre voisins</title>
    </head>
    <body>
    <?php $actif = 0?>
        <?php

            /// incruste la page navigation
            include "menu.php";
            /// incruste la page Database
            include "checkConnection.php";

            $idArticle =$_GET["id"];
        

            /// récuperation données de l'article
            $connector = new Database();
            $article=$connector->getArticle($idArticle);
            $connector = null;
        ?>
        <!--Titre Page-->
        <div class="titleModifArticle">
            <h1 >Modification de l'article "<?= $article['artName'] ?>"</h1>
        </div>
        <!--Formulaire de modification d'article-->
        <div class="divformModifArticle">
            <form method="post" action="checkModifArticle.php" enctype="multipart/form-data">
                <label for="Name">Nom de l'article :</label>
                <input type="text" name="Name" class="AddLabel" id="Name" placeholder="<?= $article['artName'] ?>">
                <br>
                <br>
                <label for="image">Photo de l'article (.jpg) :</label>
                <input name="image" type="file" class="AddLabel" id="image">    
                <br>
                <br>
                <label for="description">Description de l'article :</label>
                <textarea name="description" class="AddLabel" id="description" placeholder="<?= $article['artDescription'] ?>"></textarea>
                <br>
                <br>
                
                <label for="status">Le status de l'article :</label>
                <input type="radio" id="disponible" name="status" value="1" checked>
                <label for="huey">disponible</label>
                <input type="radio" id="indisponible" name="status" value="0">
                <label for="huey">indisponible</label>
                
                <br>
                <br>
                <input type='hidden' name="id" value='<?php echo $article["idArticle"]; ?>'>
                <input type="submit"  value="Modifier" class="connButton">
                <input type="reset"  value="Vider"  class="connButton">
            </form>
        </div>
        <!--Message d'erreur-->
        <?php  if (isset($_GET['error'])) {
        ?>
            <div class="errMessage">
                <p>Vous avez mal rempli le formulaire de modification de article !! s'il vous plaie recommencer.</p>
            </div>
        <?php }?>
        <!--incrustation pied de page-->
        <?php include 'footer.php' ?>
    </body>
</html>