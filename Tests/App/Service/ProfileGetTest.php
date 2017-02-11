<?php

namespace Tests\App\Service;

use App\Model\Entity\Profile;
use App\Model\Entity\Widget;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use App\Service\ProfileGet;
use PHPUnit\Framework\TestCase;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class ProfileGetTest extends TestCase
{
    public function testExecuteNotUicDoNotIncreaseCounter()
    {
        $userId = 100500;

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['increaseViewCount', 'save', 'increaseUic'])->getMock();
        $widgetMock->expects($this->once())->method('increaseViewCount');
        $widgetMock->expects($this->never())->method('increaseUic');

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn('{param: "value"}');

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods([
                'findActiveProfileByUserId',
                'findAllOldProfilesByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllOldProfilesByUserId')->willReturn([$profileMock]);

        $profileGet = new ProfileGet();
        $profileGet->setProfileRepository($profileRepositoryMock);
        $profileGet->setWidgetRepository($widgetRepository);
        $profileGet->setDb($dbMock);

        $profileGet->execute(['userId' => $userId, 'isUic' => false]);
    }

    public function testExecuteIsUicDoIncreaseCounter()
    {
        $userId = 100500;

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['increaseViewCount', 'save', 'increaseUic'])->getMock();
        $widgetMock->expects($this->once())->method('increaseViewCount');
        $widgetMock->expects($this->once())->method('increaseUic');

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn('{param: "value"}');

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods([
                'findActiveProfileByUserId',
                'findAllOldProfilesByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllOldProfilesByUserId')->willReturn([$profileMock]);

        $profileGet = new ProfileGet();
        $profileGet->setProfileRepository($profileRepositoryMock);
        $profileGet->setWidgetRepository($widgetRepository);
        $profileGet->setDb($dbMock);

        $profileGet->execute(['userId' => $userId, 'isUic' => true]);
    }

    public function testExecuteCheckProfile()
    {
        $userId = 100500;

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['increaseViewCount', 'save', 'increaseUic'])->getMock();
        $widgetMock->expects($this->once())->method('increaseViewCount');
        $widgetMock->expects($this->never())->method('increaseUic');

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn('{param: "value"}');

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods([
                'findActiveProfileByUserId',
                'findAllOldProfilesByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllOldProfilesByUserId')->willReturn([$profileMock]);

        $profileGet = new ProfileGet();
        $profileGet->setProfileRepository($profileRepositoryMock);
        $profileGet->setWidgetRepository($widgetRepository);
        $profileGet->setDb($dbMock);

        $result = $profileGet->execute(['userId' => $userId, 'isUic' => false]);

        $this->assertEquals($profileMock, $result['profile']);
    }

    public function testExecuteCheckVersions()
    {
        $userId = 100500;

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['increaseViewCount', 'save', 'increaseUic'])->getMock();
        $widgetMock->expects($this->once())->method('increaseViewCount');
        $widgetMock->expects($this->never())->method('increaseUic');

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn('{param: "value"}');

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods([
                'findActiveProfileByUserId',
                'findAllOldProfilesByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllOldProfilesByUserId')->willReturn([$profileMock]);

        $profileGet = new ProfileGet();
        $profileGet->setProfileRepository($profileRepositoryMock);
        $profileGet->setWidgetRepository($widgetRepository);
        $profileGet->setDb($dbMock);

        $result = $profileGet->execute(['userId' => $userId, 'isUic' => false]);

        $this->assertEquals([$profileMock], $result['profileVersions']);
    }

    public function testExecuteCheckProfileDetails()
    {
        $userId = 100500;
        $expectedDetails = ['param' => 'value'];
        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['increaseViewCount', 'save', 'increaseUic'])->getMock();
        $widgetMock->expects($this->once())->method('increaseViewCount');
        $widgetMock->expects($this->never())->method('increaseUic');

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn(json_encode($expectedDetails));

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods([
                'findActiveProfileByUserId',
                'findAllOldProfilesByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllOldProfilesByUserId')->willReturn([$profileMock]);

        $profileGet = new ProfileGet();
        $profileGet->setProfileRepository($profileRepositoryMock);
        $profileGet->setWidgetRepository($widgetRepository);
        $profileGet->setDb($dbMock);

        $result = $profileGet->execute(['userId' => $userId, 'isUic' => false]);

        $this->assertEquals($expectedDetails, $result['profileDetails']);
    }
}
