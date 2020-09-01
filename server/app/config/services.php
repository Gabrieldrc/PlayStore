<?php

use Phalcon\Mvc\View;
use Phalcon\Events\Event;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Session\Adapter\Files as Session;

$container = new FactoryDefault();

$container->set(
    'db',
    function () use ($config) {
        return new Mysql(
            [
                'host'     => $config->database->host,
                'dbname'   => $config->database->name,
                'port'     => $config->database->port,
                'username' => $config->database->username,
                'password' => $config->database->password,
            ]
        );
    }
);

// Registering the view component
$container->set(
    'view',
    function () use ($config){

        return new View();
    }
);

$container->set(
    'router',
    function () {
        return include APP_PATH . 'config/routes.php';
    }
);

$container->set(
    'session',
    function () {
        $session = new Session();

        $session->start();

        return $session;
    }
);

$container->set(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Procesamiento de CORS y Preflight
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            function (Event $event, MvcDispatcher $dispatcher) {
                $container = $dispatcher->getDI();
                $request = $container->get('request');
                $response = $container->get('response');
                // Permitimos desde cualquier origen
                if (! empty($request->getHeader('Origin'))) {
                    $response->setHeader('Access-Control-Allow-Origin', $request->getHeader('Origin'));
                    $response->setHeader('Access-Control-Allow-Credentials', 'true');
                    $response->setHeader('Access-Control-Max-Age', '86400'); // 1 dia
                }
                // Preflight
                if ('OPTIONS' === $request->getMethod()) {
                    if (! empty($request->getHeader('Access-Control-Request-Method'))) {
                        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                    }
                    if (! empty($request->getHeader('Access-Control-Request-Headers'))) {
                        $response->setHeader(
                            'Access-Control-Allow-Headers',
                            $request->getHeader('Access-Control-Request-Headers')
                        );
                    }
                    $response->setStatusCode(200);
                    $response->send();

                    // Finalize request
                    exit();
                }
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);