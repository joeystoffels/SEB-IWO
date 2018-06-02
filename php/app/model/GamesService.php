<?php

class GamesService {

    private $dbcontroller;

    /** @var PDO */
    protected $conn;

    public function __construct() {
        $this->dbcontroller = new DBConnectionController();
    }

    private function before() {
        $this->conn = $this->dbcontroller->getConnection();
    }

    public function selectAllGames() {
        $query = "SELECT * FROM Games;";
        $this->conn->query($query);
    }

    private function after() {
        $this->dbcontroller->closeConnection();
        $this->dbcontroller = null;
    }
}