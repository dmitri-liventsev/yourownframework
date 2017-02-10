<?php
namespace App\Service;

use App\Model\Entity\Profile;
use ServiceExecutor\ServiceInterface;
use YourOwnFramework\Exception\ErzatsORMException;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileEdit extends BaseService implements ServiceInterface
{
    const CONTAINER_KEY = "service.profile.edit";
    const CONTAINER_KEY_EXECUTOR = "service.profile.edit.executor";

    /**
     * @param array $params
     *
     * @throws ErzatsORMException
     * @return array
     */
    public function execute(array $params)
    {
        $profileId = $params['profileId'];
        $newProfileDetails = $params['newProfileDetails'];

        /** @var Profile $profile */
        $profile = $this->profileRepository->findOneById($profileId);

        if ($newProfileDetails !== null) {
            $widget = $this->widgetRepository->findByUserId($profile->getUserId());


            $profile->setIsActive(0);

            $newProfile = $this->profileRepository->clone($profile);
            $newProfile->setDetails(json_encode($newProfileDetails));
            $newProfile->setIsActive(1);
            $newProfile->setStatus(Profile::STATUS_NOT_CHECKED);

            $widget->setLastStatus(Profile::STATUS_NOT_CHECKED);

            try {
                $this->db->beginTransaction();

                $profile->save();
                $newProfile->save();
                $widget->save();

                $this->db->commit();
            } catch(ErzatsORMException $e) {
                $this->db->rollBack();
                throw $e;
            }


            $profile = $newProfile;
        }

        $profileVersions = $this->profileRepository->findAllByUserId($profile->getUserId());
        $profileData = json_decode($profile->getDetails(), true) ?? [];

        $this->template = 'editprofile';

        return [
            'profileData' => $profileData,
            'profile' => $profile,
            'profileVersions' => $profileVersions,
        ];
    }
}