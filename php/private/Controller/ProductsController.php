<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Database;
use PDO;

class ProductsController extends Controller {

    public function index() {

        var_dump($_GET);

        $db = Database::getConnection();
        $result = $db->query('SELECT * FROM games');
        $result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Game');
        var_dump($result->fetch());

        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";

        $this->registry->template->show('landingspage');
    }

    public function game(){

        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";
        $this->registry->template->gameId = $this->registry->params[0];

        $this->registry->template->show('game');

    }
}
