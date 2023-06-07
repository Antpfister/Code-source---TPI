<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 15.05.2023
/// Description : Page de vérification de l'article qui a été modifier par l'utilisateur. la page renvoye une erreur sur la page modifarticle si elle détecte une erreur. 
-->
<?php 
    /// incruste la page Database
    include "lib/Database.php";
    /// démarre la session
    session_start();

    /// déclaration de variable de vérification 
    $error = 0;
    $empty = 0;
    /// récuperation identifiant article
    $idArticle = $_POST['id'];

    /// récuperation données article et utilisateur
    $connector = new Database();
    $article=$connector->getArticle($idArticle);
    $connector = null;

    $connector = new Database();
    $user = $connector->getUser($_SESSION["idUser"]);
    $connector = null;

    if(!empty($_POST['Name'])){
        $artName = $_POST['Name'];
        
    }
    else{
        $artName = $article['artName'];
        $empty++;
    }
    
    /// vérification de la Nouvelle image de l'article
    if(!empty($_FILES['image']['name']))
    {
        
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        $imagelocation = '../../resources/images/' . $article['artPicture'];

        
        if($imageType == "image/jpeg"){
            /// supprime l'ancienne image de l'article
            unlink($imagelocation); 
            /// initialise la date par défaut  
            date_default_timezone_set('Europe/Paris');
            
            /// réécrit le nom de l'image avec la date et l'heure en plus
            $artimage = date('d-m-y_h.i.s'). $_FILES['image']['name'] ;
            echo $artimage;
            $imageDestination = '../../resources/images/' . $artimage;
            echo $imageDestination;
            if ($_FILES['image']['error'] == 0) {
            }
            else{
                $error++;
            }
        }
        else{
            $error++;
        }
    }
    else{
        $artimage = $article['artPicture'];
        $empty++;
    }

    /// vérification de la nouvelle description 
    if(!empty($_POST['description'])){
        $artdescription = $_POST['description'];

    }
    else{
        $artdescription = $article['artDescription'];
        $empty++;
    }

    /// vérifiaction du nouveau status
    if($_POST['status'] != $article['artStatus']){
        $artstatus = $_POST['status'];
        if($artstatus == 1){

            $NbLoan =$user['useNbLoan'];

            /// si le status est changé en "indisponible", l'emprunt actuelle de l'article est supprimer  
            if($NbLoan != 0){
                $NbLoan--;
                /// Supprime l'emprunt
                $connector = new Database();
                $connector->suppLoan($idArticle);
                $connector = null;
                /// mets à jour le nombre d'emprunt de l'utilisateur
                $connector = new Database();
                $connector->UpdateNbLoanUser($user["idUser"],$NbLoan);
                $connector = null;
            }
        }
    }
    else{
        $artstatus = $article['artStatus'];
        $empty++;
    }

    /// vérifie si il y a eu une erreur ou que les champs de saisis sont vide 
    if($empty == 4){
        echo '<meta http-equiv="refresh" content="0, URL=article.php?id='.$idArticle.'">';
    }
    elseif ($error == 0){
        
        /// si l'image a été modifier
        if(!empty($imageTmp)){
            // enregistre l'image
            move_uploaded_file($imageTmp, $imageDestination);
        }
        
        /// mets à jours les nouvelles informations 
        $connector = new Database();
        $connector->userModifArticle($idArticle,$artName,$artstatus,$artimage,$artdescription);
        $connector = null;

        /// retour sur la page article 
        echo '<meta http-equiv="refresh" content="0, URL=article.php?id='.$idArticle.'" >';
    }
    else{
        /// retour sur la page article avec message d'erreur 
        echo '<meta http-equiv="refresh" content="0, URL=modifArticle.php?error=1&id='.$idArticle.'">';
    }
?>