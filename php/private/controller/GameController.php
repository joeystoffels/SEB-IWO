<?php

class GameController {

    private $gameService;

    public function __construct() {
        $this->gameService = new GameService();
    }

    public function getAllGames() {
        $gameList = $this->gameService->selectAllGames();

//        $resultList = [];
//        foreach ($gameList as $game) {
//            $game = $this->convertEntityToDto($game);
//            $resultList[] = $game;
//        }

        return $gameList;
    }

    public function convertEntityToDto($entity) {
        // todo
        // return DTO object
    }
}