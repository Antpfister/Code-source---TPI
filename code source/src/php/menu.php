<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 12.05.2023
/// description : page du menu de navigation du site au page home, liste article, login et profil
-->
<!-- Tag meta -->
<meta charset="UTF-8">
<!-- CSS -->

<!--<link rel="stylesheet" Href="../../resources/CSS/style.css">-->
<link rel="stylesheet" href="../../resources/CSS/style.css?v=<?php echo time(); ?>">
<?php
include 'Database.php';
session_start();



?>
<br>
<nav class="navigateur">
    <div class="navHome">
        <?php if ($actif == 1) { ?>
        <a class="actif" href="home.php">HOME</a>
        <?php }
        else{?>
        <a class="navBarr" href="home.php">HOME</a>
        <?php }?>
    </div>
    <div class="navListArticle">
    <?php if ($actif == 2) { ?>
        <a class="actif" href="articleListe.php">Liste des Articles</a>
        <?php }
        else{?>
        <a class="navBarr" href="articleListe.php">Liste des Articles</a>
        <?php }?>
    </div>
    <?php 
    if (!isset($_SESSION["isConnected"])) {
       
    ?>
    <div class="navlogin">
    <?php if ($actif == 3) { ?>
        <a class="actif" href="login.php">Login</a>
        <?php }
        else{?>
        <a class="navBarr" href="login.php">Login</a>
        <?php }?>
    </div>
    <?php 
    }
    else{
    ?>
    <div class="navUserDetail">
    <?php if ($actif == 4) { ?>
        <a class="actif" href="userDetail.php"><?= $_SESSION["userName"] ?> / Profil</a>
        <?php }
        else{?>
        <a class="navBarr" href="userDetail.php"><?= $_SESSION["userName"] ?> / Profil</a>
        <?php }?>
    </div>
    <?php 
    }
    ?>
    <br>
    <br>
</nav>
