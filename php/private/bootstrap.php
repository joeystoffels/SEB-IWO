<?php

namespace Webshop;
use  Webshop\Core\Application;

session_start();
ob_start();


/** Absolute path for the environment. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(dirname(__FILE__)) . '/');
}


function loadConfiguration()
{
  $fileName = ABSPATH . "private/Config/config-prd.php";
  if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    $fileName = ABSPATH . "private/Config/config-dev.php";
  }

  if (file_exists($fileName)) {
    require $fileName;
  } else {
    die("Configuration file not found");
  }
}

loadConfiguration();

if (DEBUG) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
} else {
  error_reporting(0);
  ini_set('display_errors', 0);
}

spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $prefix = 'Webshop\\';
    // base directory for the namespace prefix
    $base_dir = ABSPATH . 'private/';
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
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});


$application =  new \Webshop\Core\Application();

$gamecontroller = new \Webshop\Controller\GameController;
$data = $gamecontroller->getAllGames();
var_dump($data);
