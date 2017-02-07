<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

use Delight\Auth\Auth;
use DI\Container;

interface ControllerInterface
{
    /**
     * @param array $config
     * @return void
     */
    public function setConfig(array $config);

    /**
     * @param Container $container
     * @return void
     */
    public function setContainer(Container $container);

    /**
     * @return string
     */
    public function getTemplatePath() : string;

    /**
     * @param string $actionMethodName
     * @return mixed
     */
    public function callAction(string $actionMethodName);

    /**
     * @param Auth $auth
     * @return void
     */
    public function setAuth(Auth $auth);

    /**
     * @param Request $auth
     * @return void
     */
    public function setRequest(Request $auth);

}
