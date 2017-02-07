<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

use Interop\Container\ContainerInterface;
use YourOwnFramework\YourOwnFramework;

return [
    'templatePath' => '/App/View/',
    YourOwnFramework::CONFIG_KEY_CONTAINER => [
        \YourOwnFramework\Router::CONTAINER_ROUTER => function (ContainerInterface $c) {
            return new \YourOwnFramework\Router();
        },
        \YourOwnFramework\View::CONTAINER_VIEW => function (ContainerInterface $c) {
            return new \YourOwnFramework\View();
        },
        'auth' => function (ContainerInterface $c) {
            $db = $c->get('db');
            return new \Delight\Auth\Auth($db);
        },

        //DATABASE
        'db-username' => 'root',
        'db-password' => '',
        'db-database' => 'tactica',
        'db' => function(ContainerInterface $c) {
            try {
                return new PDO('mysql:dbname=' . $c->get('db-database') . ';host=localhost;charset=utf8mb4', $c->get('db-username'), $c->get('db-password'));
            } catch(Throwable $e) {
                echo "DB connection error"; exit;
            }
        },
    ],
];