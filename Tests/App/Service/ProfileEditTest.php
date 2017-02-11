<?php

namespace Tests\App\Service;
use App\Model\Entity\Profile;
use App\Model\Entity\Widget;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use App\Service\ProfileEdit;
use PHPUnit\Framework\TestCase;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class ProfileEditTest extends TestCase
{
    //Without update profile

    public function testExecuteWithoutExtraDetailsCheckDetailsData()
    {
        $expectedDetails = ['param', 'value'];

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn(json_encode($expectedDetails));

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods(
            [
                'findActiveProfileByUserId',
                'findAllByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllByUserId')->willReturn([$profileMock]);

        $profileEdit = new ProfileEdit();
        $profileEdit->setProfileRepository($profileRepositoryMock);
        $result = $profileEdit->execute(['userId' => 1, 'newProfileDetails' => null]);

        $this->assertEquals($expectedDetails, $result['profileData']);
    }

    public function testExecuteWithoutExtraDetailsCheckProfile()
    {
        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn('{param: "value"}');

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods(
            [
                'findActiveProfileByUserId',
                'findAllByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllByUserId')->willReturn([$profileMock]);

        $profileEdit = new ProfileEdit();
        $profileEdit->setProfileRepository($profileRepositoryMock);
        $result = $profileEdit->execute(['userId' => 1, 'newProfileDetails' => null]);

        $this->assertEquals($profileMock, $result['profile']);
    }

    public function testExecuteWithoutExtraDetailsCheckSuccess()
    {
        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails'])->getMock();
        $profileMock->expects($this->once())->method('getDetails')->willReturn('{param: "value"}');

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods(
            [
                'findActiveProfileByUserId',
                'findAllByUserId'
            ]
        )->getMock();
        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllByUserId')->willReturn([$profileMock]);

        $profileEdit = new ProfileEdit();
        $profileEdit->setProfileRepository($profileRepositoryMock);
        $result = $profileEdit->execute(['userId' => 1, 'newProfileDetails' => null]);

        $this->assertFalse($result['success']);
    }

    //With profile update

    public function testExecuteWithExtraDetailsCheckDetailsData()
    {
        $newDetails = ['param', 'new_value'];

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['save'])->getMock();

        $newProfileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails', 'setDetails', 'setIsActive', 'setStatus', 'save'])->getMock();
        $newProfileMock->expects($this->once())->method('getDetails')->willReturn(json_encode($newDetails));
        $newProfileMock->expects($this->once())->method('setDetails')->with(json_encode($newDetails));
        $newProfileMock->expects($this->once())->method('setIsActive')->with(1);
        $newProfileMock->expects($this->once())->method('setStatus')->with(Profile::STATUS_NOT_CHECKED);

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods(
            [
                'findActiveProfileByUserId',
                'findAllByUserId',
                'clone'
            ]
        )->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['setLastStatus', 'save'])->getMock();
        $widgetMock->expects($this->once())->method('setLastStatus')->with(Profile::STATUS_NOT_CHECKED);

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllByUserId')->willReturn([$profileMock]);
        $profileRepositoryMock->expects($this->once())->method('clone')->willReturn($newProfileMock);

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $profileEdit = new ProfileEdit();
        $profileEdit->setProfileRepository($profileRepositoryMock);
        $profileEdit->setWidgetRepository($widgetRepository);
        $profileEdit->setDb($dbMock);

        $result = $profileEdit->execute(['userId' => 1, 'newProfileDetails' => $newDetails]);

        $this->assertEquals($newDetails, $result['profileData']);
    }


    //With profile update

    public function testExecuteWithExtraDetailsCheckProfile()
    {
        $newDetails = ['param', 'new_value'];

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['save'])->getMock();

        $newProfileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails', 'setDetails', 'setIsActive', 'setStatus', 'save'])->getMock();
        $newProfileMock->expects($this->once())->method('getDetails')->willReturn(json_encode($newDetails));
        $newProfileMock->expects($this->once())->method('setDetails')->with(json_encode($newDetails));
        $newProfileMock->expects($this->once())->method('setIsActive')->with(1);
        $newProfileMock->expects($this->once())->method('setStatus')->with(Profile::STATUS_NOT_CHECKED);

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods(
            [
                'findActiveProfileByUserId',
                'findAllByUserId',
                'clone'
            ]
        )->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['setLastStatus', 'save'])->getMock();
        $widgetMock->expects($this->once())->method('setLastStatus')->with(Profile::STATUS_NOT_CHECKED);

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllByUserId')->willReturn([$profileMock]);
        $profileRepositoryMock->expects($this->once())->method('clone')->willReturn($newProfileMock);

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $profileEdit = new ProfileEdit();
        $profileEdit->setProfileRepository($profileRepositoryMock);
        $profileEdit->setWidgetRepository($widgetRepository);
        $profileEdit->setDb($dbMock);

        $result = $profileEdit->execute(['userId' => 1, 'newProfileDetails' => $newDetails]);

        $this->assertEquals($newProfileMock, $result['profile']);
    }

    public function testExecuteWithExtraDetailsCheckSuccess()
    {
        $newDetails = ['param', 'new_value'];

        $profileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['save'])->getMock();

        $newProfileMock = $this->getMockBuilder(Profile::class)->disableOriginalConstructor()->setMethods(['getDetails', 'setDetails', 'setIsActive', 'setStatus', 'save'])->getMock();
        $newProfileMock->expects($this->once())->method('getDetails')->willReturn(json_encode($newDetails));
        $newProfileMock->expects($this->once())->method('setDetails')->with(json_encode($newDetails));
        $newProfileMock->expects($this->once())->method('setIsActive')->with(1);
        $newProfileMock->expects($this->once())->method('setStatus')->with(Profile::STATUS_NOT_CHECKED);

        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)->disableOriginalConstructor()->setMethods(
            [
                'findActiveProfileByUserId',
                'findAllByUserId',
                'clone'
            ]
        )->getMock();

        $widgetMock = $this->getMockBuilder(Widget::class)->disableOriginalConstructor()->setMethods(['setLastStatus', 'save'])->getMock();
        $widgetMock->expects($this->once())->method('setLastStatus')->with(Profile::STATUS_NOT_CHECKED);

        $widgetRepository = $this->getMockBuilder(WidgetRepository::class)->disableOriginalConstructor()->setMethods(['findByUserId'])->getMock();
        $widgetRepository->expects($this->once())->method('findByUserId')->willReturn($widgetMock);

        $profileRepositoryMock->expects($this->once())->method('findActiveProfileByUserId')->willReturn($profileMock);
        $profileRepositoryMock->expects($this->once())->method('findAllByUserId')->willReturn([$profileMock, $newProfileMock]);
        $profileRepositoryMock->expects($this->once())->method('clone')->willReturn($newProfileMock);

        $dbMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->setMethods(['commit', 'beginTransaction'])->getMock();

        $profileEdit = new ProfileEdit();
        $profileEdit->setProfileRepository($profileRepositoryMock);
        $profileEdit->setWidgetRepository($widgetRepository);
        $profileEdit->setDb($dbMock);

        $result = $profileEdit->execute(['userId' => 1, 'newProfileDetails' => $newDetails]);

        $this->assertTrue($result['success']);
    }
}
