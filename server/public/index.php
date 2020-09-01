<?php

use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;

define('BASE__PATH', dirname(__DIR__));
define('APP_PATH', BASE__PATH . '/app/');

$config = new ConfigIni(
    APP_PATH.'config/config.ini'
);

require APP_PATH.'config/loader.php';

require APP_PATH.'config/services.php';

$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER['REQUEST_URI']
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Shit '.$e->getMessage();
}