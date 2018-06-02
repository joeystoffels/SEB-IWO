<?php

class GameDao extends PDODao {

    public function selectAllGames() {
        $sql = "SELECT * FROM Games;";

        $result = $this->query($sql)->fetchAll();
        $resultList = [];

        foreach($result as $row) {
            $game = new Game();
            $game->setTitle($row['title']);
            $game->setCategory($row['category']);
            $game->setMinAge($row['minAge']);
            $game->setReleaseDate($row['releaseDate']);
            $game->setPrice($row['price']);
            $game->setPublisher($row['publisher']);
            $game->setPlatform($row['platform']);

            $resultList[] = $game;
        }

        return $resultList;
    }
}