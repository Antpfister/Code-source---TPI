<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 15.05.2023
/// Description : page d'ajout d'article dans la base de données, l'utilisateur doit remplir le formulaire
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title>Ajout article - Gestion de prêt entre voisins</title>
    </head>
    <body>
    <?php $actif = 0?>
        <?php
            include "menu.php";
            include "checkConnection.php";
        ?>
        <div class="titleAddArticle">
            <h1 >Ajouter un Article</h1>
        </div>
        <div class="divformAddArticle">
            <form method="post" action="checkInsertArticle.php" enctype="multipart/form-data">
                <label for="Name">Nom de l'article :</label>
                <input type="text" name="Name" class="AddLabel" id="Name" placeholder="Name">
                <br>
                <br>
                <label for="image">Photo de l'article (.jpg) :</label>
                <input name="image" type="file" class="AddLabel" id="image" >    
                <br>
                <br>
                <label for="description">Description de l'article :</label>
                <textarea name="description" class="AddLabel" id="description" placeholder="description"></textarea>
                <br>
                <br>
                <label for="status">Le status de l'article :</label>
                <input type="radio" id="disponible" name="status" value="1"checked>
                <label for="huey">disponible</label>
                <input type="radio" id="indisponible" name="status" value="0">
                <label for="huey">indisponible</label>
                <br>
                <br>
                <input type="submit" class="btn btn-primary mt-4" value="Ajouter">
                <input type="reset" class="btn btn-primary mt-4" value="Vider">
            </form>
        </div>
        <div class="errMessage">
            <?php 
            if (isset($_GET['error'])) {
             ?>
            <p>Vous avez mal rempli le formulaire d'ajout d'article !! s'il vous plaie recommencer.</p>
            <?php }?>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>