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
     * @var string
     */
    private $method;

    public function __construct(RequestDataProvider $requestDataProvider)
    {
        $this->post = $requestDataProvider->getPost();
        $this->get = $requestDataProvider->getGet();
        $this->server = $requestDataProvider->getServer();

        $this->init();
    }

    private function init()
    {
        $this->determineMethod();
        $this->determineParams();
    }

    /**
     * @param string $fieldName
     * @return null
     */
    public function get(string $fieldName)
    {
        return $this->params[$fieldName] ?? null;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
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

    /**
     * @return array
     */
    public function determineParams()
    {
        $this->params = $this->post + $this->get;
    }
}
