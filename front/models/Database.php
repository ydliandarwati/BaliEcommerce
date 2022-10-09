<?php
// General methods used in other models like find, findall, as well as connection to BD via contructor

namespace Models;

class Database {

    protected $bdd;

    // connection to DB
    public function __construct() {
        $this->bdd = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    }
    
    
    protected function getOneById($req) {
        $query = $this->bdd->prepare($req, $params = []);
        $query->execute($params);
        $data = $query->fetch(\PDO::FETCH_ASSOC);
        return $data;
    }
    
    protected function findAll($req, $params = []) : array {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data;
    }
    

}