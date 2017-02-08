<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use App\Model\Repository\ProfileRepository;
use YourOwnFramework\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
        $this->template = 'form';

        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);

        $profile = $profileRepository->findActiveProfileByUserId($this->auth->getUserId());
        $allProfiles = $profileRepository->findAllByUserId($this->auth->getUserId());

        $profileData = json_decode($profile->getDetails(), true) ?? [];

        return [
            'profile' => $profileData,
            'allProfile' => $allProfiles,
        ];
    }
}
