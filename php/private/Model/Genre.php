<?php

namespace Webshop\Model;


use Webshop\Core\Model;

/**
 * A object representation of the Database table Genre
 * Class Genre
 * @package Webshop\Model
 */

class Genre extends Model
{
    /**
     * @var string Name
     */
    private $name;

    /**
     * Genre constructor.
     */
    public function __construct()
    {
        parent::__construct('genre');
    }

    /**
     * Magic getter. Silently ignore invalid fields
     * @param string $key Name of the private variable to get
     * @return mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }

    /**
     * Magic setter
     * @param string $key Name of the private variable to set
     * @param string $value Value of the private variable to set
     */
    public function __set($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
}
