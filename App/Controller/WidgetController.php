<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace App\Controller;

use App\Model\Repository\ProfileRepository;
use YourOwnFramework\Controller;

class WidgetController extends Controller
{
    public function indexAction()
    {
        $this->layout = 'widget';
        $this->template = 'widget';

        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        $activeProfiles = $profileRepository->findAllActive();

        return ["activeProfiles" => $activeProfiles];
    }
}