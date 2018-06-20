<?php

namespace Webshop\Core;


class Router
{
    private $registry;

    public function __construct()
    {
        $this->registry = Registry::Instance();

        $request = trim(strtok($_SERVER["REQUEST_URI"], '?'), '/');
        $url = explode('/', $request);
        $this->registry->controller = ucfirst((!empty($url[0])) ? $url[0] . 'Controller' : 'GamesController');
        $this->registry->action = isset($url[1]) ? $url[1] : 'index';
        unset($url[0], $url[1]);
        $this->registry->params = !empty($url) ? array_values($url) : [];
    }

    public function route()
    {
        if (file_exists(ABSPATH . "/Controller/" . $this->registry->controller . '.php')) {
            $classString = "\\Webshop\\Controller\\" . $this->registry->controller;
            $this->registry->controller = new $classString( );
            if (method_exists($this->registry->controller, $this->registry->action)) {
                call_user_func_array([$this->registry->controller, $this->registry->action], $this->registry->params);
            } else {
                // There is no action in the controller with the right name
                $this->loadErrorPage(404, "Can't find the correct path");
            }
        } else {
            // There is no controller with the correct name
            $this->loadErrorPage(404, "Can't find the correct path");
        }
    }

    private function loadErrorPage($errorNumber, $errorMessage)
    {
        $error = new \Webshop\Controller\ErrorController($this->registry);
        $error->error($errorNumber, $errorMessage);
    }
}
