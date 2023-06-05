<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 21.05.2021
/// Description : check les informations pour la connexion de l'utilisateur
-->
<?php
    /// incruste la page Database
    include "lib/Database.php";
    /// démarre la session
    session_start();
    /// déclaration de variable de vérification 
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
    /// récupère le nom de l'utilisateur 
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
    /// vérifie si il n'y a pas eu d'erreur 
    if($error == 0){
        /// connecte l'utilisateur à la session
        $_SESSION["isConnected"] = 1;
        $_SESSION["userName"] = $userName;
        $_SESSION["idUser"] = $user["idUser"];
        /// retour sur la page home
        echo '<meta http-equiv="refresh" content="0, URL=home.php">';
    }
    else {
        /// retour sur la page de login avec un message d'erreur
        echo '<meta http-equiv="refresh" content="0, URL=login.php?error=1">';
        
    }
?>