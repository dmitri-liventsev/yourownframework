<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace YourOwnFramework\Request;

class Csrf
{
    const CONTAINER_KEY = 'csrf';

    const CSRF_TOKEN_KEY = 'csrf';

    /**
     * @return string | null
     */
    public function getCSRF()
    {
        return $_SESSION[self::CSRF_TOKEN_KEY] ?? null;
    }

    /**
     * @return bool
     */
    public function hasCSRF() : bool
    {
        return $this->getCSRF() !== null;
    }

    /**
     * @return string
     */
    public function initCSRF() : string
    {
        $token = md5(uniqid(rand(), TRUE));
        $_SESSION[self::CSRF_TOKEN_KEY] = $token;

        return $token;
    }


    /**
     * @param string $token
     *
     * @return bool
     */
    public function isValidCSRF(string $token) : bool
    {
        return $_SESSION['csrf'] == $token;
    }
}