<?php

class GameService {

    private $gameDao;

    public function __construct() {
        $this->gameDao = new GameDao();
    }

    public function selectAllGames() {
        $allGames = $this->gameDao->selectAllGames();
        return $allGames;
    }
}