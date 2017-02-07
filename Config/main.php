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
        }
    ],
];