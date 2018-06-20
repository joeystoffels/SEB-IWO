<?php

namespace Webshop\Controller;


use Webshop\Core\Controller;
use Webshop\Core\Util;

class ErrorController extends Controller
{

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $this->error(404, "Default error");
    }

    function error(int $errorNumber, string $errorMessage)
    {
        http_response_code($errorNumber);
        $this->registry->template->title = "Error..";
        $this->registry->template->description = "If you're looking at this ... than it's nog good.";
        $this->registry->template->errorNumber = $errorNumber;
        $this->registry->template->errorMessage = $errorMessage;
        $this->registry->template->cartItems = Util::getNrCartItems();
        $this->registry->template->show('error');
    }
}
