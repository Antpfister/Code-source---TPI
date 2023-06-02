<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : supprime l'article et retourne l'utilisateur sur la page de liste des articles 
-->
<?php 

    include "lib/Database.php";
    session_start();
    
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
        $idUser = $_SESSION['idUser'];

        $connector = new Database();
        $user = $connector->getUser($idUser);
        $connector = null;

        $NbArticles =$user['useNbArticles'];
        $NbArticles--;

        if($user['useNbLoan'] != 0){
            $NbLoan = $user['useNbLoan'];
            $NbLoan--;
            $connector = new Database();
            $connector->suppLoan($idArticle);
            $connector = null;
            $connector = new Database();
            $connector->UpdateNbLoanUser($user['idUser'],$NbLoan);
            $connector = null;
        }

        $connector = new Database();
        $connector->suppArticle($idArticle);
        $connector = null;

        $connector = new Database();
        $connector->UpdateNbArticleUser($user['idUser'],$NbArticles);
        $connector = null;


        unlink($imagelocation);    
            
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php">';
        
    }else {
        
        echo '';
        
    }


?>