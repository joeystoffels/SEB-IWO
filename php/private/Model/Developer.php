<?php

namespace Webshop\Model;


use Webshop\Core\Model;

class Developer extends Model
{
    private $developers;

    public function __construct()
    {
        parent::__construct('developers');
    }
}
