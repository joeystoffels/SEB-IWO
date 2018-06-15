<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 10:04
 */

namespace Webshop\Controller;


use Webshop\Core\Controller;

class AboutusController extends Controller
{

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";

        if(isset($_SESSION['cart']))
            $nrCartItems = count($_SESSION['cart']);
        else {
            $nrCartItems = 0;
        }

        $this->registry->template->cartItems = $nrCartItems;

        $this->registry->template->show('about');
    }
}
