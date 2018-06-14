<?php

namespace Webshop\Model;

use Webshop\Core\Model;

class User extends Model
{
    private $id;
    private $emailadres;
    private $password;
    private $salt;
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
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

}
