<?php

namespace Webshop\Core;

/**
 * Base class for every controller
 * Class Controller
 * @package Webshop\Core
 * @abstract
 */
Abstract Class Controller
{
    /**
     * @var null|Registry Registery object to hold data
     */
    protected $registry;

    /**
     * Core controller constructor.
     */
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
