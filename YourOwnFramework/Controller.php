<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

use Delight\Auth\Auth;
use DI\Container;

abstract class Controller implements ControllerInterface
{
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var array
     */
    private $config;

    /**
     * @var Container
     */
    private $container;
    /**
     * @param array $config
     * @return void
     */

    private $template = 'default';

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param Container $container
     * @return void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getTemplatePath() : string
    {
        return ROOT . $this->config['templatePath'] . $this->template . '.php';
    }

    /**
     * @param string $actionMethodName
     * @return mixed
     */
    public function callAction(string $actionMethodName)
    {
        $this->before();
        $result = $this->$actionMethodName() ?? [];

        return $result;
    }

    protected function before()
    {
        //Before event
    }

    protected function redirect()
    {
        //TODO: implement it!
    }

    /**
     * @param Auth $auth
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return Auth
     */
    protected function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request;
    }
}

