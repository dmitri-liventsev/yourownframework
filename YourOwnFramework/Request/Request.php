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

    public function __construct(Csrf $csrf, array $server, array $get, array $post)
    {
        $this->csrf = $csrf;
        $this->server = $server;
        $this->get = $get;
        $this->post = $post;

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
        } elseif($this->isPost() && !$this->csrf->isValidCSRF($this->params[Csrf::CSRF_TOKEN_KEY])) {
            throw new SecurityException();
        } elseif($this->token === null) {
            $this->token = $this->csrf->getCSRF();
        }

        unset($this->params[Csrf::CSRF_TOKEN_KEY]);
    }

    /**
     * @param string|null $fieldName
     *
     * @return null|int|string|array
     */
    public function get($fieldName = null)
    {
        return $fieldName !== null? $this->params : $this->params[$fieldName] ?? null;
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

    private function determineParams()
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
     * @param array $cookie
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }
}
