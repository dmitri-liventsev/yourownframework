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
    protected $request;
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
    protected $layout = 'layout';

    /**
     * @var string
     */
    protected $template = 'default';

    /**
     * @param array $config
     * @return void
     */
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
     * @return string
     */
    public function getLayoutPath() : string
    {
        return ROOT . $this->config['layoutPath'] . $this->layout . '.php';
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

    /**
     * @param $path
     */
    protected function redirect($path)
    {
        header("Location: /" . $path);
        die();
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
