<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

use Delight\Auth\Auth;
use DI\Container;
use DI\ContainerBuilder;
use YourOwnFramework\View\View;

class YourOwnFramework
{
    const CONTAINER_CONTAINER_KEY = 'container';
    /**
     * @var array
     */
    private $config;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $controllerClassName;

    /**
     * @var string
     */
    private $actionMethodName;

    /**
     * @var ControllerInterface
     */
    private $controller;

    /**
     * YourOwnFramework constructor.
     *
     * @param array $config
     * @param Container $container|null
     */
    public function  __construct(Array $config, Container $container = null)
    {
        $this->config = $config;
        $this->container = $container ?? $this->initializeContainer();
    }

    public function run()
    {
        $this->route();
        $params = $this->runAction();
        $this->getView()->render($params);
    }

    private function route()
    {
        $router = $this->getRouter();
        $route = $router->getRoute();

        $this->controllerClassName = $route[Router::CONTROLLER];
        $this->actionMethodName = $route[Router::ACTION];
    }

    /**
     * @return array
     */
    private function runAction() : array
    {
        $this->controller = $this->getController($this->controllerClassName);

        return $this->controller->callAction($this->actionMethodName);
    }

    /**
     * @return Router
     * @throws \DI\NotFoundException
     */
    private function getRouter() : Router
    {
        return $this->container->get('router');
    }

    /**
     * @return Container
     */
    private function initializeContainer() : Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($this->config[self::CONTAINER_CONTAINER_KEY]);

        return $builder->build();
    }

    /**
     * @param string $controllerClassName
     *
     * @return ControllerInterface
     */
    private function getController(string $controllerClassName) : ControllerInterface
    {
        /** @var ControllerInterface $controller */
        $controller = new $controllerClassName();
        $controller->setConfig($this->config);
        $controller->setContainer($this->container);
        $controller->setAuth($this->getAuth());
        $controller->setRequest($this->getRequest());

        return $controller;
    }

    /**
     * @return View
     *
     * @throws \DI\NotFoundException
     */
    private function getView() : View
    {
        $view = $this->container->get(View::CONTAINER_KEY);
        $view->setTemplatePath($this->controller->getTemplatePath());
        $view->setLayoutPath($this->controller->getLayoutPath());
        $view->setAuth($this->getAuth());

        return $view;
    }

    /**
     * @return Auth
     *
     * @throws \DI\NotFoundException
     */
    private function getAuth()
    {
        return $this->container->get('auth');
    }

    /**
     * @return Request
     *
     * @throws \DI\NotFoundException
     */
    private function getRequest()
    {
        $request = $this->container->get(Request::CONTAINER_KEY);

        return $request;
    }
}
