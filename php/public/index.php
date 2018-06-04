<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('VIEW', ROOT . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
define('GameService', ROOT . 'app' . DIRECTORY_SEPARATOR . 'GameService' . DIRECTORY_SEPARATOR);
define('DATA', ROOT . 'app' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
define('CORE', ROOT . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR);
define('CONTROLLER', ROOT . 'app' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);
define('MODEL', ROOT . 'app' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR);
define('DAO', ROOT . 'app' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'dao');
define('ENTITY', MODEL . 'entity' . DIRECTORY_SEPARATOR);
$modules  = [ROOT,APP,CORE,CONTROLLER,DATA, MODEL, DAO, ENTITY];

set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR,$modules));
spl_autoload_register('spl_autoload', false);

new Application;

$gamecontroller = new GameController();
$data = $gamecontroller->getAllGames();

echo "Select all Games: <br>";
var_dump($data);