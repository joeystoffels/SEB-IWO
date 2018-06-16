<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

class ProductsController extends Controller
{

    protected $registry;

    function __construct($registry)
    {
        $this->registry = $registry;
        $this->registry->template->title = "GameParadise - Producten";
        $this->registry->template->description = "Dit is de text die geindexeerd word door Google";
        $this->registry->template->cartItems = Util::getNrCartItems();


    }

    public function index()
    {
        // Initialize the models we need
        $platform = new \Webshop\Model\Platform();

        $games = new \Webshop\Model\Game();

        $whereStatement = null;
        (isset($_GET['Platform'])) ? $whereStatement['platform'] = $_GET['Platform'] : '';

        // Get the categories
        $categories['Platform'] = $platform->getAll();

        $categoriesHtml = '';
        foreach ($categories as $categoryKey => $categoryValue) {
            $categoriesHtml .= "<fieldset>";
            $categoriesHtml .= "<legend>$categoryKey</legend>";
            foreach ($categoryValue as $object) {
                $unique = uniqid();
                $value = $object->value;
                if (empty($value)) {
                    $value = $object->name;
                };

                $checked = '';
                (isset($_GET[$categoryKey][$object->name])) ? $checked = " checked " : '' ;

                $categoriesHtml .= "   <input type='checkbox' id='$unique' name='" . $categoryKey . "[" . $object->name . "]' $checked  value='$value'/>";
                $categoriesHtml .= "   <label for='$unique'><span>checkbox</span>$object->name</label>";
            }
            $categoriesHtml .= "<input type='submit' name='Filteren'>";
            $categoriesHtml .= "</fieldset>";
        }
        $this->registry->template->categories = $categoriesHtml;

        $gamesData = $games->getPage(1, 25, (isset($whereStatement)) ? $whereStatement : null);
        $gamesHtml = '';
        foreach ($gamesData['data'] as $game) {
            $truncated = Util::cleanStringAndTruncate($game->details, 200);
            $gamesHtml .= <<< GAME
            <article >
            <div class="product-border">
                    <div class="product-thumb" >
                        <a href = "/products/game/$game->id" >
                            <img alt = "Secondary image of the article" class="product-back-img" src = "http://via.placeholder.com/480x480/666666/898989" > 
                            <img alt = "Primary image of the article" class="product-front-img" src = "/images/games/$game->image" >
                        </a >
                    </div >
                    <div class="product-info">
                        <h3><a href="/products/game/$game->id">$game->title</a></h3>
                        <!--<p>$truncated</p>-->
                    </div>
                    <div class="product-action">
                        <span class="price">&euro; $game->price</span>
                        <a class="button add-to-cart" href="/cart/add/$game->id">In winkelwagen</a> 
                        <!--<a class="button" href="/cart/add/$game->id"><span class="lnr lnr-heart" ></span ><span class="button-text" > Add to Wishlist </span ></a >-->
                        <a class="button" href = "#" ><span class="lnr lnr-magnifier" ></span ><span class="button-text" > Ga naar artikel </span ></a>
                    </div >
                    </div>
            </article >
GAME;

        }

        $this->registry->template->games = $gamesHtml;
        $this->registry->template->show('landingspage');
    }

    public function game()
    {
        $this->registry->template->title = "GameParadise - GameDetail";
        $this->registry->template->description = "Product Details";
        $game = new \Webshop\Model\Game();

        $gameHtml = "";

        $gameId = $this->registry->params[0];

        if ($game->getOne("id", $gameId)) {
            $resultGame = $game->getOne("id", $gameId);
        } else {
            echo "Error, gameId not found!";
        }

        if (file_exists("images/games/" . $resultGame->imageBackground)) {
            $gameBackgroundImage = $resultGame->imageBackground;
        } else {
            $gameBackgroundImage = "pc/General_background.jpg";
        }

        $gameHtml = <<< GAME
        <div class="main-container container">
        <aside>
            <img alt = "Primary image of the article" class="product-detail-front-img" src = "/images/games/$resultGame->image" ><br><br>
            <span class="price"><strong>Prijs: &euro; $resultGame->price</strong></span><br><br>
            <div class="product-detail-action">
                <a class="add-to-cart" href = "/cart/add/$resultGame->id" > + In winkelwagen </a > <a class="" href = "/cart/add/$resultGame->id">
            </div >
        </aside>
        <main>
        
            <article >
            
                    <div class="product-detail-thumb">
                        <a href = "#" >
                            <img alt = "Secondary image of the article" class="product-detail-back-img" src = "/images/games/$gameBackgroundImage"> 
                        </a>
                    </div>
                    <div class="product-info" >                        
                        <p>$resultGame->details</p>
                    </div>

            </article >
        </main>
        </div>
GAME;


        $this->registry->template->game = $gameHtml;

        $this->registry->template->show('game');

    }
}
