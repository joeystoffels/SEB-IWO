<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;

class GameController extends Controller {

    private $gameService;

    public function __construct() {
        $this->gameService = new \Webshop\Model\GameService();
    }

    /**
     * @all controllers must contain an index method
     */
    public function index()
    {
        // TODO: Implement index() method.
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
