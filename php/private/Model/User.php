<?php

namespace Webshop\Model;

use Webshop\Core\Model;
use Webshop\Core\Database;
use PDO;

class User extends Model
{
    private $id;
    public $emailadres;
    private $password;
    private $firstName;
    private $lastName;
    private $dayOfBirth;
    private $sex;

    public function __construct()
    {
        parent::__construct('users');
    }

    // Magic setter. Silently ignore invalid fields
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }

    // Magic getter
    public function __set($key, $value)
    {
        if (property_exists($this, $key)){
            $this->$key = $value;
        }
    }



    public function save(): void
    {
        $options = [
            'cost' => 11,
        ];
        var_dump($this);
        $password =  password_hash($this->password, PASSWORD_BCRYPT, $options);
        $query = "INSERT INTO $this->tableName (emailadres, password, firstName, lastName, dayOfBirth, sex ) VALUES ( :emailadres, :password, :firstName, :lastName, :dayOfBirth, :sex)";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bindValue(':emailadres', $this->emailadres, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':firstName', $this->firstName, PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $this->lastName, PDO::PARAM_STR);
        $stmt->bindValue(':dayOfBirth', date("Y-m-d H:i:s", strtotime($this->dayOfBirth)), PDO::PARAM_STR);
        $stmt->bindValue(':sex', $this->sex, PDO::PARAM_STR);
        $count = $stmt->execute();
        var_dump($count);
    }

}
