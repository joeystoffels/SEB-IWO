<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

class GamesController extends Controller
{
    private $showAmount = 28;

    protected $registry;

    function __construct($registry)
    {
        $this->registry = $registry;
        $this->registry->template->title = "Producten";
        $this->registry->template->description = "Bekijk hier alle nieuwste en hipster spellen.";
        $this->registry->template->cartItems = Util::getNrCartItems();
    }

    public function index($currentPage = 1, $showAmount = null)
    {

        // Initialize the models we need
        $platform = new \Webshop\Model\Platform();
        $games = new \Webshop\Model\Game();

        $whereStatement = null;
        (isset($_GET['Platform'])) ? $whereStatement['platform'] = $_GET['Platform'] : '';

        (is_null($showAmount)) ? $showAmount = $this->showAmount : '';

        // Get the categories
        $categories['Platform'] = $platform->getAll();

        $categoriesHtml = '';
        foreach ($categories as $categoryKey => $categoryValue) {
            $categoriesHtml .= "<form method='GET' action='/games/page/$currentPage/show/$showAmount/'>";
            $categoriesHtml .= "<fieldset>";
            $categoriesHtml .= "<legend>$categoryKey</legend>";
            foreach ($categoryValue as $object) {
                $unique = uniqid();
                $value = $object->value;
                if (empty($value)) {

                    $value = $object->name;
                };

                $checked = '';
                (isset($_GET[$categoryKey][$object->name])) ? $checked = " checked " : '';

                $categoriesHtml .= "   <input type='checkbox' id='$unique' name='" . $categoryKey . "[" . $object->name . "]' $checked  value='$value'/>";
                $categoriesHtml .= "   <label for='$unique'><span>checkbox</span>$object->name</label>";
            }
            $categoriesHtml .= "<button type='submit' value='Submit'>Filteren</button>";
            $categoriesHtml .= "</fieldset>";
            $categoriesHtml .= "</form>";
        }
        $this->registry->template->categories = $categoriesHtml;

        $gamesData = $games->getPage($currentPage, $showAmount, (isset($whereStatement)) ? $whereStatement : null);
        $this->registry->template->pagination = $this->createPagination($gamesData, $currentPage, $showAmount);


        $gamesHtml = '';
        foreach ($gamesData['data'] as $game) {
            $gamesHtml .= <<< GAME
            <article >
                <a href="/games/id/$game->id">
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
                        <a class="button" href="/games/id/$game->id" ><span class="lnr lnr-magnifier" ></span ></a>
                    </li>
                </ul>
            </article >
GAME;

        }

        $this->registry->template->games = $gamesHtml;
        $this->registry->template->show('games');
    }

    public function page()
    {
        $currentPage = 1;
        $showAmount = $this->showAmount;

        if (isset($this->registry->params[0])) {
            $currentPage = intval($this->registry->params[0]);
        }

        if (isset($this->registry->params[2])) {
            $showAmount = intval($this->registry->params[2]);
        }

        if ($currentPage < 1) {
            $this->redirectToPage(1, $showAmount);
        }
        $this->index($currentPage, $showAmount);
    }

    public function id()
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

    private function createPagination($gamesData, $currentPage, $showAmount)
    {
        $paginationSize = 5;

        $numberOfAmountButtons = 3;
        $offset = floor($paginationSize / 2);
        $lastPage = $gamesData['last_page'];
        if ($lastPage < $currentPage) {
            $this->redirectToPage($lastPage, $showAmount);
        }

        $endPage = $currentPage + $offset;
        if ($endPage > $lastPage) {
            $startPage = ($lastPage - $paginationSize) + 1;
        }

        $startPage = $currentPage - $offset;
        if ($startPage < 1) {
            $startPage = 1;
        }
        $pagination = "<ul class='pagination'>";
        $pagination .= "    <li><a href='/games/page/1/show/$showAmount/?" . http_build_query($_GET) . "'>&laquo;</a></li>";
        for ($index = 0; $index < $paginationSize; $index++) {
            if ($startPage <= $lastPage) {
                $active = '';
                ($startPage == $currentPage) ? $active = 'class="active"' : '';
                $pagination .= "    <li $active><a href='/games/page/$startPage/show/$showAmount/?" . http_build_query($_GET) . "'>$startPage</a></li>";
            }
            $startPage++;
        }
        $pagination .= "    <li><a href='/games/page/$lastPage/show/$showAmount/?" . http_build_query($_GET) . "'>&raquo;</a></li>";
        $pagination .= "</ul>";
        $pagination .= "<ul class='pagination paginationAmount'>";
        for ($index = 0; $index < $numberOfAmountButtons; $index++) {
            $amountOnPage = $this->showAmount * ($index + 1);
            $active = '';
            ($amountOnPage == $showAmount) ? $active = 'class="active"' : '';
            $pagination .= "    <li $active><a href='/games/page/$currentPage/show/$amountOnPage/?" . http_build_query($_GET) . "'>$amountOnPage</a></li>";
        }
        $pagination .= "</ul>";

        return $pagination;
    }

    private function redirectToPage($pageNumber, $showAmount)
    {
        header("Location: " . DOMAIN . "/games/page/$pageNumber/show/$showAmount/?" . http_build_query($_GET));
    }
}
