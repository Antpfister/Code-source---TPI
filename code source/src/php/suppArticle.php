<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : supprime l'article et retourne l'utilisateur sur la page de liste des articles 
-->
<?php 

    include "Database.php";
    
    $error = 0;

    if (isset($_GET["id"])) {
        $idArticle =$_GET["id"];

    }
    if (empty($idArticle)) {
        $error =+ 1;
    }

    if (isset($_GET["picture"])) {
        $artPicture =$_GET["picture"];
        $imagelocation = '../../resources/images/' . $artPicture;
    }
    if (empty($artPicture)) {
        $error =+ 1;
    }


    if($error == 0){
    
    $connector = new Database();
    $connector->suppArticle($idArticle);
    $connector = null;

    unlink($imagelocation);    
        
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php">';
    }else {
        
        echo '';
        
    }


?>