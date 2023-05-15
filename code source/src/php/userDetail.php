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
        <link rel="stylesheet" href="../../resources/css/style.css">
        <title id="title">Profil - Gestion de prêt entre voisins</title>
        
    </head>
    <body>
        <?php include "menu.php" ?>
        <?php include "checkConnection.php" ?>
        <?php

        $userName = $_SESSION["userName"];
        $connector = new Database();
        $user = $connector->getUserName($userName);
        $connector = null;
        
        ?>
            
        <?php echo "<h1>Détails de l'utilisateur ".$user['useName']."</h1>"?>
        <form action="disconnect.php">
            <button type="submit" id="send" class="connButton">Se déconnecter</button>
        </form>
        <?php include 'footer.php' ?>

    </body>
</html>