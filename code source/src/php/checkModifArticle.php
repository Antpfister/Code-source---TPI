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
    $empty = 0;
    $idArticle = $_POST['id'];

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
    
    if(!empty($_FILES['image']['name']))
    {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        $imagelocation = '../../resources/images/' . $article['artPicture'];

        unlink($imagelocation);  
        
        if($imageType == "image/jpeg"){
            date_default_timezone_set('Europe/Paris');
            
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

    if(!empty($_POST['description'])){
        $artdescription = $_POST['description'];

    }
    else{
        $artdescription = $article['artDescription'];
        $empty++;
    }

    if($_POST['status'] != $article['artStatus']){
        $artstatus = $_POST['status'];
        if($artstatus == 1){

            $NbLoan =$user['useNbLoan'];

            if($NbLoan != 0){
                $NbLoan--;
                $connector = new Database();
                $connector->suppLoan($idArticle);
                $connector = null;
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

    if($empty == 4){
        echo '<meta http-equiv="refresh" content="0, URL=article.php?id='.$idArticle.'">';
    }
    elseif ($error == 0){
        
        if(!empty($imageTmp)){
            // enregistre l'image
            move_uploaded_file($imageTmp, $imageDestination);
        }
        

        $connector = new Database();
        $connector->userModifArticle($idArticle,$artName,$artstatus,$artimage,$artdescription);
        $connector = null;

        echo '<meta http-equiv="refresh" content="0, URL=article.php?id='.$idArticle.'" >';
    }
    else{
        echo '<meta http-equiv="refresh" content="0, URL=modifArticle.php?error=1&id='.$idArticle.'">';
    }
?>