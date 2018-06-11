<?php

namespace Webshop\Model;


use Webshop\Core\Model;

class Playertype extends Model
{
    private $name;

    public function __construct()
    {
        parent::__construct('playertype');
    }
    // Magic setter. Silently ignore invalid fields
    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }
}
