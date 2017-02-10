<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use App\Service\ProfileEdit;
use App\Service\ProfileGet;
use YourOwnFramework\Controller;
use YourOwnFramework\Exception\HttpNotFoundException;
use YourOwnFramework\Request\Csrf;
use YourOwnFramework\Request\Request;

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
        $this->template = 'profile';

        $userId = $request->get('id') ?? $this->auth->getUserId();

        $isUic = !$request->hasCookie(self::UIC_COOKIE_NAME, $userId);
        if ($isUic) {
            $this->setCookie(self::UIC_COOKIE_NAME, $userId, self::COMMON_AMOUNT_OF_SECONDS_PER_DAY);
        }

        /** @var ProfileGet $service */
        $service = $this->get(ProfileGet::CONTAINER_KEY_EXECUTOR);

        return $service->execute(['userId' => $userId, 'isUic' => $isUic]);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function editAction(Request $request)
    {
        $newProfileDetails = null;
        if ($request->isPost()) {
            $newProfileDetails = $request->getParams();
        }

        $this->template = 'editprofile';

        /** @var ProfileEdit $service */
        $service = $this->get(ProfileEdit::CONTAINER_KEY_EXECUTOR);

        return $service->execute(
            [
                'userId' => $this->auth->getUserId(),
                'newProfileDetails' => $newProfileDetails
            ]
        ) + [
            Csrf::CSRF_TOKEN_KEY => $request->getToken()
        ];
    }
}
