<?php

namespace Webshop\Core;

use Webshop\Model\Platform;

/**
 * Parent class for all Templates
 * In this class all variables will be added to be used with the template
 *
 * Class Template
 * @package Webshop\Core
 */
class Template
{
    /**
     * Magic setter
     * @param string $key Name of the private variable to set
     * @param string $value Value of the private variable to set
     */
    public function __set($key, $value)
    {
        $this->vars[$key] = $value;
    }

    /**
     * Function that loads the phtml files and adds the variabels to it
     * @param string $name Name of the template being loaded
     * @throws CoreException
     */
    function show($name)
    {
        $path = ABSPATH . '/View/' . $name . '.phtml';

        if (!file_exists($path)) {
            throw new CoreException('Template not found in ' . $path);
        }


        // Add useraccount information to the template
        $registry = Registry::Instance();
        $userAccount = $registry->userAccount;
        if ($userAccount->isLogedIn()) {
            $this->vars['userInfo'] = $userAccount->getUserInfo();
        }

        // Add the number of cart items in the template
        $this->vars['cartItems'] = Util::getNrCartItems();


        // Add plaforms for header dropdown
        $platform = new \Webshop\Model\Platform();
        $platforms = $platform->getAll();
        $platformsHtml = '';
        foreach ($platforms as $platform) {
            $platformsHtml .= "<li><a href='/?Platform[$platform->name]=$platform->value'>$platform->value</a></li>";
        }
        $this->vars['platforms'] =  $platformsHtml;

        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }

        include($path);
    }
}
