<?php

class DBConnectionController {

    protected $conn;

    public function getConnection() {
        if(self::$conn === null) {
            $this->openConnection();
        }
        return self::$conn;
    }

    private function openConnection() {
        $servername = "localhost";
        $username = "root";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=test", $username);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->
            self::$conn = $conn;
            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function closeConnection() {
        self::$conn = null;
    }
}