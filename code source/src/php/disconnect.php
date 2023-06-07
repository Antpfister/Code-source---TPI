<!--
/// ETML
/// Auteurs : Anthony Pfister
/// Date : 12.05.2023
/// Description : Page qui fait déconnecter un utilisateur qui n'est pas sensé existé ou qui n'est pas reconnu
-->
<?php
    /// démarre la session
    session_start();
    
    /// change le status connecter en déconnecter 
    if ($_SESSION["isConnected"] == 1) {
        $_SESSION["isConnected"] = 0;
        $_SESSION["userName"] = "";
    }

    /// retour sur la page login
    echo '<meta http-equiv="refresh" content="0, URL=login.php">';
?>