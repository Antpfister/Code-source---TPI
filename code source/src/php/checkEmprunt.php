<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 22.05.2023
/// Description : page de vérification de l'emprunt d'un article et création de l'emprunt dans la base de données.
-->
<?php 
    include "Database.php";
    session_start();

    $error = 0;
    $idArticle = $_POST['id'];
    function isValid($date, $format = 'd.m.Y'){
        $dt = DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }  

        
    if(isset($_POST['DateBegin'])){
        $emprDateBegin = $_POST['DateBegin'];
    }
    else{
        $error++;
    }

        
    if(isset($_POST['DateEnd'])){
        $emprDateEnd = $_POST['DateEnd'];
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