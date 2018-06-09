<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 10:46
 */

namespace Webshop\Controller;


use Webshop\Core\Controller;

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
        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";
        $this->registry->template->errorNumber = $errorNumber;
        $this->registry->template->errorMessage = $errorMessage;

        $this->registry->template->show('error');
    }
}
