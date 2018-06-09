<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 10:03
 */

namespace Webshop\Controller;


use Webshop\Core\Controller;

class CartController extends Controller
{

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";

        $this->registry->template->show('cart');
    }
}
