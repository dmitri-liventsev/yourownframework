<?php

namespace Test\YourOwnFramework\Request;

use PHPUnit\Framework\TestCase;
use YourOwnFramework\Exception\SecurityException;
use YourOwnFramework\Request\Csrf;
use YourOwnFramework\Request\Request;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class RequestTest extends TestCase
{
    public function testIsPostTrue()
    {
        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'getCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('isValidCSRF')->willReturn(true);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'POST']);

        $this->assertTrue($request->isPost());
    }

    public function testIsPostFalse()
    {
        $csrfMock =  $this->getMockBuilder(Csrf::class)->setMethods(['initCSRF', 'hasCSRF'])->disableOriginalConstructor()->getMock();
        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'GET']);

        $this->assertFalse($request->isPost());
    }

    public function testGetTokenInitToken()
    {
        $expectedToken = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['initCSRF', 'hasCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('hasCSRF')->willReturn(false);
        $csrfMock->expects($this->once())->method('initCSRF')->willReturn($expectedToken);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'GET']);

        $this->assertEquals($expectedToken, $request->getToken());
    }

    public function testGetTokenExistedToken()
    {
        $expectedToken = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['hasCSRF', 'getCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('hasCSRF')->willReturn(true);
        $csrfMock->expects($this->once())->method('getCSRF')->willReturn($expectedToken);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'GET']);

        $this->assertEquals($expectedToken, $request->getToken());
    }

    public function testCSRFProtection()
    {
        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('isValidCSRF')->willReturn(false);

        $this->expectException(SecurityException::class);
        new Request($csrfMock, ['REQUEST_METHOD' => 'POST'], [Csrf::CSRF_TOKEN_KEY => 'token']);
    }

    public function testCSRFProtectionValidCSRFShouldBeUnset()
    {
        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'getCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('isValidCSRF')->willReturn(true);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'POST'], [Csrf::CSRF_TOKEN_KEY => 'token']);

        $this->assertNull($request->get(Csrf::CSRF_TOKEN_KEY));
    }

    public function testGetAllGETParam()
    {
        $expectedParam = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'hasCSRF', 'initCSRF'])->disableOriginalConstructor()->getMock();
        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'GET'], [], ['param' => $expectedParam]);

        $this->assertEquals($request->get(), ['param' => $expectedParam]);
    }

    public function testGetGETParam()
    {
        $expectedParam = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'hasCSRF', 'initCSRF'])->disableOriginalConstructor()->getMock();
        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'GET'], [], ['param' => $expectedParam]);

        $this->assertEquals($request->get('param'), $expectedParam);
    }

    public function testGetAllPOSTParam()
    {
        $expectedParam = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'getCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('isValidCSRF')->willReturn(true);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'POST'], [Csrf::CSRF_TOKEN_KEY => 'token', 'param' => $expectedParam]);

        $this->assertEquals($request->get(), ['param' => $expectedParam]);
    }

    public function testGetPOSTParam()
    {
        $expectedParam = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'getCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('isValidCSRF')->willReturn(true);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'POST'], [Csrf::CSRF_TOKEN_KEY => 'token', 'param' => $expectedParam]);

        $this->assertEquals($request->get('param'), $expectedParam);
    }

    public function testGetMergePOSTAndGET()
    {
        $expectedParam = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'getCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('isValidCSRF')->willReturn(true);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'POST'], [Csrf::CSRF_TOKEN_KEY => 'token', 'param' => $expectedParam], ['param' => 'wrong']);

        $this->assertEquals($request->get('param'), $expectedParam);
    }

    public function testGetAllMergedPOSTAndGET()
    {
        $expectedParam = 'trololo';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'getCSRF'])->disableOriginalConstructor()->getMock();
        $csrfMock->expects($this->once())->method('isValidCSRF')->willReturn(true);

        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'POST'], [Csrf::CSRF_TOKEN_KEY => 'token', 'param' => $expectedParam], ['param' => 'wrong']);

        $this->assertEquals($request->get(), ['param' => $expectedParam]);
    }

    public function testGetIp()
    {
        $expectedIp = '127.0.0.1';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'hasCSRF', 'initCSRF'])->disableOriginalConstructor()->getMock();
        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'GET', 'REMOTE_ADDR' => $expectedIp]);

        $this->assertEquals($request->getIp(), $expectedIp);
    }

    public function testGetCookie()
    {
        $expectedCookie = '123';

        $csrfMock = $this->getMockBuilder(Csrf::class)->setMethods(['isValidCSRF', 'hasCSRF', 'initCSRF'])->disableOriginalConstructor()->getMock();
        $request = new Request($csrfMock, ['REQUEST_METHOD' => 'GET'], [], [], ['cookie' => $expectedCookie]);

        $this->assertEquals($request->getCookie('cookie'), $expectedCookie);
    }
}
