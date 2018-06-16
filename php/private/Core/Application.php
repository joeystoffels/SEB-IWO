<?php


namespace Webshop\Core;

class Application
{
    private $registry;

    public function __construct()
    {
        // Absolute path for the environment.
        if (!defined('ABSPATH')) {
            define('ABSPATH', dirname(dirname(__FILE__)));
        }

        // Create the registery
        $this->registry = new \Webshop\Core\Registery();

        // Register the template engine
        $this->registry->template = new \Webshop\Core\Template($this->registry);

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

        // Add user account information to the registery
        $this->registry->userAccount = new UserAccount();

        $router = new \Webshop\Core\Router($this->registry);
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
}
