<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

class CartController extends Controller
{

    function __construct($registry)
    {
        $this->registry = $registry;
        $this->registry->template->title = "GameParadise - Winkelwagen";
        $this->registry->template->description = "Dit is de text die geindexeerd word door Google";
    }

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $cartList = array("test1", "test2");
        $cartHtml = '';

        foreach ($cartList as $item) {

            $cartHtml .= <<< CART
            <article>
                <p>$item</p>
            </article>
CART;
        }

        $this->registry->template->cart = $cartHtml;
        $this->registry->template->show('cart');
    }
}
