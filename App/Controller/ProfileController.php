<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use App\Model\Entity\Profile;
use App\Model\Entity\Uic;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\UicRepository;
use App\Model\Repository\WidgetRepository;
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
        /** @var WidgetRepository $widgetRepository */
        $widgetRepository = $this->get(WidgetRepository::CONTAINER_KEY);

        /** @var Profile $profile */
        if ($profileId === null) {
            $profile = $profileRepository->findActiveProfileByUserId($this->auth->getUserId());
        } else {
            $profile = $profileRepository->findOneById($profileId);
        }

        $widget = $widgetRepository->findByUserId($this->auth->getUserId());
        $widget->increaseViewCount();
        if (!$request->hasCookie(self::UIC_COOKIE_NAME, $profile->getUserId())) {
            $this->setCookie(self::UIC_COOKIE_NAME, $profile->getUserId(), self::COMMON_AMOUNT_OF_SECONDS_PER_DAY);
            $widget->increaseUic();
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
        /** @var WidgetRepository $widgetRepository */
        $widgetRepository = $this->get(WidgetRepository::CONTAINER_KEY);

        /** @var Profile $profile */
        $profile = $profileRepository->findActiveProfileByUserId($this->auth->getUserId());
        $widget = $widgetRepository->findByUserId($this->auth->getUserId());
        if ($request->isPost()) {
            $profile->setIsActive(0);
            $profile->save();

            $profile = $profileRepository->clone($profile);
            $profile->setDetails(json_encode($request->getParams()));
            $profile->setIsActive(1);
            $profile->setStatus(Profile::STATUS_NOT_CHECKED);

            $profile->save();

            $widget->setLastStatus(Profile::STATUS_NOT_CHECKED);
            $widget->save();
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
