<?php

namespace Webshop\Core;

class Application
{
    protected $registery;

    public function __construct(){
        // Create the registery
        $this->registery = new \Webshop\Core\Registery();

        // Register the template engine
        $this->registery->template = new \Webshop\Core\Template($this->registery);

        $this->prepareURL();

        if(DEBUG){
            echo"<!--";
            var_dump($this);
            echo"-->";
        }

        if(file_exists(ABSPATH."/Controller/" . $this->registery->controller . '.php')){
            $classString = "\\Webshop\\Controller\\". $this->registery->controller;
            $this->registery->controller = new $classString($this->registery);
            if(method_exists($this->registery->controller,$this->registery->action)) {
                call_user_func_array([$this->registery->controller, $this->registery->action], $this->registery->params);
            } else {
                // There is no action in the controller with the right name
                $error = new \Webshop\Controller\ErrorController($this->registery);
            $error->error(404, "Can't find the correct path");
            }
        } else {
            // There is no controller with the correct name
//            header('Location: /404.html');
            $error = new \Webshop\Controller\ErrorController($this->registery);
            $error->error(404, "Can't find the correct path");
        }
    }

    protected function prepareURL() {
        $request = trim(strtok($_SERVER["REQUEST_URI"],'?'), '/');
        $url = explode('/', $request);
        $this->registery->controller = ucfirst((!empty($url[0])) ? $url[0] . 'Controller' : 'ProductsController');
        $this->registery->action = isset($url[1]) ? $url[1] : 'index';
        unset($url[0], $url[1]);
        $this->registery->params = !empty($url) ? array_values($url) : [];
    }
}
