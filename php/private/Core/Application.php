<?php


namespace Webshop\Core;

class Application
{
    private $registery;

    public function __construct()
    {
        // Absolute path for the environment.
        if (!defined('ABSPATH')) {
            define('ABSPATH', dirname(dirname(__FILE__)));
        }

        // Create the registery
        $this->registery = new \Webshop\Core\Registery();

        // Register the template engine
        $this->registery->template = new \Webshop\Core\Template($this->registery);


    }

    public function init()
    {
        $this->loadConfiguration();

        if (DEBUG) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }

        $router = new \Webshop\Core\Router($this->registery);
        $router->route();
    }

    private function loadConfiguration()
    {
        $fileName = ABSPATH . "/Config/config-prd.php";
        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
            $fileName = ABSPATH . "/Config/config-dev.php";
        }

        if (file_exists($fileName)) {
            require $fileName;
        } else {
            die("Configuration file not found");
        }
    }

    public function classLoader()
    {

    }


}
