<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework\Request;


use YourOwnFramework\Exception\SecurityException;

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

    /**
     * @var Csrf
     */
    private $csrf;

    /**
     * @var string
     */
    private $token;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function __construct(RequestDataProvider $requestDataProvider, Csrf $csrf)
    {
        $this->post = $requestDataProvider->getPost();
        $this->get = $requestDataProvider->getGet();
        $this->server = $requestDataProvider->getServer();
        $this->cookie = $requestDataProvider->getCookies();
        $this->csrf = $csrf;

        $this->init();
    }

    private function init()
    {
        $this->determineMethod();
        $this->determineParams();
        $this->initCSRFProtection();
    }

    private function initCSRFProtection()
    {
        if (!$this->isPost() && !$this->csrf->hasCSRF()) {
            $this->token = $this->csrf->initCSRF();
        } elseif($this->isPost() && !$this->csrf->isValidCSRF($this->params['csrf'])) {
            throw new SecurityException();
        }

        unset($this->params['csrf']);
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
    public function hasCookie(string $cookieName, $userId = null) : bool
    {
        $cookie = $this->getCookie($cookieName);

        return ($userId === null && $cookie !== $userId) || ($userId !== null && $cookie === $userId);
    }
}
