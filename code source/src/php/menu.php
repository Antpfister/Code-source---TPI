<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 12.05.2023
/// description : page du menu de navigation du site au page home, liste article, login et profil
-->
<!-- Tag meta -->
<meta charset="UTF-8">
<!-- CSS -->
<link rel="stylesheet" href="../../resources/css/style.css">

<?php
include 'Database.php';
session_start();

?>
<br>
<nav class="navigateur">
    <div class="navHome">
        <a class="navbar" href="home.php">HOME</a>
    </div>
    <div class="navListArticle">
        <a class="navbar" href="articleListe.php">liste des articles</a>
    </div>
    <?php 
    if ($_SESSION["isConnected"] == 0) {
    ?>
    <div class="navlogin">
        <a class="navbar" href="login.php">Login</a>
    </div>
    <?php 
    }
    else{
    ?>
    <div class="navUserDetail">
        <a class="navbar" href="userDetail.php">Profil</a>
    </div>
    <?php 
    }
    ?>
    <br>
    <br>
</nav>
