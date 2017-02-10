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
    public function execute(array $params) : array
    {
        $profileId = $params['profileId'];
        $newProfileDetails = $params['newProfileDetails'];

        /** @var Profile $profile */
        $profile = $this->profileRepository->findOneById($profileId);

        $success = false;
        if ($newProfileDetails !== null) {
            $profile = $this->updateProfile($profile, $newProfileDetails);
            $success = true;
        }

        $profileVersions = $this->profileRepository->findAllByUserId($profile->getUserId());
        $profileData = json_decode($profile->getDetails(), true) ?? [];

        $this->template = 'editprofile';

        return [
            'profileData' => $profileData,
            'profile' => $profile,
            'profileVersions' => $profileVersions,
            'success' => $success
        ];
    }

    /**
     * @param Profile $profile
     * @param $newProfileDetails
     *
     * @return Profile
     * @throws ErzatsORMException
     */
    private function updateProfile(Profile $profile, $newProfileDetails) : Profile
    {
        $widget = $this->widgetRepository->findByUserId($profile->getUserId());
        $profile->setIsActive(0);
        /** @var Profile $newProfile */
        $newProfile = $this->buildNewProfile($profile, $newProfileDetails);
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

        return $newProfile;
    }

    /**
     * @param Profile $profile
     * @param $newProfileDetails
     *
     * @return Profile
     */
    private function buildNewProfile(Profile $profile, $newProfileDetails) : Profile
    {
        /** @var Profile $newProfile */
        $newProfile = $this->profileRepository->clone($profile);
        $newProfile->setDetails(json_encode($newProfileDetails));
        $newProfile->setIsActive(1);
        $newProfile->setStatus(Profile::STATUS_NOT_CHECKED);

        return $newProfile;
    }
}