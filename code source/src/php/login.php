<!DOCTYPE html>

<html>
    <head>
        <!--
        /// ETML
        /// Auteurs : Anthony Pfister
        /// Date : 12.05.2023
        /// Description : page de connexion pour les utilisateurs, un message s'affiche si l'utilisateur à mal saisie ces information ou pas rempli
        -->
        <meta charset="utf-8">
        <link rel="stylesheet" Href="../../resources/CSS/style.css">
        <title>Login - Gestion des prêts entre voisins</title>
    </head>
    <body>
        <!--indicateur pour le navigateur-->
        <?php $actif = 3?>
        <!--incrustation navigateur-->
        <?php include 'menu.php' ?>

        <!--Titre Page-->
        <div class="loginTitle">
            <h1>Connectez-Vous !!</h1>
        </div>
        <!--formulaire de connexion-->
        <div class="connContainer">
            <form method="post" action="checklogin.php" autocomplete="off">
                <h1 class="connTitle">Renseignez vos information de connexion svp !</h1>
                <div class="connLabelContainer">
                    <input type="text" class="connLabel" placeholder="Nom d'utilisateur" name="userName">
                </div>
                <div class="connLabelContainer">
                    <input type="password" class="connLabel" placeholder="Mot de passe" name="password">
                </div>
                <button type="submit" id="sendlogin" class="connButton">S'identifier</button>
            </form>
        </div>
        <!--Message d'erreur-->
        <div class="errMessage">
            <?php  if (isset($_GET['error'])) {
                if (isset($_SESSION["isConnected"])) {
                    $_SESSION["isConnected"] = 0;
                    $_SESSION["userName"] = "";
                }

             ?>
            <p>Vous avez mal rempli le formulaire de connexion !! s'il vous plaie recommencer.</p>
            <?php }?>
        </div>
        <!--incrustation pied de page-->
        <?php include 'footer.php' ?>
        </body>
</html>