<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

use DI\Container;

class Controller implements ControllerInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var Container
     */
    private $container;
    /**
     * @param array $config
     * @return void
     */

    private $template = 'default';

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param Container $container
     * @return void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getTemplatePath() : string
    {
        return ROOT . $this->config['templatePath'] . $this->template . '.php';
    }

    /**
     * @param string $actionMethodName
     * @return mixed
     */
    public function callAction(string $actionMethodName)
    {
        $result = $this->$actionMethodName() ?? [];

        return $result;
    }
}
