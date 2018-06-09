<?php

namespace Webshop\Core;


class Model
{
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
}
