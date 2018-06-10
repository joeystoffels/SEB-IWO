<?php

namespace Webshop\Model;


use Webshop\Core\Model;

class Platform extends Model
{
    private $name;
    private $value;

    public function __construct()
    {
        parent::__construct('platforms');
    }
    // Magic setter. Silently ignore invalid fields
    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }
}
