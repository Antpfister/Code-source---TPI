<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 15.05.2023
/// Description : page de vérification de l'article qui a été ajouté par l'utilisateur.
-->
<?php 
    /// incruste la page Database
    include "lib/Database.php";
    /// démarre la session
    session_start();
    /// déclaration de variable de vérification 
    $error = 0;

    /// vérifie le nom de l'article
    if(isset($_POST['Name'])){
        $artName = $_POST['Name'];
        
        if(empty($artName)){
            
            $error =+ 1;
        }
    }
    /// vérifie l'image de l'article
    if(isset($_FILES['image']['name']))
    {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        
        
        if($imageType == "image/jpeg"){
            /// initialise la date actuelle
            date_default_timezone_set('Europe/Paris');
            /// réécrit le nom de l'image avec la date et l'heure en plus
            $artimage = date('d-m-y_h.i.s'). $_FILES['image']['name'] ;
            $imageDestination = '../../resources/images/' . $artimage;


            if ($_FILES['image']['error'] == 0) {
            }
            else{
                $error =+ 1;
            }
        }
        else{
            $error =+ 1;
        }
    }
    else{
        $error =+ 1;
    }
    // vérifie la description
    if(isset($_POST['description'])){
        $artdescription = $_POST['description'];

        if(empty($artdescription)){
            $error =+ 1;
        }
    }
    // donne l'identifiant actuelle de l'utilisateur pour le lier à l'article créé
    $connector = new Database();
    $tableuser = $connector->getUserID($_SESSION["idUser"]);
    $artuser = $tableuser['idUser'];
    $connector = null;

    // vérifie le satus de l'article
    if(isset($_POST['status'])){
        $artstatus = $_POST['status'];
    }

    // vérifie si il n'y a pas eu d'erreur
    if($error == 0){
        // enregistre l'image dans le répertoire
        move_uploaded_file($imageTmp, $imageDestination);
        /// récupère les données de l'utilisateur
        $connector = new Database();
        $user = $connector->getUser($_SESSION["idUser"]);
        $connector = null;

        /// met à jour le nombre d'article créer par l'utilisateur
        $NbArticles =$user['useNbArticles'];
        $NbArticles++;

        /// créer l'article dans la base de données 
        $connector = new Database();
        $connector->insertArticle($artName,$artstatus,$artimage,$artdescription,$artuser);
        $connector = null;

        /// met à jour les information de l'utilisteur dans la base de données 
        $connector = new Database();
        $connector->UpdateNbArticleUser($artuser,$NbArticles);
        $connector = null;

        /// retour sur la page liste des articles
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php">';
    }
    else{
        /// retour sur la page ajout d'article avec un message d'erreur
        echo '<meta http-equiv="refresh" content="0, URL=addArticle.php?error=1">';
    }
?>