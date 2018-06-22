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
    private $amountOfOption = 30;

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
        foreach ($_SESSION['cart'] as $gameFromSession) {
            $gameId = $gameFromSession[0];
            if ($game->getOne("id", $gameId)) {
                $resultGames[] = $game->getOne("id", $gameId);
            }
        }

        // Create the html for eacht game
        $count = 0;
        foreach ($resultGames as $game) {

            if (file_exists("images/games/" . $game->imageBackground)) {
                $gameBackgroundImage = $game->imageBackground;
            } else {
                $gameBackgroundImage = "pc/General_background.jpg";
            }

            $options = '';
            $amount = $_SESSION['cart'][$count][1];
            for ($index = 1; $index < $this->amountOfOption; $index++) {
                $selected = '';
                ($index == $amount) ? $selected = 'selected' : '';
                $options .= "<option $selected>$index</option>";
            }

            $gameTotalPrice = $game->price * $amount;
            $subtotaal += $gameTotalPrice;
            $cartItemsHtml .= <<< CARTITEMS
            <article style="background: url(/images/games/$gameBackgroundImage) center center no-repeat;">
                <h2><a href = "/games/id/$game->id" >$game->title</a></h2>
                <a href="/games/id/$game->id" >
                    <img alt = "Primary image of the article" class="product-front-img" src = "/images/games/$game->image">
                </a>  
                <strong>$amount x &euro; $game->price = &euro; $gameTotalPrice</strong>
                <form method="post" action="/cart/updateNumberOfItems">
                <input type="hidden" name="gameId" value="$game->id">
                <select name="amount" onchange="this.form.submit()">
                    $options
                  </select>
                  </form>
                <a class="button remove-from-cart" href="/cart/remove/$game->id">
                    <span class="lnr lnr-trash"></span>
                </a>       
            </article>
CARTITEMS;

            $count++;
        }

        $totalPrice = $subtotaal + $verzendkosten; // Default verzendkosten
        $this->registry->template->verzendkosten = $verzendkosten;
        $this->registry->template->subTotal = $subtotaal;
        $this->registry->template->totalPrice = $totalPrice;
        $this->registry->template->cartItemsHtml = $cartItemsHtml;
        $this->registry->template->show('cart');
        unset($_SESSION['addToCartError']);
    }

    /**
     * Add an item to the shoppingcart
     */
    function add()
    {
        $gameId = intval($this->registry->params[0]);
        $game = new \Webshop\Model\Game();
        $game = $game->getOne("id", $gameId);

        if (!is_numeric($gameId) || (!empty($_SESSION['cart']) && in_array($gameId, $_SESSION['cart']))) {
            echo "gameId is niet numeric, geldig of winkelwagen bevat al deze game!";
        } else {
            $amount = 1;
            (isset($_POST['amount']) ? $amount = intval($_POST['amount']) : '');

            $supply = $game->supply;
            // Throw error if the requested amount is higher then the supply
            if ($supply < $amount) {
                $_SESSION['addToCartError'] = "We hebben maar " . $supply. " games in voorraad van ". $game->title;
                $amount = $supply;
            }

            $gameItem = [intval($gameId), $amount];
            $_SESSION['cart'][] = $gameItem;
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

        $count = 0;
        for ($index = 0; $index < sizeof($_SESSION['cart']); $index++) {

            if ($_SESSION['cart'][$index][0] == $gameId) {
                unset($_SESSION['cart'][$index]);
            }
        }
        if($count == 0){
            unset($_SESSION['cart']);
        }

        header("Location: /cart");
    }

    /**
     * Update number of items
     */
    function updateNumberOfItems()
    {
        $gameId = intval($_POST['gameId']);
        $amount = intval($_POST['amount']);
        if($amount == 0){
            $amount = 1;
        }

        $game = new \Webshop\Model\Game();
        $game = $game->getOne("id", $gameId);
        if (!empty($gameFromDb)) {
            $_SESSION['addToCartError'] = "Kon de game niet updaten";
            header("Location: /cart");
        }
        $supply = $game->supply;

        // Throw error if the requested amount is higher then the supply
        if ($supply < $amount) {
            $_SESSION['addToCartError'] = "We hebben maar " . $supply. " games in voorraad van ". $game->title;
            $amount = $supply;
        }


        // Set the new amount in the correct game
        for ($index = 0; $index < sizeof($_SESSION['cart']); $index++) {
            if ($_SESSION['cart'][$index][0] == $gameId) {
                $_SESSION['cart'][$index][1] = $amount;
            }
        }
        header("Location: /cart");
    }
}
