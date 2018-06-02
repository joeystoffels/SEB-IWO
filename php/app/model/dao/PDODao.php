<?php

class PDODao {

    /** @var PDO */
    private $conn;

    public function getConnection() {
        if($this->conn === null) {
            $this->openConnection();
        }
        return $this->conn;
    }
    private function openConnection() {
        $servername = "localhost";
        $username = "root";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=test", $username);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->
            $this->conn = $conn;
            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    protected function query($query) {
        if($this->conn === null) {
            $this->openConnection();
        }

        $result = $this->conn->prepare($query);
        $result->execute();

        $this->closeConnection();
        return $result;
    }

    private function closeConnection() {
        $this->conn = null;
    }
}