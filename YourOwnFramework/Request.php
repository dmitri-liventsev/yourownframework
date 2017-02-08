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
    private $params;

    /**
     * @var string
     */
    private $method;


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

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }


}
