<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use App\Model\Entity\Profile;
use App\Model\Repository\ProfileRepository;
use App\Service\ProfileEdit;
use App\Service\ProfileGet;
use YourOwnFramework\Controller;
use YourOwnFramework\Exception\HttpNotFoundException;
use YourOwnFramework\Exception\HttpUnauthorized;
use YourOwnFramework\Request\Request;

class ProfileController extends Controller
{
    const COMMON_AMOUNT_OF_SECONDS_PER_DAY = 86400;

    const UIC_COOKIE_DELIMITER = ",user_id:";

    const UIC_COOKIE_NAME = 'zdesBylMurzik';

    /**
     * @param Request $request
     * @throws HttpNotFoundException
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $this->template = 'Profile/profile';

        $userId = $request->get('id') ?? $this->auth->getUserId();

        $isUic = !$this->isUic($request, $userId);
        if ($isUic) {
            $newCookieValue = $request->getCookie(self::UIC_COOKIE_NAME) . self::UIC_COOKIE_DELIMITER . $userId;
            $this->setCookie(self::UIC_COOKIE_NAME, $newCookieValue, self::COMMON_AMOUNT_OF_SECONDS_PER_DAY);
        }

        /** @var ProfileGet $service */
        $service = $this->get(ProfileGet::CONTAINER_KEY_EXECUTOR);

        return $service->execute(['userId' => $userId, 'isUic' => $isUic]);
    }

    /**
     * @param Request $request
     *
     * @throws HttpUnauthorized
     * @return array
     */
    public function editAction(Request $request)
    {
        if (!$this->auth->getUserId()) {
            throw new HttpUnauthorized();
        }

        $this->template = 'Profile/editprofile';

        $newProfileDetails = null;
        if ($request->isPost()) {
            $newProfileDetails = $request->get();
        }

        /** @var ProfileEdit $service */
        $service = $this->get(ProfileEdit::CONTAINER_KEY_EXECUTOR);

        return $service->execute(['userId' => $this->auth->getUserId(), 'newProfileDetails' => $newProfileDetails]);
    }

    /**
     * @param Request $request
     *
     * @throws HttpUnauthorized
     * @return array
     */
    public function jsonAction(Request $request)
    {
        if (!$this->auth->getUserId()) {
            throw new HttpUnauthorized();
        }

        $this->layout = 'blank';
        $this->template = 'json';

        $profileRepository = $this->get(ProfileRepository::CONTAINER_KEY);
        /** @var Profile $profile */
        $profile = $profileRepository->findActiveProfileByUserId($this->auth->getUserId());
        $details = $profile->getDetails();
        $details = json_decode($details, true);
        $details['id'] = $profile->getId();

        $details = json_encode($details);

        return ['json' => $details];
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return bool
     */
    private function isUic(Request $request, $userId) : bool
    {
        $cookie = $request->getCookie(self::UIC_COOKIE_NAME);
        $searchSubstring = self::UIC_COOKIE_DELIMITER . $userId;

        return strpos($cookie, $searchSubstring) !== false;
    }
}
