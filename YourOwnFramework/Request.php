<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;


class Request
{
    const CONTAINER_KEY = 'request';

    const METHOD_POST = 'POST';

    /**
     * @var array
     */
    private $post;

    /**
     * @var array
     */
    private $get;

    /**
     * @var array
     */
    private $server;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $cookie;

    /**
     * @var string
     */
    private $method;

    public function __construct(RequestDataProvider $requestDataProvider)
    {
        $this->post = $requestDataProvider->getPost();
        $this->get = $requestDataProvider->getGet();
        $this->server = $requestDataProvider->getServer();
        $this->cookie = $requestDataProvider->getCookies();

        $this->init();
    }

    private function init()
    {
        $this->determineMethod();
        $this->determineParams();
    }

    /**
     * @param string $fieldName
     *
     * @return null|int|string|array
     */
    public function get(string $fieldName)
    {
        return $this->params[$fieldName] ?? null;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->method == self::METHOD_POST;
    }

    private function determineMethod()
    {
        $this->method = $this->server['REQUEST_METHOD'];
    }

    public function determineParams()
    {
        $this->params = $this->post + $this->get;
    }

    /**
     * @return string
     */
    public function getIp() : string
    {
        return $this->server['REMOTE_ADDR'];
    }

    /**
     * @param string $cookieName
     *
     * @return string|int|null
     */
    public function getCookie(string $cookieName)
    {
        return isset($this->cookie[$cookieName]) ? $this->cookie[$cookieName] : null;
    }

    /**
     * @param $cookieName
     * @return bool
     */
    public function hasCookie(string $cookieName) : bool
    {
        return $this->getCookie($cookieName) !== null;
    }
}
