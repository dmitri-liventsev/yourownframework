<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace App\Controller;

use App\Model\Repository\ProfileRepository;
use YourOwnFramework\Controller;
use YourOwnFramework\Request;

class WidgetController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $this->layout = 'widget';
        $this->template = 'widget';

        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        $activeProfiles = $profileRepository->findAllActive();

        return ["activeProfiles" => $activeProfiles];
    }
}