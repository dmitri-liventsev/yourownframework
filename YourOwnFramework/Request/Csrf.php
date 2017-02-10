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
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return string | null
     */
    public function getCSRF()
    {
        return $this->session->get(self::CSRF_TOKEN_KEY);
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
        $this->session->set(self::CSRF_TOKEN_KEY, $token);

        return $token;
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function isValidCSRF(string $token) : bool
    {
        return $this->getCSRF() == $token;
    }
}