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
        $cartItemsHtml = '';
        $game = new \Webshop\Model\Game();

        $resultGames = array();

        $subtotaal = 0.0;

        if (empty($_SESSION['cart'])) {
            echo "Session cart is leeg!";
        } else {
            foreach ($_SESSION['cart'] as $gameId) {
                if ($game->getOne("id", $gameId)) {
                    $resultGames[] = $game->getOne("id", $gameId);
                }
            }



            foreach ($resultGames as $game) {
                $subtotaal += $game->price;
                $cartItemsHtml .= <<< CARTITEMS
            <article>
                <div class="product-info-cart-border" style="background: linear-gradient(rgba(255,255,255,.8), rgba(255,255,255,.8)), url(/images/games/$game->imageBackground) center center no-repeat; background-size: cover;">
                    <div class="product-info-cart" >
                        <h1><a href = "#" >$game->title</a></h1>
                        <br><p><strong>Prijs: € $game->price</strong></p><br>
                        <a class="button remove-from-cart" href = "/cart/remove/$game->id"> Verwijderen </a> 
                    </div>
                    <div class="product-thumb-cart">
                        <a href = "#" >
                            <img alt = "Primary image of the article" class="product-front-img" src = "/images/games/$game->image">
                        </a>                
                    </div>
                </div>
            </article>
CARTITEMS;
            }
        }

        $totalPrice = $subtotaal + 1.98; // Default verzendkosten

        $cartHtml = <<< CART
        <div class="main-container container">
            <aside>
                <h1>Overzicht</h1>
                <br>
                <p>Subtotaal: € $subtotaal</p>
                <br>
                <p>Verzendkosten: € 1,98</p>
                <br>
                <p><strong>Totaal: € $totalPrice</strong></p>
                <br><br>
                <a href="#"><p><strong>Afrekenen</strong></p></a>
            </aside>
            <main>
                <h1>Winkelwagen</h1>
                <br>
                <section>
                    $cartItemsHtml
                </section>
            </main>
        </div>
CART;

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
