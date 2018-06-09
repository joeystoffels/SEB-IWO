<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

class WebshopController extends Controller {

    public function index() {
        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";

        $this->registry->template->show('landingspage');
    }
}
