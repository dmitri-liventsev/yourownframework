<?php


namespace Test\YourOwnFramework\Request;

use PHPUnit\Framework\TestCase;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class CsrfTest extends TestCase
{
    public function testGetCSRF()
    {
        $token = 'trololo';
        $sessionMock = $this->getMockBuilder(\YourOwnFramework\Request\Session::class)->setMethods(['get'])->getMock();
        $sessionMock->expects($this->once())->method('get')->willReturn($token);

        $csrf =  new \YourOwnFramework\Request\Csrf($sessionMock);
        $this->assertEquals($token, $csrf->getCSRF());
    }

    public function testHasCSRFTrue()
    {
        $token = 'trololo';
        $sessionMock = $this->getMockBuilder(\YourOwnFramework\Request\Session::class)->setMethods(['get'])->getMock();
        $sessionMock->expects($this->once())->method('get')->willReturn($token);

        $csrf =  new \YourOwnFramework\Request\Csrf($sessionMock);
        $this->assertTrue($csrf->hasCSRF());
    }

    public function testHasCSRFFalse()
    {
        $sessionMock = $this->getMockBuilder(\YourOwnFramework\Request\Session::class)->setMethods(['get'])->getMock();
        $sessionMock->expects($this->once())->method('get')->willReturn(null);

        $csrf =  new \YourOwnFramework\Request\Csrf($sessionMock);
        $this->assertFalse($csrf->hasCSRF());
    }

    public function testInitCSRF()
    {
        $sessionMock = $this->getMockBuilder(\YourOwnFramework\Request\Session::class)->setMethods(['set'])->getMock();
        $sessionMock->expects($this->once())->method('set');

        $csrf =  new \YourOwnFramework\Request\Csrf($sessionMock);
        $csrf->initCSRF();
    }

    public function testIsValidCSRFTrue()
    {
        $token = 'trololo';
        $sessionMock = $this->getMockBuilder(\YourOwnFramework\Request\Session::class)->setMethods(['get'])->getMock();
        $sessionMock->expects($this->once())->method('get')->willReturn($token);

        $csrf =  new \YourOwnFramework\Request\Csrf($sessionMock);
        $this->assertTrue($csrf->isValidCSRF($token));
    }

    public function testIsValidCSRFFalse()
    {
        $token = 'trololo';
        $sessionMock = $this->getMockBuilder(\YourOwnFramework\Request\Session::class)->setMethods(['get'])->getMock();
        $sessionMock->expects($this->once())->method('get')->willReturn($token);

        $csrf =  new \YourOwnFramework\Request\Csrf($sessionMock);
        $this->assertFalse($csrf->isValidCSRF('wrong'));
    }

}
