<?php

namespace Webshop\Model\Dao;

class GameDao {

    public function selectAllGames() {
        $sql = "SELECT * FROM Games;";

        $result = \Webshop\Helper\Database::getConnection()->query($sql)->fetchAll();
        $resultList = [];

        foreach($result as $row) {
            $game = new \Webshop\Model\Entity\Game();
            $game->setTitle($row['title']);
            $game->setPrice($row['price']);
            $game->setMinAge($row['pegiAge']);
            $game->setDeveloper($row['developer']);
            $game->setPublisher($row['publisher']);
            $game->setLanguageText($row['languageText']);
            $game->setLanguageSpoken($row['languageSpoken']);
            $game->setPlatform($row['platform']);
            $game->setDetails($row['details']);
            $game->setImage($row['image']);
            $game->setImageBackground($row['imageBackground']);
            $game->setReleaseDate($row['releaseDate']);
            $resultList[] = $game;
        }

        return $resultList;
    }
}
