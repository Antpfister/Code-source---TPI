<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : page de vérification de la recherche et revoie le resultat
-->

<?php 
    /// incruste la page Database
    include "lib/Database.php";
    /// démarre la session
    session_start();

    /// déclaration de variable de vérification 
    $barrResult = 0;
    $barrRecherche = 0;
    $error = 0;

    /// check si la saisis de la barre de recherche n'est pas vide
    if(isset($_GET['terme'])){
        $barrRecherche = $_GET['terme'];
        $barrRecherche = trim($barrRecherche);

        if(empty($barrRecherche)){
            $error++;
        }
    }


    /// vérifie si il y a eu une erreur
    if($error == 0){
        
        /// fait une selection d'article via requète SQL
        $connector = new Database();
        $barrResults= $connector->searchlocal($barrRecherche);
        $connector = null;

        $_SESSION['Result'] =$barrResults; 

        /// retour sur la page article
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php">';
    }
    else{
        /// retour sur la page article avec message d'erreur 
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php?error=1">';
    }




?>