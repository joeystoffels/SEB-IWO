<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 10:04
 */

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

class AboutusController extends Controller
{

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";
        $this->registry->template->cartItems = Util::getNrCartItems();
        $this->registry->template->show('about');
    }
}
