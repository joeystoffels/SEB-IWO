<?php

namespace Webshop\Core;

class Application
{
    protected $controller = 'WebshopController';
    protected $action = 'index';
    protected $params = [];

    public function __construct(){
        $this->prepareURL();
        if(file_exists(ABSPATH."controller/" . $this->controller . '.php')){
            $this->controller = new $this->controller;
            if(method_exists($this->controller,$this->action)) {
                call_user_func_array([$this->controller, $this->action], $this->params);
            }
        }
    }

    protected function prepareURL() {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        if(!empty($request)) {
            $url = explode('/', $request);
            //var_dump($url);
            $this->controller = isset($url[0]) ? $url[0].'Controller' : 'WebshopController';
            $this->action = isset($url[3]) ? $url[3] : 'index';
            unset($url[0], $url[3]);
            $this->params = !empty($url) ? array_values($url) : [];
        }
    }
}
