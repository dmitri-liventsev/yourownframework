<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

use Interop\Container\ContainerInterface;
use YourOwnFramework\YourOwnFramework;

return [
    'templatePath' => '/App/View/',
    'layoutPath' => '/App/View/Layout/',
    YourOwnFramework::CONTAINER_CONTAINER_KEY => [
        \YourOwnFramework\Router::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \YourOwnFramework\Router();
        },
        \YourOwnFramework\RequestDataProvider::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \YourOwnFramework\RequestDataProvider();
        },
        \YourOwnFramework\Request::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \YourOwnFramework\Request($c->get(\YourOwnFramework\RequestDataProvider::CONTAINER_KEY));
        },

        //VIEW
        \YourOwnFramework\View\View::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \YourOwnFramework\View\View($c->get(\YourOwnFramework\View\FormHelper::CONTAINER_KEY));
        },
        \YourOwnFramework\View\FormHelper::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \YourOwnFramework\View\FormHelper();
        },

        //DB
        \YourOwnFramework\Db\ErzatsQueryBuilder::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \YourOwnFramework\Db\ErzatsQueryBuilder();
        },
        \YourOwnFramework\Db\Executor::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \YourOwnFramework\Db\Executor($c->get('db'), $c->get(\YourOwnFramework\Db\ErzatsQueryBuilder::CONTAINER_KEY));
        },
        \App\Model\Repository\ProfileRepository::CONTAINER_KEY => function (ContainerInterface $c) {
            return new \App\Model\Repository\ProfileRepository(
                $c->get(\YourOwnFramework\Db\Executor::CONTAINER_KEY),
                \App\Model\Entity\Profile::class
            );
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