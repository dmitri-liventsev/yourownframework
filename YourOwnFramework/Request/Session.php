<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework\Request;


class Session
{
    const CONTAINER_KEY = 'session';

    /**
     * @param string $key
     * @return null|string
     */
    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set(string $key, string $value)
    {
        $_SESSION[$key] = $value;
    }
}