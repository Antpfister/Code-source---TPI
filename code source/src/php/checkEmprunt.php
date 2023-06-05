<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 22.05.2023
/// Description : page de vérification de l'emprunt d'un article et création de l'emprunt dans la base de données.
-->
<?php 
    /// incruste la page Database
    include "lib/Database.php";
    /// démarre la session
    session_start();
    /// déclaration de variable de vérification 
    $error = 0;
    $idArticle = $_POST['id'];
    /// initialise la date actuelle
    date_default_timezone_set('Europe/Paris');
    $curDate = date('d.m.Y');
    /// met la date dans un meilleur format 
    $strcurdate = strtotime($curDate);
    
    // vérification de la date du début
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

    /// vérification de la date de début
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
    /// vérifie que la date de début est bien avant la date de fin
    if($strDateBegin < $strDateEnd){
        
    }
    else{
        $error++;
    }

    /// vérifie qu'il n'y a pas eu d'erreur
    if($error == 0){
        /// récupère l'identifiant de l'utilisateur
        $idUser = $_SESSION['idUser'];
        
        /// récupère les données de l'utilisateur et de l'article
        $connector = new Database();
        $article = $connector->getArticle($idArticle);
        $user = $connector->getUser($idUser);
        $connector = null;

        // met à jour le status
        $Status = $article['artStatus'];
        $Status =0;

        // met à jour le nombre d'emprunt de l'utilisateur
        $Nbloan = $user['useNbLoan'];
        $Nbloan ++;

        // créer l'emprunt dans la base de données 
        $connector = new Database();
        $connector->insertLoan($emprDateBegin,$emprDateEnd,$idArticle,$idUser);
        $connector = null;
        
        /// met à jour le status dans la base de données
        $connector = new Database();
        $connector->UpdateStatusArticle($idArticle,$Status);
        $connector = null;

        /// met à jour le nombre d'emprunt dans la base de données
        $connector = new Database();
        $connector->UpdateNbLoanUser($idUser,$Nbloan);
        $connector = null;

        // retour sur la page article
        echo '<meta http-equiv="refresh" content="0, URL=article.php?id='.$idArticle.'" >';
    }
    else{
        // retour sur la page article avec un message d'erreur
        echo '<meta http-equiv="refresh" content="0, URL=empruntArticle.php?error=1&id='.$idArticle.'">';
    }
?>