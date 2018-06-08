<?php
session_start();
ob_start();


/** Absolute path for the environment. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(dirname(__FILE__)) . '/');
}


function loadConfiguration()
{
  $fileName = ABSPATH . "private/config/config-prd.php";
  if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    $fileName = ABSPATH . "private/config/config-dev.php";
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

define('APPLICATION', ABSPATH . 'private' . DIRECTORY_SEPARATOR);
define('GAME_SERVICE', APPLICATION . DIRECTORY_SEPARATOR . 'GameService' . DIRECTORY_SEPARATOR);
define('DATA', APPLICATION . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
define('CORE', APPLICATION . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR);
define('CONTROLLER', APPLICATION . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);
define('HELPER', APPLICATION . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR);
define('MODEL', APPLICATION . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR);
define('DAO', MODEL . DIRECTORY_SEPARATOR . 'dao' . DIRECTORY_SEPARATOR);
define('ENTITY', MODEL . DIRECTORY_SEPARATOR . 'entity' . DIRECTORY_SEPARATOR);
$modules = [ABSPATH, CORE, CONTROLLER, DATA, MODEL, DAO, ENTITY, HELPER];

set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));
spl_autoload_register('spl_autoload', false);

new Application();

$gamecontroller = new GameController();
$data = $gamecontroller->getAllGames();
