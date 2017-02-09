<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use App\Model\Entity\Profile;
use App\Model\Entity\Uic;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\UicRepository;
use YourOwnFramework\Controller;
use YourOwnFramework\Exception\HttpNotFoundException;
use YourOwnFramework\Request;

class ProfileController extends Controller
{
    const COMMON_AMOUNT_OF_SECONDS_PER_DAY = 86400;

    const UIC_COOKIE_NAME = 'zdesBylMurzik';

    /**
     * @param Request $request
     * @throws HttpNotFoundException
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $profileId = $request->get('id');
        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        /** @var UicRepository $uicRepository */
        $uicRepository = $this->get(UicRepository::CONTAINER_KEY);

        /** @var Profile $profile */
        if ($profileId === null) {
            $profile = $profileRepository->findActiveProfileByUserId($this->auth->getUserId());
        } else {
            $profile = $profileRepository->findOneById($profileId);
        }

        $profile->increaseViewCount();
        $ip = $request->getIp();

        if (!$request->hasCookie(self::UIC_COOKIE_NAME, $profile->getUserId()) && $uicRepository->isUnique($ip, $profileId)) {
            $this->setCookie(self::UIC_COOKIE_NAME, $profile->getUserId(), self::COMMON_AMOUNT_OF_SECONDS_PER_DAY);
            $profile->increaseUic();
            /** @var Uic $uic */
            $uic = $uicRepository->create();
            $uic->setIp($ip);
            $uic->setProfileId($profileId);
            $uic->save();
        }

        $this->template = 'profile';

        return ['profile' => $profile];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function editAction(Request $request)
    {
        /** @var ProfileRepository $profileRepository */
        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        /** @var Profile $profile */
        $profile = $profileRepository->findActiveProfileByUserId($this->auth->getUserId());

        if ($request->isPost()) {
            $profile->setIsActive(0);
            $profile->save();

            $profile = $profileRepository->clone($profile);
            $profile->setDetails(json_encode($request->getParams()));
            $profile->setIsActive(1);
            $profile->setStatus(Profile::STATUS_NOT_CHECKED);

            $profile->save();
        }

        $allProfiles = $profileRepository->findAllByUserId($this->auth->getUserId());
        $profileData = json_decode($profile->getDetails(), true) ?? [];

        $this->template = 'editprofile';

        return [
            'profileData' => $profileData,
            'profile' => $profile,
            'allProfile' => $allProfiles,
        ];
    }
}
