<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

class AboutUsController extends Controller
{
    /**
     * AboutUsController constructor.
     */
    function __construct()
    {
        // Call parent constructor
        parent::__construct();

        // Set title and description of the page
        $this->registry->template->title = "Over ons";
        $this->registry->template->description = "Informatie over de eigenaren van deze denkbeeldige webshop";
    }

    /**
     * Index and fallback function for the AboutUSController
     */
    function index()
    {
        // Show the template
        $this->registry->template->show('about');
    }
}
