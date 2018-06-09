<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

class ProductsController extends Controller
{

    public function index()
    {

        $games = new \Webshop\Model\Game();
        var_dump($games->getAll());


        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";

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
