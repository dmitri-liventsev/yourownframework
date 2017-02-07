<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

use YourOwnFramework\Exception\HttpNotFoundException;

class Router
{
    const CONTROLLER = 'controller';
    const ACTION = 'action';
    const CONTAINER_ROUTER = 'router';

    /**
     * @return array
     * @throws HttpNotFoundException
     */
    public function getRoute() : array
    {
        $URI = $this->getURI();
        $route = $this->findRoute($URI);

        if (!method_exists($route[self::CONTROLLER], $route[self::ACTION])) {
            throw new HttpNotFoundException();
        }

        return $route;
    }

    /**
     * @param string $URI
     * @return array
     */
    private function findRoute(string $URI) : array
    {
        $uri_segments = explode('/', $URI);

        $controllerClassName = $this->getControllerClassName($uri_segments);
        $actionMethodName = $this->getActionMethodName($uri_segments);

        return [
            self::CONTROLLER => $controllerClassName,
            self::ACTION => $actionMethodName,
        ];
    }

    /**
     * @param array $uri_segments
     * @return string
     */
    public function getControllerClassName(array $uri_segments) : string
    {
        $controllerName = !isset($uri_segments[0]) || $uri_segments[0] == ""? 'Index' : $uri_segments[0];
        $controllerClassName = '\\App\Controller\\' . ucfirst(strtolower($controllerName)) . 'Controller';

        return $controllerClassName;
    }

    /**
     * @param array $uri_segments
     * @return string
     */
    public function getActionMethodName(array $uri_segments) : string
    {
        $actionMethodName = !isset($uri_segments[1]) || $uri_segments[1] == ""? 'index' : $uri_segments[1];

        return strtolower($actionMethodName) . 'Action';
    }

    /**
     * @return string
     */
    private function getURI() : string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}

