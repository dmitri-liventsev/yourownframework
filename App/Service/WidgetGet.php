<?php

namespace App\Service;

use App\Model\Entity\Profile;
use App\Model\Entity\Widget;
use ServiceExecutor\ServiceInterface;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class WidgetGet extends BaseService implements ServiceInterface
{
    const CONTAINER_KEY = "service.widget.get";
    const CONTAINER_KEY_EXECUTOR = "service.widget.get.executor";

    /**
     * @param array $params
     * @return array
     */
    public function execute(array $params) : array
    {

        $activeProfiles = $this->profileRepository->findAllActive();
        $activeProfilesDetailsArray = [];
        /** @var Profile $profile */
        foreach($activeProfiles  as $profile) {
            $activeProfilesDetailsArray[$profile->getUserId()] = json_decode($profile->getDetails(), true);
        }

        $widgetArrays = [];
        $widgets = $this->widgetRepository->findAllWidgets();

        /** @var Widget $widget */
        foreach($widgets as $widget) {
            $widgetArray = $widget->getParams();
            $widgetArray['profileDetails'] = $activeProfilesDetailsArray[$widget->getUserId()] ?? [];

            $widgetArrays[$widget->getId()] = $widgetArray;
        }

        return ["widgets" => $widgetArrays];
    }
}