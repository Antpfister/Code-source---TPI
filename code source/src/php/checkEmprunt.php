<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 22.05.2023
/// Description : page de vérification de l'emprunt d'un article et création de l'emprunt dans la base de données.
-->
<?php 
    include "lib/Database.php";
    session_start();

    $error = 0;
    $idArticle = $_POST['id'];
    date_default_timezone_set('Europe/Paris');
    $curDate = date('d.m.Y');

    $strcurdate = strtotime($curDate);
        
    if(isset($_POST['DateBegin'])){
        $strDateBegin = strtotime($_POST['DateBegin']);

        if($strDateBegin >= $strcurdate)
        {
            $emprDateBegin = $_POST['DateBegin'];
        }
        else{
            $error++;
        }
    }
    else{
        $error++;
    }

        
    if(isset($_POST['DateEnd'])){
        $emprDateEnd = $_POST['DateEnd'];
        $strDateEnd = strtotime($_POST['DateEnd']);

        if($strDateEnd > $strcurdate)
        {
            $emprDateEnd = $_POST['DateEnd'];
        }
        else{
            $error++;
        }
    }
    else{
        $error++;
    }

    if($strDateBegin < $strDateEnd){
        
    }
    else{
        $error++;
    }

    
    if($error == 0){
        
        $idUser = $_SESSION['idUser'];

        $connector = new Database();
        $article = $connector->getArticle($idArticle);
        $user = $connector->getUser($idUser);
        $connector = null;

        $Status = $article['artStatus'];
        $Status =0;

        
        $Nbloan = $user['useNbLoan'];
        $Nbloan ++;

        $connector = new Database();
        $connector->insertLoan($emprDateBegin,$emprDateEnd,$idArticle,$idUser);
        $connector = null;
        
        $connector = new Database();
        $connector->UpdateStatusArticle($idArticle,$Status);
        $connector = null;

        $connector = new Database();
        $connector->UpdateNbLoanUser($idUser,$Nbloan);
        $connector = null;


        echo '<meta http-equiv="refresh" content="0, URL=article.php?id='.$idArticle.'" >';
    }
    else{
        echo '<meta http-equiv="refresh" content="0, URL=empruntArticle.php?error=1&id='.$idArticle.'">';
    }
?>