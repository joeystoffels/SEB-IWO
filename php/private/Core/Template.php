<?php

namespace Webshop\Core;


class Template
{
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

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

        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }

        include($path);
    }
}
