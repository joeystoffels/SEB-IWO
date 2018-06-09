<?php

namespace Webshop\Model;

use Webshop\Core\Model;

class Game extends Model
{
    private $title;
    private $price;
    private $minAge;
    private $publisher;
    private $developer;
    private $languageText;
    private $languageSpoken;
    private $platform;
    private $details;
    private $image;
    private $imageBackground;
    private $releaseDate;

    public function __construct()
    {
        parent::__construct('games');
    }

}
