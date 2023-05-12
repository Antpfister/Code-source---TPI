<?php
/*
    ETML
    Auteur : Anthony Pfister
    Date 12.05.2023
    Description : Crée une connexion à db_gestionpretvoisins, et renvoie des données de la db.
*/

include 'config.php';

class Database {
    // Variable de classe
    private $connector;

    /**
     * Crée la connexion à la db
     */
    public function __construct(){
        $user = $GLOBALS['MM_CONFIG']['database']['username'];
        $pass = $GLOBALS['MM_CONFIG']['database']['password'];
        $dbname = $GLOBALS['MM_CONFIG']['database']['dbname'];
        $host = $GLOBALS['MM_CONFIG']['database']['host'];
        $port = $GLOBALS['MM_CONFIG']['database']['port'];
        $charset = $GLOBALS['MM_CONFIG']['database']['charset'];

        $this->connector = new PDO(
            'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';charset=' . $charset, $user, $pass
        );
    }

    /**
     * Fait une requête simple
     */
    private function querySimpleExecute($query){
        return $req = $this->connector->query($query);
    }

    /**
     * Requête à la db en utilisant les requêtes préparées
     */
    private function queryPrepareExecute($query, $binds){
        $req = $this->connector->prepare($query, $binds);

        if (!empty($binds)) {
            foreach ($binds as $bind) {
                $req->bindValue($bind["marker"], $bind["value"], $bind["type"]);
            }
        }

        $req->execute();

        return $req;
    }

    /**
     * Retoune les données de la requête sont forme de tableau associatif
     */
    private function formatData($req){
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vide le jeu d'enregistrement
     */
    private function unsetData($req){
        $req->closeCursor();
    }

    
    /**
     * Retourne les données d'un utilisateur grâce à son nom
     */
    public function getUserName($userName){
        $query = 'SELECT * FROM t_user WHERE useName = :userName';

        $binds = array(
            0 => array(
                'marker' => 'userName',
                'value'  => $userName,
                'type'   => PDO::PARAM_STR
            )
        );

        $req = $this->queryPrepareExecute($query, $binds);
        $result = $this->formatData($req);

        $this->unsetData($req);

        if (!empty($result)) {
            return $result[0];
        }
    }

} 

?>