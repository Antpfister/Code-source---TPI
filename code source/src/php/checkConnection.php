<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 12.05.2023
/// Description : Vérifie que l'utilisateur est connecté, sinon redirige vers la page "login"
-->
<?php
    /// récupère le nom de l'utilisateur
    $connector = new Database();
    $checkName = $connector->getUserName($_SESSION["userName"]);
    $connector = null;

    /// vérifie que l'utilisateur est bien connecter
    if ($_SESSION["isConnected"] == 0 || $_SESSION["isConnected"] == null) {
        // retour sur la page login
        echo '<meta http-equiv="refresh" content="0, URL=login.php">';
    }

    // Pour être certain que l'utilisateur qui à ce nom existe bien
    elseif (empty($checkName)) {
        echo '<meta http-equiv="refresh" content="0, URL=disconnect.php">';
    }
?>