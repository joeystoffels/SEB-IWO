<?php

namespace Webshop\Controller;


use Webshop\Core\Controller;

/**
 * Controller for all errors
 * Class ErrorController
 * @package Webshop\Controller
 */
class ErrorController extends Controller
{

    /**
     * ErrorController constructor.
     */
    function __construct()
    {
        // Call parent constructor
        parent::__construct();

        // Set title and description of the page
        $this->registry->template->title = "Error..";
        $this->registry->template->description = "If you're looking at this ... than it's nog good.";
    }

    /**
     * Index and fallback function for the ErrorController
     */
    function index()
    {
        $this->error(404, "Default error");
    }

    /**
     * Function that shows an error pageclear
     *
     * @param int $errorNumber Error number to show for example 404
     * @param string $errorMessage Error message to show example "not found"
     */
    function error(int $errorNumber, string $errorMessage)
    {
        // Set header number
        http_response_code($errorNumber);

        $this->registry->template->errorNumber = $errorNumber;
        $this->registry->template->errorMessage = $errorMessage;
        $this->registry->template->show('error');
    }
}
