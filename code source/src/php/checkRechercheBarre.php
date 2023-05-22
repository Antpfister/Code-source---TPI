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
        $barrResult= $connector->searchlocal($barrRecherche);
        $connector = null;
        
        echo var_dump($barrResult);

        ///echo '<meta http-equiv="refresh" content="0, URL=articleListe.php?Result='. $barrResult['idUser'] .'">';
    }
    else{
        echo '<meta http-equiv="refresh" content="0, URL=articleListe.php?error=1">';
    }




?>