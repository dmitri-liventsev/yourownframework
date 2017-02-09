<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
use Interop\Container\ContainerInterface;

return [
    /*****************Application*************/
    \App\Model\Repository\ProfileRepository::CONTAINER_KEY => function (ContainerInterface $c) {
        return new \App\Model\Repository\ProfileRepository(
            $c->get(\YourOwnFramework\Db\Executor::CONTAINER_KEY),
            \App\Model\Entity\Profile::class
        );
    },
    \App\Model\Repository\UicRepository::CONTAINER_KEY => function (ContainerInterface $c) {
        return new \App\Model\Repository\UicRepository(
            $c->get(\YourOwnFramework\Db\Executor::CONTAINER_KEY),
            \App\Model\Entity\Uic::class
        );
    },

    /*****************System*************/
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
        return new \YourOwnFramework\View\View(
            $c->get(\YourOwnFramework\View\FormHelper::CONTAINER_KEY),
            $c->get('layoutDirectory'),
            $c->get('templateDirectory')
        );
    },
    \YourOwnFramework\View\FormHelper::CONTAINER_KEY => function (ContainerInterface $c) {
        return new \YourOwnFramework\View\FormHelper();
    },
    'templateDirectory' => '/App/View/',
    'layoutDirectory' => '/App/View/Layout/',

    //DATABASE
    \YourOwnFramework\Db\ErzatsQueryBuilder::CONTAINER_KEY => function (ContainerInterface $c) {
        return new \YourOwnFramework\Db\ErzatsQueryBuilder();
    },
    \YourOwnFramework\Db\Executor::CONTAINER_KEY => function (ContainerInterface $c) {
        return new \YourOwnFramework\Db\Executor($c->get('db'), $c->get(\YourOwnFramework\Db\ErzatsQueryBuilder::CONTAINER_KEY));
    },
    'auth' => function (ContainerInterface $c) {
        $db = $c->get('db');
        return new \Delight\Auth\Auth($db);
    },
    'db' => function(ContainerInterface $c) {
        try {
            return new PDO('mysql:dbname=' . $c->get('db-database') . ';host=localhost;charset=utf8mb4', $c->get('db-username'), $c->get('db-password'));
        } catch(Throwable $e) {
            echo "DB connection error"; exit;
        }
    },
] + require(__DIR__.'/db.php');