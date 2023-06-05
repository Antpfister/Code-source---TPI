<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 12.05.2023
/// description : page du menu de navigation du site au page home, liste article, login et profil
-->
<link rel="stylesheet" href="../../resources/CSS/style.css?v=<?php echo time(); ?>">

<?php
    /// incruste la page Database
    include 'lib/Database.php';
    /// démarre la session
    session_start();
?>
<br>

<!--Contenaire naviagteur-->
<nav class="navigateur">
    <div class="navHome">
        <!--Si la page correspond à cette onglet-->
        <?php if ($actif == 1) { ?>
        <a class="actif" href="home.php">HOME</a>
        <?php }
        else{?>
        <a class="navBarr" href="home.php">HOME</a>
        <?php }?>
    </div>
    <div class="navListArticle">
        <!--Si la page correspond à cette onglet-->
        <?php if ($actif == 2) { ?>
        <a class="actif" href="articleListe.php">Liste des Articles</a>
        <?php }
        else{?>
        <a class="navBarr" href="articleListe.php">Liste des Articles</a>
        <?php }?>
    </div>
    <?php 
    if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == 0) {
       
    ?>
    <div class="navlogin">
        <!--Si la page correspond à cette onglet-->
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
        <!--Si la page correspond à cette onglet-->
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
