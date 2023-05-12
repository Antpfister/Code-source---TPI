<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 21.05.2021
/// Description : check les information pour la connexion de l'utilisateur
-->
<?php
    include "Database.php";
    session_start();

    $error = 0;

    // Vérifie pour le nom
    if (isset($_POST["userName"])) {
        $userName = $_POST["userName"];

        if (empty($userName)) {
            $error++;
        }
    }
    else {
        $error++;
    }
    
    $connector = new Database();
    $user = $connector->getUserName($userName);
    $connector = null;

    // Vérifie que le nom d'utilisateur existe
    if (empty($user)) {
        $error++;
    }

    // Vérifie que le mot de passe du l'utilisateur est correcte
    if (isset($_POST["password"])) {
        $password = $_POST["password"];

        if (empty($password)) {
            $error++;
        }

        // Vérifie si il est identique que celui de la db
        elseif ($user["usePassword"] != $password) {
            $error++;
        }
    }
    else {
        $error++;
    }
    
    if($error == 0){

        $_SESSION["isConnected"] = 1;
        $_SESSION["userName"] = $userName;
        $_SESSION["idUser"] = $user["idUser"];

        echo '<meta http-equiv="refresh" content="0, URL=home.php">';
    }
    else {
        
        echo '<meta http-equiv="refresh" content="0, URL=login.php?error=1">';
        
    }
?>