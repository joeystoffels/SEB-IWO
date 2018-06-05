<?php

class GameDao {

    public function selectAllGames() {
        $sql = "SELECT * FROM Games;";

        $result = Database::getConnection()->query($sql)->fetchAll();
        $resultList = [];

        foreach($result as $row) {
            $game = new Game();
            $game->setTitle($row['title']);
            $game->setCategory($row['category']);
            $game->setMinAge($row['minage']);
            $game->setReleaseDate($row['releasedate']);
            $game->setPrice($row['price']);
            $game->setPublisher($row['publisher']);
            $game->setPlatform($row['platform']);

            $resultList[] = $game;
        }

        return $resultList;
    }
}