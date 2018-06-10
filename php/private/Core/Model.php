<?php

namespace Webshop\Core;

use PDO;


Abstract class Model
{


    protected $tableName;
    private $pageAmountLimit = 100;

    /**
     * Model constructor.
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    // Magic setter. Silently ignore invalid fields

    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

    // Magic getter

    public function __set($key, $value)
    {
        if (isset($this->$key)) {
            $this->$key = $value;
        }
    }

    public function getAll(): array
    {
        $result = Database::getConnection()->query('SELECT * FROM ' . $this->tableName);
        $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($this));
        return $result->fetchAll();
    }

    public function getPage($currentPage, $perPage): array
    {
        ($perPage > $this->pageAmountLimit) ? $perPage = $this->pageAmountLimit :

        $query = "SELECT * FROM $this->tableName LIMIT :limit OFFSET :offset";
        $queryResult = Database::getConnection()->prepare($query);
        $queryResult->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $queryResult->bindValue(':offset', (($currentPage -1) * $perPage), PDO::PARAM_INT);
        $queryResult->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($this));
        $queryResult->execute();

        $count = "SELECT count(*) FROM $this->tableName";
        $countResult = Database::getConnection()->prepare($count);
        $countResult->execute();

        $return["total"] = $countResult->fetchColumn();
        $return["per_page"] = $perPage;
        $return["current_page"] = $currentPage;
        $return["last_page"] = intval(ceil($return["total"] / $perPage));
        $return["from"] = $currentPage * $perPage;
        $return["to"] = $return["from"] + $perPage;
        $return['data'] = $queryResult->fetchAll();
        return $return;
    }


}
