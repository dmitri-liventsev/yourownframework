<?php

namespace Tests\App\Service;

use App\Model\Entity\Profile;
use App\Model\Entity\Widget;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use App\Service\WidgetGet;
use PHPUnit\Framework\TestCase;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class WidgetGetTest extends TestCase
{
    public function testExecute()
    {
        $userId = 100500;
        $expectedDetails = ['param' => 'value'];
        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['getParams', 'getUserId', 'getId'])->getMock();
        $widgetMock->expects($this->once())->method('getParams')->willReturn(['id' => '123']);
        $widgetMock->expects($this->once())->method('getUserId')->willReturn($userId);
        $widgetMock->expects($this->once())->method('getId')->willReturn(123);

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findAllWidgets'])->getMock();
        $widgetRepository->expects($this->once())->method('findAllWidgets')->willReturn([$widgetMock]);

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails', 'getUserId'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn(json_encode($expectedDetails));
        $profileMock->expects($this->once())->method('getUserId')->willReturn($userId);

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findAllActive'])
            ->getMock();
        $profileRepositoryMock->expects($this->once())->method('findAllActive')->willReturn([$profileMock]);

        $widgetGet = new WidgetGet();
        $widgetGet->setProfileRepository($profileRepositoryMock);
        $widgetGet->setWidgetRepository($widgetRepository);
        $widgetGet->setDb($dbMock);

        $result = $widgetGet->execute([]);

        $this->assertEquals([123 => ['id' => '123', 'profileDetails' => $expectedDetails]], $result['widgets']);
    }
}
