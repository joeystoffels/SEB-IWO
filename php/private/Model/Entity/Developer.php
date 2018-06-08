<?php

namespace Webshop\Model\Entity;


class Developer
{
  private $developer;

  /**
   * Get the developer value
   * @return string
   */
  public function getDeveloper() : string
  {
    return $this->developer;
  }

  /**
   * @param string $developer
   */
  public function setDeveloper(string $developer)
  {
    $this->developer = $developer;
  }
}
