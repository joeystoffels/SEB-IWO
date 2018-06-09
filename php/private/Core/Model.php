<?php

namespace Webshop\Core;


abstract class Model
{
    private static $connection;

    public static function getConnection()
    {
        if (self::$connection === null) {
            self::openConnection();
        }
        return self::$connection;
    }

    private static function openConnection()
    {
        try {
            self::$connection = new \PDO("mysql:host=" . DB_HOST . ";dbname=". DB_NAME, DB_USER, DB_PASSWORD);
            // set the PDO error mode to exception
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            echo "PDO connected successfully! <br>";
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
