<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : supprime l'empunt d'un article et retourne l'utilisateur sur la page profil
-->
<?php 

    include "Database.php";
    session_start();
    
    $error = 0;

    if (isset($_GET["id"])) {
        $idArticle =$_GET["id"];

    }
    if (empty($idArticle)) {
        $error =+ 1;
    }



    if($error == 0){
        $idUser = $_SESSION['idUser'];

        $connector = new Database();
        $user = $connector->getUser($idUser);
        $connector = null;
        
        $NbLoan =$user['useNbLoan'];
        if($NbLoan != 0){
            $NbLoan--;
            $connector = new Database();
            $connector->UpdateNbLoanUser($user['idUser'],$NbLoan);
            $connector = null;
        }
        $connector = new Database();
        $connector->suppLoan($idArticle);
        $connector = null;
        $connector = new Database();
        $connector->UpdateStatusArticle($idArticle,1);
        $connector = null;
            
        echo '<meta http-equiv="refresh" content="0, URL=userDetail.php">';
        
    }else {
        
        echo '';
        
    }


?>