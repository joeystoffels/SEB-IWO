<?php
$servername = "localhost";
$username = "root";
//$password = "123456";

try {
    $conn = new PDO("mysql:host=$servername;dbname=test", $username);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// TODO replace with files

// Create database
$sqlCreateDb = "CREATE DATABASE myDB";

// sql to create table
$sqlDdl = "CREATE TABLE TestTable (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

// sql to insert data
$sqlDml = "INSERT INTO TestTable (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";

if ($conn->exec('use database test') === TRUE) {
    echo "Connected to database 'test'";
} else {
    echo $conn->query($sqlCreateDb);
}

$conn = null;
?>
