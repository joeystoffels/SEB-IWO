<?php

namespace Webshop\Helper;

class Database
{

  /** @var PDO */
  private static $conn;

  public static function getConnection()
  {
    if (self::$conn === null) {
      self::openConnection();
    }
    return self::$conn;
  }

  private static function openConnection()
  {

    try {
      self::$conn = new \PDO("mysql:host=" . DB_HOST . ";dbname=". DB_NAME, DB_USER, DB_PASSWORD);
      // set the PDO error mode to exception
      self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

      echo "PDO connected successfully! <br>";
    } catch (\PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  protected static function query($query)
  {
    if (self::$conn === null) {
      self::openConnection();
    }

    $result = self::$conn->prepare($query);
    $result->execute();

    //self::closeConnection();
    return $result;
  }

  private static function closeConnection()
  {
    self::$conn = null;
  }
}
