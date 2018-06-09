<?php

namespace Webshop\Core;

use PDO;


Abstract class Model
{


  protected $tableName;
    /**
     * Model constructor.
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    // Magic setter. Silently ignore invalid fields
    public function __set($key, $value)
    {
        if (isset($this->$key)) {
            $this->$key = $value;
        }
    }

    // Magic getter
    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

    public function getAll(){
        $result = Database::getConnection()->query('SELECT * FROM '. $this->tableName);
        $result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, get_class($this));
        var_dump($result->fetch());
    }


}
