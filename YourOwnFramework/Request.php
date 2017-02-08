<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;


class Request
{
    const CONTAINER_REQUEST = 'request';

    /**
     * @var array
     */
    private $params;

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
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
}
