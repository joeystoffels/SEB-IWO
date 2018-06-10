<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 10/06/2018
 * Time: 13:56
 */

namespace Webshop\Core;


class Router
{
    private $registery;

    public function __construct(Registery $registery)
    {
        $this->registery = $registery;

        $request = trim(strtok($_SERVER["REQUEST_URI"], '?'), '/');
        $url = explode('/', $request);
        $this->registery->controller = ucfirst((!empty($url[0])) ? $url[0] . 'Controller' : 'ProductsController');
        $this->registery->action = isset($url[1]) ? $url[1] : 'index';
        unset($url[0], $url[1]);
        $this->registery->params = !empty($url) ? array_values($url) : [];
    }

    public function route()
    {
        if (file_exists(ABSPATH . "/Controller/" . $this->registery->controller . '.php')) {
            $classString = "\\Webshop\\Controller\\" . $this->registery->controller;
            $this->registery->controller = new $classString($this->registery);
            if (method_exists($this->registery->controller, $this->registery->action)) {
                call_user_func_array([$this->registery->controller, $this->registery->action], $this->registery->params);
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
        $error = new \Webshop\Controller\ErrorController($this->registery);
        $error->error($errorNumber, $errorMessage);
    }
}
