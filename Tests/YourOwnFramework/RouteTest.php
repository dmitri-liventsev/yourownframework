<?php

namespace Test\YourOwnFramework;

use PHPUnit\Framework\TestCase;
use YourOwnFramework\Router;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class RouteTest extends TestCase
{
    public function testFindRouteWithDefaultController()
    {
        $router = new Router("");
        $controllerName = $router->getControllerClassName([]);

        $this->assertEquals("\App\Controller\IndexController", $controllerName);
    }

    public function testFindRouteWithDefaultMethod()
    {
        $router = new Router("");
        $methodName = $router->getActionMethodName([
            1 => "controler",
        ]);

        $this->assertEquals("indexAction", $methodName);
    }

    public function testFindRouteCheckController()
    {
        $router = new Router("");
        $controllerName = $router->getControllerClassName([1 => "controller"]);

        $this->assertEquals("\App\Controller\ControllerController", $controllerName);
    }

    public function testFindRouteCheckAction()
    {
        $router = new Router("");
        $methodName = $router->getActionMethodName([1 => "controller", 2 => "action"]);

        $this->assertEquals("actionAction", $methodName);
    }
}
