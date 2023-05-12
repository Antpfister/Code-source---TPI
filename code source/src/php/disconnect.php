<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 12.05.2023
/// Description : Page qui fait déconnecter un utilisateur qui n'est pas sensé existé ou qui n'est pas reconnu
-->
<?php
    session_start();
        
    if ($_SESSION["isConnected"] == 1) {
        $_SESSION["isConnected"] = 0;
        $_SESSION["userName"] = "";
    }

    echo '<meta http-equiv="refresh" content="0, URL=login.php">';
?>