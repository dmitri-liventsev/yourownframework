<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use App\Model\Repository\ProfileRepository;
use YourOwnFramework\Controller;
use YourOwnFramework\Request;

class ProfileController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $this->template = 'form';

        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        $profile = $profileRepository->findActiveProfileByUserId($this->auth->getUserId());

        if ($request->isPost()) {
            $profile->delete();
            $profile->save();

            $profile = $profileRepository->clone($profile);
            $profile->setDetails(json_encode($request->getParams()));
            $profile->save();
        }

        $allProfiles = $profileRepository->findAllByUserId($this->auth->getUserId());
        $profileData = json_decode($profile->getDetails(), true) ?? [];

        return [
            'profileData' => $profileData,
            'profile' => $profile,
            'allProfile' => $allProfiles,
        ];
    }
}
