<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 07:52
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
        // TODO: Implement index() method.
    }

    function error_404(){

        // Set template variabelen
        $this->registry->template->title = "Nick";
        $this->registry->template->fout = "Fout";

        $this->registry->template->show('404');
    }
}
