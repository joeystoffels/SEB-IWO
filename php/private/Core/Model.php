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

    private function createWhereStatementKeys(array $whereFilters): string
    {
        $whereStatement = '';
        foreach ($whereFilters as $key => $values) {
            foreach ($values as $value) {
                $value = Util::cleanString($value);
                $whereStatement .= "$key = :$value OR " ;
            }
            $whereStatement = substr($whereStatement, 0, -3);
            $whereStatement .= " AND " ;
        }
        return substr($whereStatement, 0, -4);

}

    public function getAll($whereFilters = null): array
    {
//        var_dump($whereFilters);
        if (is_array($whereFilters) && isset($whereFilters)) {
            $whereStatement = $this->createWhereStatementKeys($whereFilters);
            $query = "SELECT * FROM $this->tableName WHERE ( $whereStatement )";
        } else {
            $query = "SELECT * FROM $this->tableName";
        }

//        var_dump($query);

        $result = Database::getConnection()->prepare($query);
        if (is_array($whereFilters)) {
            foreach ($whereFilters as $key => $values) {
                foreach ($values as $value) {
                    $needle = Util::cleanString($value);
                    $result->bindValue($needle, $value, PDO::PARAM_STR);
                }
            }
        }
        $result->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($this));
        $result->execute();
        return $result->fetchAll();
    }

    public function getOne($key, $value)
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE $key = :value";
        $stmt = Database::getConnection()->prepare($query);
        if(is_int($value)) {
            $stmt->bindValue(':value', $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':value', $value, PDO::PARAM_STR);
        }
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($this));
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getPage($currentPage, $perPage, $whereFilters = null): array
    {
        ($perPage > $this->pageAmountLimit) ? $perPage = $this->pageAmountLimit : '';
        if (is_array($whereFilters)) {
            $whereStatement = $this->createWhereStatementKeys($whereFilters);
            $query = "SELECT * FROM $this->tableName WHERE ( $whereStatement ) LIMIT :limit OFFSET :offset";
        } else {
            $query = "SELECT * FROM $this->tableName LIMIT :limit OFFSET :offset";
        }

        $queryResult = Database::getConnection()->prepare($query);
        $queryResult->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $queryResult->bindValue(':offset', (($currentPage - 1) * $perPage), PDO::PARAM_INT);
        if (is_array($whereFilters)) {
            foreach ($whereFilters as $key => $values) {
                foreach ($values as $value) {
                    $needle = Util::cleanString($value);
                    $queryResult->bindValue($needle, $value, PDO::PARAM_STR);
                }
            }
        }
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
