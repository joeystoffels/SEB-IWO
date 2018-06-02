<?php
class webshopController {

    //http://localhost/webshop/php/public/index
    public function index() { //$id='',$name=''
        //echo 'I am in ' . __CLASS__ . ' method ' . __METHOD__;

        require('../app/view/home.php');
    }

    //http://localhost/webshop/php/public/about
    public function about() {
        //echo 'I am in ' . __CLASS__ . ' method ' . __METHOD__;

        require('../app/view/about.php');
    }
}