<?php

namespace Webshop\Model;


use Webshop\Core\Model;

class Genre extends Model
{
    private $name;

    public function __construct()
    {
        parent::__construct('genre');
    }
    // Magic setter. Silently ignore invalid fields
    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }
}
