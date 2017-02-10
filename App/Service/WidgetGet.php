<?php

namespace App\Service;

use App\Model\Entity\Profile;
use App\Model\Entity\Widget;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use ServiceExecutor\ServiceInterface;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class WidgetGet implements ServiceInterface
{
    const CONTAINER_KEY = "service.widget.get";
    const CONTAINER_KEY_EXECUTOR = "service.widget.get.executor";

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

        $activeProfiles = $this->profileRepository->findAllActive();
        $activeProfilesDetailsArray = [];
        /** @var Profile $profile */
        foreach($activeProfiles  as $profile) {
            $activeProfilesArray[$profile->getUserId()] = json_decode($profile->getDetails());
        }

        $widgetArrays = [];
        $widgets = $this->widgetRepository->findAllWidgets();

        /** @var Widget $widget */
        foreach($widgets as $widget) {
            $widgetArray = $widget->getParams();
            $widgetArray['profileDetails'] = $widget[$profile->getUserId()] ?? [];

            $widgetArrays[$profile->getId()] = $widgetArray;
        }

        return ["widgets" => $widgetArrays];
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