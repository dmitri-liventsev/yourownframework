<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
use Interop\Container\ContainerInterface;

return [
    /*****************Application*************/

    //Repositories

    \App\Model\Repository\ProfileRepository::CONTAINER_KEY => function (ContainerInterface $c) {
        return new \App\Model\Repository\ProfileRepository(
            $c->get(\YourOwnFramework\Db\Executor::CONTAINER_KEY),
            \App\Model\Entity\Profile::class
        );
    },
    \App\Model\Repository\WidgetRepository::CONTAINER_KEY => function (ContainerInterface $c) {
        return new \App\Model\Repository\WidgetRepository(
            $c->get(\YourOwnFramework\Db\Executor::CONTAINER_KEY),
            \App\Model\Entity\Widget::class
        );
    },

    //Service Executors

    \App\Service\ProfileEdit::CONTAINER_KEY_EXECUTOR => function (ContainerInterface $c) {
        return new ServiceExecutor\ServiceExecutor(
            new \App\Service\Validator\ProfileEditValidator(),
            $c->get(\App\Service\ProfileEdit::CONTAINER_KEY)
        );
    },

    \App\Service\ProfileGet::CONTAINER_KEY_EXECUTOR => function (ContainerInterface $c) {
        return new ServiceExecutor\ServiceExecutor(
            new \App\Service\Validator\ProfileGetValidator(),
            $c->get(\App\Service\ProfileGet::CONTAINER_KEY)
        );
    },
    \App\Service\WidgetGet::CONTAINER_KEY_EXECUTOR => function (ContainerInterface $c) {
        return new ServiceExecutor\ServiceExecutor(
            new \App\Service\Validator\WidgetGetValidator(),
            $c->get(\App\Service\WidgetGet::CONTAINER_KEY)
        );
    },

    //Services

    \App\Service\ProfileEdit::CONTAINER_KEY => function (ContainerInterface $c) {
        $service = new \App\Service\ProfileEdit();
        $service->setProfileRepository($c->get(\App\Model\Repository\ProfileRepository::CONTAINER_KEY));
        $service->setWidgetRepository($c->get(\App\Model\Repository\WidgetRepository::CONTAINER_KEY));

        return $service;
    },

    \App\Service\ProfileGet::CONTAINER_KEY => function (ContainerInterface $c) {
        $service = new \App\Service\ProfileGet();
        $service->setProfileRepository($c->get(\App\Model\Repository\ProfileRepository::CONTAINER_KEY));
        $service->setWidgetRepository($c->get(\App\Model\Repository\WidgetRepository::CONTAINER_KEY));

        return $service;
    },
    \App\Service\WidgetGet::CONTAINER_KEY => function (ContainerInterface $c) {
        $service = new \App\Service\WidgetGet();
        $service->setProfileRepository($c->get(\App\Model\Repository\ProfileRepository::CONTAINER_KEY));
        $service->setWidgetRepository($c->get(\App\Model\Repository\WidgetRepository::CONTAINER_KEY));

        return $service;
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