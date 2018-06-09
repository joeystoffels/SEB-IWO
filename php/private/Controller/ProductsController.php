<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

class ProductsController extends Controller {

    public function index() {

        var_dump($_GET);

        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";

        $this->registry->template->show('landingspage');
    }
}
