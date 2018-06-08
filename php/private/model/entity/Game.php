<?php

namespace Webshop\Model\Entity;

class Game
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

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getMinAge()
    {
        return $this->minAge;
    }

    /**
     * @param mixed $minAge
     */
    public function setMinAge($minAge)
    {
        $this->minAge = $minAge;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * @param mixed $developer
     */
    public function setDeveloper($developer)
    {
        $this->developer = $developer;
    }

    /**
     * @return mixed
     */
    public function getLanguageText()
    {
        return $this->languageText;
    }

    /**
     * @param mixed $languageText
     */
    public function setLanguageText($languageText)
    {
        $this->languageText = $languageText;
    }

    /**
     * @return mixed
     */
    public function getLanguageSpoken()
    {
        return $this->languageSpoken;
    }

    /**
     * @param mixed $languageSpoken
     */
    public function setLanguageSpoken($languageSpoken)
    {
        $this->languageSpoken = $languageSpoken;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param mixed $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImageBackground()
    {
        return $this->imageBackground;
    }

    /**
     * @param mixed $imageBackground
     */
    public function setImageBackground($imageBackground)
    {
        $this->imageBackground = $imageBackground;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }


}
