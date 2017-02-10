<?php

namespace Test\YourOwnFramework;

use App\Controller\IndexController;
use PHPUnit\Framework\TestCase;
use YourOwnFramework\Request\Request;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class ControllerTest extends TestCase
{
    public function testCallAction()
    {
        $indexAction = new IndexController();
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $indexAction->setRequest($request);

        $result = $indexAction->callAction('indexAction');

        $this->assertEquals([], $result);
    }
}
