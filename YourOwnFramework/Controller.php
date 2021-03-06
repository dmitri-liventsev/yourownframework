<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

use Delight\Auth\Auth;
use DI\Container;
use YourOwnFramework\Request\Request;

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
     * @param string $actionMethodName
     * @return mixed
     */
    public function callAction(string $actionMethodName)
    {
        $this->before();
        $result = $this->$actionMethodName($this->request) ?? [];

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

    /**
     * @param string $containerKey
     *
     * @return mixed
     */
    protected function get(string $containerKey)
    {
        return $this->container->get($containerKey);
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $name
     * @param $value
     * @param int $lifeTime
     */
    protected function setCookie(string $name, $value, int $lifeTime)
    {
        setcookie($name, $value, time() + $lifeTime);
    }

    /**
     * @param $headerName
     * @param $value
     */
    protected function header(string $headerName, string $value)
    {
        header("$headerName: $value");
    }
}

