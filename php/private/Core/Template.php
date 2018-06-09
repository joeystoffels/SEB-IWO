<?php

namespace Webshop\Core;


class Template
{

    function __construct($registry)
    {
        $this->registry = $registry;

    }

    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }


    function show($name)
    {
        $path = ABSPATH . '/View/' . $name . '.phtml';

        if (file_exists($path) == false) {
            throw new CoreException('Template not found in ' . $path);
            return false;
        }

        // Load variables
        foreach ($this->vars as $key => $value) {
            $$key = $value;
        }

        include($path);
    }


}
