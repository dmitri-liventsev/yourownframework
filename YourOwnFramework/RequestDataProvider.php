<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework;


class RequestDataProvider
{
    /**
     * @return array
     */
    public function getPost()
    {
        return $_POST;
    }

    /**
     * @return array
     */
    public function getGet()
    {
        return $_GET;
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $_SERVER;
    }
}