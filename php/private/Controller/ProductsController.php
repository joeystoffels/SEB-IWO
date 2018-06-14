<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

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

//        var_dump($_GET);
        // Initialize the models we need
        $platform = new \Webshop\Model\Platform();
        $developers = new \Webshop\Model\Developer();
        $games = new \Webshop\Model\Game();


        (isset($_GET['Platform'])) ? $whereStatement['platform'] = $_GET['Platform']: '';
        (isset($_GET['Developers'])) ? $whereStatement['developers'] = $_GET['Developers']: '';



        // Get the categories
        $categories['Platform'] = $platform->getAll();
        $categories['Developers'] = $developers->getAll();
        $categoriesHtml = '';
        foreach ($categories as $categoryKey => $categoryValue){
            $categoriesHtml .= "<fieldset>";
            $categoriesHtml .= "<legend>$categoryKey</legend>";
            foreach ($categoryValue as $object) {
                $unique = uniqid();
                $value = (isset($object->value))? $object->value : $object->name;
                $categoriesHtml .= "   <input type='checkbox' id='$unique' name='" . $categoryKey. "[". $object->name."]' value='$value'/>";
                $categoriesHtml .= "   <label for='$unique'><span>checkbox</span>$object->name</label>";
            }
            $categoriesHtml .= "<input type='submit' name='Filteren'>";
            $categoriesHtml .= "</fieldset>";
        }
        $this->registry->template->categories =  $categoriesHtml;

        $gamesData = $games->getPage(1, 25, (isset($whereStatement))? $whereStatement: null );
        $gamesHtml = '';
        foreach ($gamesData['data'] as  $game) {
            $truncated = (strlen($game->details) > 150) ? substr($game->details, 0, 200) . '...' : $game->details;
            // Remove all headings and text
            $truncated = preg_replace('#<h([1-6])>(.*?)<\/h[1-6]>#si', '', $truncated);
            // Strip tags
            $truncated = strip_tags($truncated);

            $gamesHtml .= <<< GAME
            <article >
                    <div class="product-thumb" >
                        <a href = "#" >
                            <img alt = "Secondary image of the article" class="product-back-img" src = "http://via.placeholder.com/480x480/666666/898989" > 
                            <img alt = "Primary image of the article" class="product-front-img" src = "/images/games/$game->image" >
                        </a >
                    </div >
                    <div class="product-info" >
                        <h3 ><a href = "#" >$game->title</a></h3>
                        <p>$truncated</p >
                        <span class="price" >&euro; $game->price</span >
                    </div >
                    <div class="product-action" >
                        <a class="button add-to-cart" href = "/cart/add/$game->id" > Add to Cart </a > <a class="button" href = "#" ><span
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
