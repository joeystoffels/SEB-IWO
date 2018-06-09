<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 08:48
 */

namespace Webshop\Core;


use Throwable;

class CoreException extends \Exception
{

    /**
     * Exception constructor.
     */
    public function __construct(string $errorMesssage)
    {
        echo $errorMesssage;
    }
}
