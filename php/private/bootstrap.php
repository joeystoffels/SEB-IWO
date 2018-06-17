<?php

namespace Webshop;
require_once __DIR__ . "/../vendor/autoload.php";

session_start();
ob_start();


/** Absolute path for the environment. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__));
}

spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $prefix = 'Webshop\\';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }
    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = ABSPATH . "/" . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

$application = new \Webshop\Core\Application();
$application->init();
