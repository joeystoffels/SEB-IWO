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
    }

    public function index()
    {
        // Initialize the models we need
        $platform = new \Webshop\Model\Platform();
//        $developers = new \Webshop\Model\Developer();
        $games = new \Webshop\Model\Game();

        $whereStatement = null;
        (isset($_GET['Platform'])) ? $whereStatement['platform'] = $_GET['Platform'] : '';
        (isset($_GET['Developers'])) ? $whereStatement['developer'] = $_GET['Developers'] : '';


        // Get the categories
        $categories['Platform'] = $platform->getAll();
//        $categories['Developers'] = $developers->getAll($_GET['Developers']);


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
                    <div class="product-thumb" >
                        <a href = "#" >
                            <img alt = "Secondary image of the article" class="product-back-img" src = "http://via.placeholder.com/480x480/666666/898989" > 
                            <img alt = "Primary image of the article" class="product-front-img" src = "/images/games/$game->image" >
                        </a >
                    </div >
                    <div class="product-info" >
                        <h3><a href = "#" >$game->title</a></h3>
                        <p>$truncated</p >
                        <span class="price" >&euro; $game->price</span >
                    </div >
                    <div class="product-action" >
                        <a class="button add-to-cart" href = "/cart/add/$game->id" > Add to Cart </a > <a class="button" href = "/cart/add/$game->id"><span
                                class="lnr lnr-heart" ></span ><span class="button-text" > Add to Wishlist </span ></a > <a
                            class="button" href = "#" ><span class="lnr lnr-magnifier" ></span ><span class="button-text" > Go to Article </span ></a >
                    </div >
            </article >
GAME;

        }

        $this->registry->template->games = $gamesHtml;
        $this->registry->template->show('landingspage');
    }

    public function game()
    {

        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";
        $this->registry->template->gameId = $this->registry->params[0];

        $this->registry->template->show('game');

    }
}
