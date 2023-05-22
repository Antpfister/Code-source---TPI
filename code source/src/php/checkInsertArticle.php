<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 15.05.2023
/// Description : page de vérification de l'article qui a été ajouté par l'utilisateur.
-->
<?php 
    include "Database.php";
    session_start();

    $error = 0;

    if(isset($_POST['Name'])){
        $artName = $_POST['Name'];
        
        if(empty($artName)){
            
            $error =+ 1;
        }
    }
    
    if(isset($_FILES['image']['name']))
    {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        
        
        if($imageType == "image/jpeg"){
            date_default_timezone_set('Europe/Paris');
            
            $artimage = date('d-m-y_h:i:s'). $_FILES['image']['name'] ;
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
    if(isset($_POST['description'])){
        $artdescription = $_POST['description'];

        if(empty($artdescription)){
            $error =+ 1;
        }
    }

    $connector = new Database();
    $tableuser = $connector->getUserID($_SESSION["idUser"]);
    $artuser = $tableuser['idUser'];
    $connector = null;

    if(isset($_POST['status'])){
        $artstatus = $_POST['status'];
    }

    if($error == 0){
        // enregistre l'image et le pdf
        move_uploaded_file($imageTmp, $imageDestination);

        $connector = new Database();
        $connector->insertArticle($artName,$artstatus,$artimage,$artdescription,$artuser);
        $connector = null;

        echo '<meta http-equiv="refresh" content="0, URL=home.php">';
    }
    else{
        echo '<meta http-equiv="refresh" content="0, URL=addArticle.php?error=1">';
    }
?>