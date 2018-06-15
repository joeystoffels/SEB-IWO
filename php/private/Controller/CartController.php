<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

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
        $cartHtml = '';
        $game = new \Webshop\Model\Game();

        $resultGames = array();

        if (empty($_SESSION['cart'])) {
            echo "Session cart is leeg!";
        } else {
            foreach ($_SESSION['cart'] as $gameId) {
                if ($game->getOne("id", $gameId)) {
                    $resultGames[] = $game->getOne("id", $gameId);
                }
            }
            foreach ($resultGames as $game) {
                $cartHtml .= <<< CART
            <article>
                <div class="product-info" >
                    <h3><a href = "#" >$game->title</a></h3>
                </div>
                <div class="product-thumb">
                    <a href = "#" >
                        <!--<img alt = "Secondary image of the article" class="product-back-img" src = "http://via.placeholder.com/480x480/666666/898989">-->
                    </a>
                </div>
                <div class="product-action">
                    <a class="button add-to-cart" href = "/cart/remove/$game->id"> Remove from Cart </a> 
                    <a class="button" href = "#"><span class="lnr lnr-magnifier" ></span><span class="button-text"> Go to Article </span></a>
                </div>
            </article>
CART;
            }
        }

        $this->registry->template->cart = $cartHtml;
        $this->registry->template->show('cart');
    }

    function add()
    {
        $gameId = $this->registry->params[0];

        // TODO verify requested ID is within ID range
        if (!is_numeric($gameId) || (!empty($_SESSION['cart']) && in_array($gameId, $_SESSION['cart']))) {
            echo "gameId is niet numeric, geldig of winkelwagen bevat al deze game!";
        } else {
            $_SESSION['cart'][] = $gameId;
        }

        $this->index();
    }

    function remove()
    {
        $gameId = $this->registry->params[0];

        if(isset($gameId, $_SESSION['cart'])) {
            Util::deleteElement($gameId, $_SESSION['cart']);
        }

        $this->index();
    }
}
