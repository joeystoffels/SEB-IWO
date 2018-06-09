<?php

namespace Webshop\Core;

class Application
{

    protected $registery;
    protected $controller = 'WebshopController';
    protected $action = 'index';
    protected $params = [];

    public function __construct(){
        // Create the registery
        $this->registery = new \Webshop\Core\Registery();

        // Register the template engine
        $this->registery->template = new \Webshop\Core\Template($this->registery);

        $this->prepareURL();

//        print_r(ABSPATH."/Controller/" . $this->controller . '.php');

        if(file_exists(ABSPATH."/Controller/" . $this->controller . '.php')){
            $classString = "\\Webshop\\Controller\\". $this->controller;
            $this->controller = new $classString($this->registery);
            if(method_exists($this->controller,$this->action)) {
                echo "bestaat";
                call_user_func_array([$this->controller, $this->action], $this->params);
            } else {
                // There is no action in the controller with the right name
//                header('Location: /404.html');
            }
        } else {
            // There is no controller with the correct name
//            header('Location: /404.html');
        }

        var_dump($this);
    }

    protected function prepareURL() {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        if(!empty($request)) {
            $url = explode('/', $request);
            $this->controller = isset($url[0]) ? $url[0] . 'Controller' : 'WebshopController';
            $this->action = isset($url[1]) ? $url[1] : 'index';
            var_dump($url);
            unset($url[0], $url[1]);
            $this->params = !empty($url) ? array_values($url) : [];
        }
    }
}
