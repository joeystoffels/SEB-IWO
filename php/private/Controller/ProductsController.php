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
        $this->registry->template->title = "Producten";
        $this->registry->template->description = "Bekijk hier alle nieuwste en hipster spellen.";
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
            $categoriesHtml .= "<button type='submit' value='Submit'>Filteren</button>";
            $categoriesHtml .= "</fieldset>";
        }
        $this->registry->template->categories = $categoriesHtml;

        $gamesData = $games->getPage(1, 25, (isset($whereStatement)) ? $whereStatement : null);
        $gamesHtml = '';
        foreach ($gamesData['data'] as $game) {
            $truncated = Util::cleanStringAndTruncate($game->details, 200);
            $gamesHtml .= <<< GAME
            <article >
                <a href="/products/game/$game->id">
                    <h3>$game->title</h3>
                    <figure>
                        <img alt = "Primary image of the article" class="product-front-img" src = "/images/games/$game->image" >
                    </figure>
                </a >
                <ul>
                    <li class="price">&euro; $game->price</li>
                    <li>
                        <a class="button add-to-cart" href="/cart/add/$game->id"><span class="lnr lnr-cart" ></span></a>
                    </li>
                    <li>
                        <a class="button" href="/products/game/$game->id" ><span class="lnr lnr-magnifier" ></span ></a>
                    </li>
                </ul>
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
