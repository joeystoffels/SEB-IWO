<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

class WebshopController extends Controller {

    public function index() {
        $this->registry->template->title = "Nick";
        $this->registry->template->fout = "Fout";

        $this->registry->template->show('404');
    }

    public function about() {
        $this->registry->template->title = "Nick";
        $this->registry->template->fout = "Fout";

        $this->registry->template->show('404');
    }
}
