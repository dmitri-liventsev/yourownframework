<?php
namespace App\Service;

use App\Model\Entity\Profile;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use ServiceExecutor\ServiceInterface;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileEdit implements ServiceInterface
{
    const CONTAINER_KEY = "service.profile.edit";
    const CONTAINER_KEY_EXECUTOR = "service.profile.edit.executor";

    /**
     * @var WidgetRepository
     */
    private $widgetRepository;

    /**
     * @var ProfileRepository
     */
    private $profileRepository;

    /**
     * @param array $params
     * @return array
     */
    public function execute(array $params)
    {
        $profileId = $params['profileId'];
        $newProfileDetails = $params['newProfileDetails'];

        /** @var Profile $profile */
        $profile = $this->profileRepository->findOneById($profileId);

        if ($newProfileDetails !== null) {
            $widget = $this->widgetRepository->findByUserId($profile->getUserId());


            $profile->setIsActive(0);
            $profile->save();

            $profile = $this->profileRepository->clone($profile);
            $profile->setDetails(json_encode($newProfileDetails));
            $profile->setIsActive(1);
            $profile->setStatus(Profile::STATUS_NOT_CHECKED);

            $profile->save();

            $widget->setLastStatus(Profile::STATUS_NOT_CHECKED);
            $widget->save();
        }

        $profileVersions = $this->profileRepository->findAllByUserId($profile->getUserId());
        $profileData = json_decode($profile->getDetails(), true) ?? [];

        $this->template = 'editprofile';

        return [
            'profileData' => $profileData,
            'profile' => $profile,
            'profileVersions' => $profileVersions,
        ];
    }

    /**
     * @param WidgetRepository $widgetRepository
     */
    public function setWidgetRepository(WidgetRepository $widgetRepository)
    {
        $this->widgetRepository = $widgetRepository;
    }

    /**
     * @param ProfileRepository $profileRepository
     */
    public function setProfileRepository(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }


}