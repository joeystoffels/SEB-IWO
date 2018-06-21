<?php

namespace Webshop\Model;

use Webshop\Core\Model;

/**
 * A object representation of the database table Game
 * Class Game
 * @package Webshop\Model
 */
class Game extends Model
{
    /**
     * @var int Id
     */
    private $id;

    /**
     * @var string Title
     */
    private $title;

    /**
     * @var double Price
     */
    private $price;

    /**
     * @var int Minimal Age
     */
    private $minAge;

    /**
     * @var string Publisher
     */
    private $publisher;

    /**
     * @var string Developer
     */
    private $developer;

    /**
     * @var string Language of the Text
     */
    private $languageText;

    /**
     * @var string Spoken language
     */
    private $languageSpoken;

    /**
     * @var string Platform
     */
    private $platform;

    /**
     * @var string Details
     */
    private $details;

    /**
     * @var string Image
     */
    private $image;

    /**
     * @var string BackgroundImage
     */
    private $imageBackground;

    /**
     * @var Date Release Date
     */
    private $releaseDate;

    /**
     * @var int Supply amount
     */
    private $supply;

    public function __construct()
    {
        parent::__construct('games');
    }

    /**
     * Magic getter. Silently ignore invalid fields
     * @param string $key Name of the private variable to get
     * @return mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }

    /**
     * Magic setter
     * @param string $key Name of the private variable to set
     * @param string $value Value of the private variable to set
     */
    public function __set($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
}
