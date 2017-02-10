<?php

namespace App\Service;

use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use ServiceExecutor\ServiceInterface;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileGet implements ServiceInterface
{
    const CONTAINER_KEY = "service.profile.get";
    const CONTAINER_KEY_EXECUTOR = "service.profile.get.executor";

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
        $userId = $params['userId'];
        $profile = $this->profileRepository->findActiveProfileByUserId($userId);

        $widget = $this->widgetRepository->findByUserId($userId);
        $widget->increaseViewCount();
        if ($params['isUic']) {
            $widget->increaseUic();
        }

        $profileVersions = $this->profileRepository->findAllByUserId($profile->getUserId());

        return [
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