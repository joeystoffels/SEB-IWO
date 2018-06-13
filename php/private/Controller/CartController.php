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
            <div class="product-info" >
                <h3><a href = "#" >$item</a></h3>
            </div>
            <div class="product-thumb">
                <a href = "#" >
                    <!--<img alt = "Secondary image of the article" class="product-back-img" src = "http://via.placeholder.com/480x480/666666/898989">-->
                </a>
            </div>
            <div class="product-action">
                <a class="button add-to-cart" href = "#"> Add to Cart </a> 
                <a class="button" href = "#"><span class="lnr lnr-heart"></span><span class="button-text" > Add to Wishlist </span></a>
                <a class="button" href = "#"><span class="lnr lnr-magnifier" ></span><span class="button-text"> Go to Article </span></a>
            </div>
        </article>
CART;
        }

        $this->registry->template->cart = $cartHtml;
        $this->registry->template->show('cart');
    }
}
