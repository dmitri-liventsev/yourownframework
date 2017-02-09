<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace App\Controller;

use App\Model\Entity\Profile;
use App\Model\Repository\ProfileRepository;
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
        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        $activeProfiles = $profileRepository->findAllActive();

        $profileArrays = [];
        /** @var Profile $profile */
        foreach($activeProfiles as $profile) {
            $statistics = $profileRepository->getProfileStatisticsByUserId($profile->getUserId());
            $profileArrays[$profile->getId()] = $profile->getParams();
            $profileArrays['statistics'] = $statistics;
        }

        $this->layout = 'widget';
        $this->template = 'widget';

        return ["activeProfiles" => $profileArrays];
    }
}