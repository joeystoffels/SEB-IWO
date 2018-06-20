<?php

namespace Webshop\Core;

Abstract Class Controller
{
    /*
     * @registry object
     */
    protected $registry;

    function __construct()
    {
        $this->registry = Registry::Instance();
    }

    /**
     * @all controllers must contain an index method
     */
    abstract function index();
}

?>
