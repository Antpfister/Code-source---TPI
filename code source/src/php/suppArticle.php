<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : supprime l'article et retourne l'utilisateur sur la page de liste des articles 
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

    /// suppresion de l'image enregistrer de l'article
    if (isset($_GET["picture"])) {
        $artPicture =$_GET["picture"];
        $imagelocation = '../../resources/images/' . $artPicture;
    }
    if (empty($artPicture)) {
        $error =+ 1;
    }

   /// vérifie si il y a eu une erreur
    if($error == 0){
        /// récupère l'identifiant de l'utilistateur
        $idUser = $_SESSION['idUser'];

        /// récupère les données grâce à l'identifiant
        $connector = new Database();
        $user = $connector->getUser($idUser);
        $connector = null;
        
        /// met à jour le nombre d'article de l'utilisateur
        $NbArticles =$user['useNbArticles'];
        $NbArticles--;

        /// si le status est changé en "indisponible", l'emprunt actuelle de l'article est supprimer
        if($user['useNbLoan'] != 0){
            $NbLoan = $user['useNbLoan'];
            $NbLoan--;
            /// Supprime l'emprunt
            $connector = new Database();
            $connector->suppLoan($idArticle);
            $connector = null;
            /// mets à jour le nombre d'emprunt de l'utilisateur
            $connector = new Database();
            $connector->UpdateNbLoanUser($user['idUser'],$NbLoan);
            $connector = null;
        }
        /// supprime l'article définitivement avec une requète SQL
        $connector = new Database();
        $connector->suppArticle($idArticle);
        $connector = null;

        /// met à jour le nombre d'article de l'utilisateur via requète SQL
        $connector = new Database();
        $connector->UpdateNbArticleUser($user['idUser'],$NbArticles);
        $connector = null;

        /// suppresion de l'image enregistrer de l'article
        unlink($imagelocation);    
            
        /// retour sur la page liste d'article
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php">';
        
    }else {
        /// retour sur la page article avec message d'erreur
        echo '<meta http-equiv="refresh" content="0, URL=article.php?error=1&id='.$idArticle.'">';
        
    }


?>