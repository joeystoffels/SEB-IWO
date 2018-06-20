<?php

namespace Webshop\Core;

/**
 * Core database class
 * Used for connection to the mysql database
 * Class Database
 * @package Webshop\Core
 * @abstract
 */
abstract class Database
{

    /**
     * Database connection
     * @var $connection Database connection
     */
    private static $connection;

    /**
     * Get the instance of a database connection
     * @return Database
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            self::openConnection();
        }
        return self::$connection;
    }

    /**
     * Open the connection to the database
     */
    private static function openConnection()
    {
        try {
            self::$connection = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            // set the PDO error mode to exception
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
