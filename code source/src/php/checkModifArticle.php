<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 15.05.2023
/// Description : page de vérification de l'article qui a été modifier par l'utilisateur.
-->
<?php 
    include "Database.php";
    session_start();

    $error = 0;
    $idArticle = $_POST['id'];

    $connector = new Database();
    $article=$connector->getArticle($idArticle);
    $connector = null;

    if(!empty($_POST['Name'])){
        $artName = $_POST['Name'];
        
    }
    else{
        $artName = $article['artName'];
    }
    
    if(!empty($_FILES['image']['name']))
    {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        
        
        if($imageType == "image/jpeg"){

            $artimage = $_FILES['image']['name'] ;
            $imageDestination = '../../resources/images/' . $artimage;
            
            $imagelocation = '../../resources/images/' . $article['artPicture'];

            unlink($imagelocation);   
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
        $artimage = $article['artPicture'];
    }

    if(!empty($_POST['description'])){
        $artdescription = $_POST['description'];

    }
    else{
        $artdescription = $article['artDescription'];
    }

    if($_POST['status'] != $article['artStatus']){
        $artstatus = $_POST['status'];
    }
    else{
        $artstatus = $article['artStatus'];
    }

    if($error == 0){
        if(!empty($imageTmp)){
            // enregistre l'image et le pdf
            move_uploaded_file($imageTmp, $imagelocation);
        }

        $connector = new Database();
        $connector->userModifArticle($idArticle,$artName,$artstatus,$artimage,$artdescription);
        $connector = null;

        echo '<meta http-equiv="refresh" content="0, URL=article.php?id='.$idArticle.'" >';
    }
    else{
        echo '<meta http-equiv="refresh" content="0, URL=modifArticle.php?error=1&id='.$idArticle.'>';
    }
?>