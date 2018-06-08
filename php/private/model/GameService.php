<?php

namespace Webshop\Model;

class GameService {

    private $gameDao;

    public function __construct() {
        $this->gameDao = new \Webshop\Model\Dao\GameDao();
    }

    public function selectAllGames() {
        $allGames = $this->gameDao->selectAllGames();
        return $allGames;
    }
}
