<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

class AboutUsController extends Controller
{

    /**
     *
     */
    function index()
    {
        $this->registry->template->title = "Over ons";
        $this->registry->template->description = "Informatie over de eigenaren van deze denkbeeldige webshop";
        $this->registry->template->cartItems = Util::getNrCartItems();
        $this->registry->template->show('about');
    }
}
