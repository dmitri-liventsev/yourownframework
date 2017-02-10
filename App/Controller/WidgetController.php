<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace App\Controller;

use App\Model\Entity\Profile;
use App\Model\Entity\Widget;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use YourOwnFramework\Controller;
use YourOwnFramework\Request;

class WidgetController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $this->header("Content-Type", "text/javascript");

        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        /** @var WidgetRepository $widgetRepository */
        $widgetRepository = $this->get(WidgetRepository::CONTAINER_KEY);

        $activeProfiles = $profileRepository->findAllActive();
        $activeProfilesDetailsArray = [];
        /** @var Profile $profile */
        foreach($activeProfiles  as $profile) {
            $activeProfilesArray[$profile->getUserId()] = json_decode($profile->getDetails());
        }

        $widgetArrays = [];
        $widgets = $widgetRepository->findAllWidgets();

        /** @var Widget $widget */
        foreach($widgets as $widget) {
            $widgetArray = $widget->getParams();
            $widgetArray['profileDetails'] = $widget[$profile->getUserId()] ?? [];

            $widgetArrays[$profile->getId()] = $widgetArray;
        }

        $this->layout = 'widget';
        $this->template = 'widget';

        return ["widgets" => $widgetArrays];
    }
}