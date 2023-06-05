<?php
/*
    ETML
    Auteur : Anthony Pfister
    Date 12.05.2023
    Description : Crée une connexion à db_gestionpretvoisins, et renvoie des données de la db. Toutes les méthodes qui communique par réquète SQL avec la base de données 
*/
/// incruste la page de configuration des information pour la base données 
include 'config.php';

class Database {
    // Variable de classe.
    private $connector;

    /**
     * Crée la connexion à la db.
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
     * Fait une requête simple.
     * @param $query-> réquète SQL
     * @return -> retourne le résultat de la requête SQL
     */
    private function querySimpleExecute($query){
        return $req = $this->connector->query($query);
    }

    /**
     * Requête à la db en utilisant les requêtes préparées
     * @param $query-> réquète SQL
     * @param $binds-> tableau des valeur qui incrémente les variables
     * @return -> retourne le résultat de la requête SQL
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
     * Retoune les données de la requête sont forme de tableau associatif.
     * @param $req-> données de la requête
     * @return -> tableau associatif
     */
    private function formatData($req){
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vide le jeu d'enregistrement
     * @param $req-> données de la requête
     */
    private function unsetData($req){
        $req->closeCursor();
    }

    
    /**
     * Retourne les données d'un utilisateur en fonction de son nom.
     * @param $userName-> nom de l'utilisateur
     * @return -> toutes les données de l'utilisateur
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

    /**
     * Retourne l'identifiant de l'utilisateur avec selon de la session actuelle
     * @param $idUser-> identifiant de l'utilisateur
     * @return -> identifiant de la base de données 
     */
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

    /**
     * créer l'article dans la base de données
     * @param $artname->  nom de l'article
     * @param $artstatus->  status de l'article
     * @param $artimage->  nom de l'image de l'article
     * @param $artdescription->  description de l'article
     * @param $artuser-> l'identifier de l'utilisateur qui l'a créé 
     */
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

    /**
     * créer l'emprunt de l'article dans la base de données
     * @param $emprDateBegin->  Date de début de l'emprunt
     * @param $emprDateEnd->  Date de fin de l'emprunt
     * @param $FKArticle->  identifiant de l'article qui est emprunter
     * @param $FKUser->  identifiant de l'utilisateur qui fait cette emprunt
     */
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

    /**
     * retourne toutes les données de tous les articles dans la base de données avec les données de l'utilisateur qui la créé.
     * @return -> sous forme de tableau,
     *            toutes les données de tous les articles de la base de données avec les données de l'utilisateur qui la créé.
     */
    public function getAllArticlesAndInfos(){
        $req = $this->querySimpleExecute('SELECT * FROM t_article
        INNER JOIN t_user ON t_article.fkUserArticle = t_user.idUser');
        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result;
    }

    /**
     * Retourne toutes les données de tous les emprunts de la base de données avec les données de l'article qui est lier
     * @return -> sous forme de tableau,
     *            toutes les données de tous les emprunts de la base de données avec les données de l'article qui est lier
     */
    public function getAllLoansAndInfos(){
        $req = $this->querySimpleExecute('SELECT * FROM t_loan
        INNER JOIN t_article ON t_loan.fkArticle = t_article.idArticle');
        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result;
    }

    /**
     * Retourne toutes les données de l'article par rapport à l'identifiant de l'article donné.
     * @param $id -> l'identifiant de l'article
     * @return -> toutes les données de l'article sous forme de tableau
     */
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

    /**
     * Retourne toutes les données de l'utilisateur par rapport à l'identifiant de l'utilisateur donné.
     * @param $idUser -> l'identifiant de l'utilisateur
     * @return -> toutes les données de l'utilisateur sous forme de tableau
     */
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

    /**
     * Supprime l'article de la base de données par rapport à l'identifiant de l'article donné.
     * @param $idArticle -> l'identifant de l'article
     */
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

    /**
     * Supprime l'emprunt d'un article en fonction de l'identifant de l'article donné.
     * @param $FKArticle -> l'identifant de l'article
     */
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

    /**
     * Modifier toutes les données de l'article en fonction de l'identifiant de l'article donné
     * @param $id->  l'identifiant de l'article 
     * @param $newname->  Nouveau nom de l'article 
     * @param $newstatus->  Nouveau status de l'article
     * @param $newimage->  Nouveau nom pour l'image de l'article
     * @param $newdescription-> Nouvelle description pour l'article
     */
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

    /**
     * Retourne tous les article de la base de données par rapport à la localisation de l'utilisateur qui l'a créé.
     * @param $barrRecherche -> nom du lieu rechercher.
     * @return -> tous les identifiant des articles trouvé.
     */
    public function searchlocal($barrRecherche){
        $req = $this->querySimpleExecute('SELECT idArticle FROM t_article
        INNER JOIN t_user ON t_article.fkUserArticle = t_user.idUser
        WHERE useLocal LIKE "%'.$barrRecherche.'%"');

        $result = $this->formatData($req);

        $this->unsetData($req);

        return $result;
    }

    /**
     * Modifie le nombre d'emprunt actuel dans les données de l'utilisateur par rapport à son identifiant donné.
     * @param $id -> l'identifiant de l'utilisateur.
     * @param $NbLoan -> le nombre d'emprunt qu'il faut actualiser dans la base de données.
     */
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

    /**
     * Modifie le status de l'article en fonction de l'identifiant donné.
     * @param $id -> l'identifiant de l'article
     * @param $artstatus -> le nouveau status à modifier dans la base de données.
     */
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

    /**
     * Modifie le nombre d'article créer dans les données de l'utilisateur en fonction de l'identifiant donné
     * @param $id -> l'identifiant de l'utilisateur.
     * @param $NbArticles -> le nombre d'article créer par l'utilisateur à actualiser.
     */
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