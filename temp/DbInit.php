<?php
//$servername = "localhost";
//$username = "root";
////$password = "123456";
//
//// TODO replace with files
//
//// Create database
//$sqlCreateDb = "CREATE DATABASE GameParadise";
//
//// sql to create table
//$sqlDdl = "CREATE TABLE Games (
//title VARCHAR(25) PRIMARY KEY,
//category VARCHAR(25),
//minage INT(25),
//releasedate DATE,
//price INT(10),
//publisher VARCHAR(25),
//platform VARCHAR(25)
//)";
//
//// sql to insert data
//$sqlDml = "INSERT INTO Games (title, category, minage, releasedate, price, publisher, platform)
//VALUES ('Battlefield 1', 'Shooter', 18, 01-01-2010, 49.99, 'EA', 'PC')";
//
//// Create DB
//try {
//    $conn = new PDO("mysql:host=$servername", $username);
//    // set the PDO error mode to exception
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $conn->exec("DROP DATABASE IF EXISTS GameParadise");
//    $conn->query($sqlCreateDb);
//    echo "DB created! <br>";
//} catch(PDOException $e) {
//    echo "Connection failed: " . $e->getMessage();
//}
//
//// Connect to DB
//try {
//    $conn = new PDO("mysql:host=$servername;dbname=GameParadise", $username);
//    // set the PDO error mode to exception
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully to DB! <br>";
//} catch(PDOException $e) {
//    echo "Connection failed: " . $e->getMessage();
//}
//
//$conn->query($sqlDdl);
//$conn->query($sqlDml);
//
//echo "Tables created and data inserted! <br>";
//
//$conn = null;
//?>