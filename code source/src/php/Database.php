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
    private function queryPrepareExecuteArray($query, $binds){
        $req = $this->connector->prepare($query, $binds);

        if (!empty($binds)) {
            foreach ($binds as $bind) {
                $req->bindValue($bind["marker"], $bind["value"], $bind["type"]);
            }
        }
        
        $req->execute();
        $result = $req->mysqli_stmt_get_result();


        return $result;
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
    public function getUserID($idUser){
        $query = 'SELECT idUser FROM t_user WHERE idUser = :idUser';

        $binds = array(
            0 => array(
                'marker' => 'idUser',
                'value'  => $idUser,
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
    public function insertArticle($artName,$artstatus,$artimage,$artdescription,$artuser) {
        $query = "INSERT INTO t_article(artName,artStatus,artPicture,artDescription,fkUserArticle) 
        VALUES(:artName,:artstatus,:artimage,:artdescription,:artuser)";

        $binds = array(
            0 => array(
                'marker' => 'artName',
                'value'  => $artName,
                'type'   => PDO::PARAM_STR
            ),
            1 => array(
                'marker' => 'artstatus',
                'value'  => $artstatus,
                'type'   => PDO::PARAM_INT
            ),
            2 => array(
                'marker' => 'artimage',
                'value'  => $artimage,
                'type'   => PDO::PARAM_STR
            ),
            3 => array(
                'marker' => 'artdescription',
                'value'  => $artdescription,
                'type'   => PDO::PARAM_STR
            ),
            4 => array(
                'marker' => 'artuser',
                'value'  => $artuser,
                'type'   => PDO::PARAM_INT
            ),
        );

        $req = $this->queryPrepareExecute($query, $binds);

        $this->unsetData($req);
    }
    public function insertLoan($emprDateBegin,$emprDateEnd,$FKArticle,$FKUser) {
        $query = "INSERT INTO t_loan(loaBeginDate,loaEndDate,fkArticle,fkUser) 
        VALUES(:emprDateBegin,:emprDateEnd,:FKArticle,:FKUser)";

        $binds = array(
            0 => array(
                'marker' => 'emprDateBegin',
                'value'  => $emprDateBegin,
                'type'   => PDO::PARAM_STR
            ),
            1 => array(
                'marker' => 'emprDateEnd',
                'value'  => $emprDateEnd,
                'type'   => PDO::PARAM_STR
            ),
            2 => array(
                'marker' => 'FKArticle',
                'value'  => $FKArticle,
                'type'   => PDO::PARAM_INT
            ),
            3 => array(
                'marker' => 'FKUser',
                'value'  => $FKUser,
                'type'   => PDO::PARAM_INT
            ),
        );

        $req = $this->queryPrepareExecute($query, $binds);

        $this->unsetData($req);
    }
    public function getAllArticlesAndInfos(){
        $req = $this->querySimpleExecute('SELECT * FROM t_article
        INNER JOIN t_user ON t_article.fkUserArticle = t_user.idUser');
        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result;
    }
    public function getAllLoansAndInfos(){
        $req = $this->querySimpleExecute('SELECT * FROM t_loan
        INNER JOIN t_article ON t_loan.fkArticle = t_article.idArticle');
        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result;
    }
    public function getArticle($id){
        $query = 'SELECT * FROM t_article
        INNER JOIN t_user ON t_article.fkUserArticle = t_user.idUser
        WHERE idArticle = :id';

        $binds = array(
            0 => array(
                'marker' => 'id',
                'value'  => $id,
                'type'   => PDO::PARAM_INT
            )
        );

        $req = $this->queryPrepareExecute($query, $binds);
        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result[0];
    }
    public function getUser($idUser){
        $query = 'SELECT * FROM t_user WHERE idUser = :idUser';

        $binds = array(
            0 => array(
                'marker' => 'idUser',
                'value'  => $idUser,
                'type'   => PDO::PARAM_INT
            )
        );

        $req = $this->queryPrepareExecute($query, $binds);
        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result[0];
    }

    public function suppArticle($idArticle){
        $query = 'DELETE FROM `t_article` WHERE `idArticle` = :idArticle';

        $binds = array(
            0 => array(
                'marker' => 'idArticle',
                'value'  => $idArticle,
                'type'   => PDO::PARAM_INT
            )
        );

        $req = $this->queryPrepareExecute($query, $binds);
        $result = $this->formatData($req);

        $this->unsetData($req);


    }
    public function suppLoan($FKArticle){
        $query = 'DELETE FROM `t_loan` WHERE `fkArticle` = :FKArticle';

        $binds = array(
            0 => array(
                'marker' => 'FKArticle',
                'value'  => $FKArticle,
                'type'   => PDO::PARAM_INT
            )
        );

        $req = $this->queryPrepareExecute($query, $binds);
        $result = $this->formatData($req);

        $this->unsetData($req);


    }
    public function userModifArticle($id,$newname,$newstatus,$newimage,$newdescription){
        $query = "UPDATE t_article SET artName = :newname, artStatus = :newstatus, artPicture = :newimage, artDescription = :newdescription WHERE idArticle = :id";

        $binds = array(
            0 => array(
                'marker' => 'id',
                'value'  => $id,
                'type'   => PDO::PARAM_INT
            ),
            1 => array(
                'marker' => 'newname',
                'value'  => $newname,
                'type'   => PDO::PARAM_STR
            ),
            2 => array(
                'marker' => 'newstatus',
                'value'  => $newstatus,
                'type'   => PDO::PARAM_INT
            ),
            3 => array(
                'marker' => 'newimage',
                'value'  => $newimage,
                'type'   => PDO::PARAM_STR
            ),
            4 => array(
                'marker' => 'newdescription',
                'value'  => $newdescription,
                'type'   => PDO::PARAM_STR
            ),
        );
            
        $req = $this->queryPrepareExecute($query,$binds);

        $this->unsetData($req);
    }

    public function searchlocal($barrRecherche){
        $req = $this->querySimpleExecute('SELECT idArticle FROM t_article
        INNER JOIN t_user ON t_article.fkUserArticle = t_user.idUser
        WHERE useLocal LIKE "%'.$barrRecherche.'%"');

        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result;
    }
    public function UpdateNbLoanUser($id,$NbLoan){
        $query = "UPDATE t_user SET useNbLoan = :NbLoan WHERE idUser = :id";

        $binds = array(
            0 => array(
                'marker' => 'id',
                'value'  => $id,
                'type'   => PDO::PARAM_INT
            ),
            1 => array(
                'marker' => 'NbLoan',
                'value'  => $NbLoan,
                'type'   => PDO::PARAM_INT
            ),
        );
            
        $req = $this->queryPrepareExecute($query,$binds);

        $this->unsetData($req);
    }
    public function UpdateStatusArticle($id,$artstatus){
        $query = "UPDATE t_article SET artStatus = :artstatus WHERE idArticle = :id";

        $binds = array(
            0 => array(
                'marker' => 'id',
                'value'  => $id,
                'type'   => PDO::PARAM_INT
            ),
            1 => array(
                'marker' => 'artstatus',
                'value'  => $artstatus,
                'type'   => PDO::PARAM_INT
            ),
        );
            
        $req = $this->queryPrepareExecute($query,$binds);

        $this->unsetData($req);
    }
    public function UpdateNbArticleUser($id,$NbArticles){
        $query = "UPDATE t_user SET useNbArticles = :NbArticles WHERE idUser = :id";

        $binds = array(
            0 => array(
                'marker' => 'id',
                'value'  => $id,
                'type'   => PDO::PARAM_INT
            ),
            1 => array(
                'marker' => 'NbArticles',
                'value'  => $NbArticles,
                'type'   => PDO::PARAM_INT
            ),
        );
            
        $req = $this->queryPrepareExecute($query,$binds);

        $this->unsetData($req);
    }
    

} 

?>