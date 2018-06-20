<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

/**
 * Controller for the shopping cart
 *
 * Class CartController
 * @package Webshop\Controller
 */
class CartController extends Controller
{
    /**
     * CartController constructor.
     */
    function __construct()
    {
        // Call parent constructor
        parent::__construct();

        $this->registry->template->title = "Winkelwagen";
        $this->registry->template->description = "De inhoud van de winkelwagen.";
    }

    /**
     * Index and fallback function for the CartController
     */
    function index()
    {
        // If the cart is empty, show the empty cart page
        if (empty($_SESSION['cart'])) {
            $this->registry->template->show('cart-empty');
            die();
        }

        $cartItemsHtml = '';
        $game = new \Webshop\Model\Game();

        $resultGames = [];
        $subtotaal = 0.0;
        $verzendkosten = 1.98;

        // Load the games from the database
        foreach ($_SESSION['cart'] as $gameId) {
            if ($game->getOne("id", $gameId)) {
                $resultGames[] = $game->getOne("id", $gameId);
            }
        }

        // Create the html for eacht game
        foreach ($resultGames as $game) {

            if (file_exists("images/games/" . $game->imageBackground)) {
                $gameBackgroundImage = $game->imageBackground;
            } else {
                $gameBackgroundImage = "pc/General_background.jpg";
            }

            $subtotaal += $game->price;
            $cartItemsHtml .= <<< CARTITEMS
            <article style="background: url(/images/games/$gameBackgroundImage) center center no-repeat;">
                <a href="/products/game/$game->id" >
                    <img alt = "Primary image of the article" class="product-front-img" src = "/images/games/$game->image">
                </a>  
                
                <h1><a href = "/products/game/$game->id" >$game->title</a></h1>
                <strong>Prijs: € $game->price</strong>
                <a class="button remove-from-cart" href = "/cart/remove/$game->id">
                    <span class="lnr lnr-trash"></span>
                </a>       
            </article>
CARTITEMS;

        }

        $totalPrice = $subtotaal + $verzendkosten; // Default verzendkosten
        $this->registry->template->verzendkosten = $verzendkosten;
        $this->registry->template->subTotal = $subtotaal;
        $this->registry->template->totalPrice = $totalPrice;
        $this->registry->template->cartItemsHtml = $cartItemsHtml;
        $this->registry->template->show('cart');
    }

    /**
     * Add an item to the shoppingcart
     */
    function add()
    {
        $gameId = $this->registry->params[0];
        if (!is_numeric($gameId) || (!empty($_SESSION['cart']) && in_array($gameId, $_SESSION['cart']))) {
            echo "gameId is niet numeric, geldig of winkelwagen bevat al deze game!";
        } else {
            $_SESSION['cart'][] = $gameId;
        }
        header("Location: /cart");
    }

    /**
     * Remove an item from the shoppingcart
     */
    function remove()
    {
        $gameId = $this->registry->params[0];

        if (isset($gameId, $_SESSION['cart'])) {
            Util::deleteElement($gameId, $_SESSION['cart']);
        }
        header("Location: /cart");
    }
}
