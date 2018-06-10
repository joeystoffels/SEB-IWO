<?php

namespace Webshop\Model;


use Webshop\Core\Model;

class Developer extends Model
{
    private $name;

    public function __construct()
    {
        parent::__construct('developers');
    }
    // Magic setter. Silently ignore invalid fields
    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }
}
