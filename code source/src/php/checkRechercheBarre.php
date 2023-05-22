<!--
/// ETML
/// Auteur : Anthony Pfister
/// Date : 15.05.2023
/// Description : page de vérification de la recherche et revoie le resultat
-->

<?php 
    include "Database.php";
    session_start();

    $barrResult = 0;
    $barrRecherche = 0;
    $error = 0;

    if(isset($_GET['terme'])){
        $barrRecherche = $_GET['terme'];
        $barrRecherche = trim($barrRecherche);

        if(empty($barrRecherche)){
            $error++;
        }
    }



    if($error == 0){
        

        $connector = new Database();
        $barrResults= $connector->searchlocal($barrRecherche);
        $connector = null;

        $_SESSION['Result'] =$barrResults; 

        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php">';
    }
    else{
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php?error=1">';
    }




?>