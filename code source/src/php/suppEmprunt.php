<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : supprime l'emprunt d'un article et retourne l'utilisateur sur la page profil
-->
<?php 
    /// incruste la page Database
    include "lib/Database.php";
    /// démarre la session
    session_start();
    /// déclaration de variable de vérification
    $error = 0;

    /// récuperation identifiant article
    if (isset($_GET["id"])) {
        $idArticle =$_GET["id"];

    }
    if (empty($idArticle)) {
        $error =+ 1;
    }


    /// vérifie si il y a eu une erreur
    if($error == 0){
        /// récupère l'identifiant de l'utilisateur
        $idUser = $_SESSION['idUser'];
        /// récupère les données de l'utilisateur
        $connector = new Database();
        $user = $connector->getUser($idUser);
        $connector = null;
        
        $NbLoan =$user['useNbLoan'];
        /// met à jour le nombre d'emprunt de l'utilisateur
        if($NbLoan != 0){
            $NbLoan--;
            $connector = new Database();
            $connector->UpdateNbLoanUser($user['idUser'],$NbLoan);
            $connector = null;
        }
        /// supprime l'emprunt de l'article
        $connector = new Database();
        $connector->suppLoan($idArticle);
        $connector = null;
        /// met à jours les information de l'article
        $connector = new Database();
        $connector->UpdateStatusArticle($idArticle,1);
        $connector = null;
        
        /// retour sur la page profil
        echo '<meta http-equiv="refresh" content="0, URL=userDetail.php">';
        
    }else {
        /// retour sur la page profil avec message d'erreur
        echo '<meta http-equiv="refresh" content="0, URL=userDetail.php?error=1">';
        
    }


?>