<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 12.05.2023
/// Description : Vérifie que l'utilisateur est connecté, sinon redirige vers la page "login"
-->
<?php

    $connector = new Database();
    $checkName = $connector->getUserName($_SESSION["userName"]);
    $connector = null;

    if ($_SESSION["isConnected"] == 0 || $_SESSION["isConnected"] == null) {
        echo '<meta http-equiv="refresh" content="0, URL=login.php">';
    }

    // Pour être certain que l'utilisateur qui à ce nom existe bien
    elseif (empty($checkName)) {
        echo '<meta http-equiv="refresh" content="0, URL=disconnect.php">';
    }
?>