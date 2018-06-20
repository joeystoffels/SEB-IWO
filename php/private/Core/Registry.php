<?php

namespace Webshop\Core;


class Registry
{
    /**
     * @var array Internal storage array
     */
    private $vars = array();

    /**
     * @return null|Registry Get instance of Registery ( Singleton Pattern)
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Registry();
        }
        return $inst;
    }

    /**
     * Magic Getter
     * @param string $key Name of the private variable to get
     * @return mixed
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }

    /**
     * Magic setter
     * @param string $key Name of the private variable to set
     * @param string $value Value of the private variable to set
     */
    public function __set($key, $value)
    {
        $this->vars[$key] = $value;
    }
}
