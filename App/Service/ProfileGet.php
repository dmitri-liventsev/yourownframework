<?php

namespace App\Service;

use ServiceExecutor\ServiceInterface;
use YourOwnFramework\Exception\ErzatsORMException;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileGet  extends BaseService implements ServiceInterface
{
    const CONTAINER_KEY = "service.profile.get";
    const CONTAINER_KEY_EXECUTOR = "service.profile.get.executor";

    /**
     * @param array $params
     *
     * @throws ErzatsORMException
     * @return array
     */
    public function execute(array $params) : array
    {
        $userId = $params['userId'];
        $profile = $this->profileRepository->findActiveProfileByUserId($userId);

        $widget = $this->widgetRepository->findByUserId($userId);

        try {
            $this->db->beginTransaction();

            $widget->increaseViewCount();
            if ($params['isUic']) {
                $widget->increaseUic();
            }

            $this->db->commit();
        } catch (ErzatsORMException $e) {
            $this->db->rollBack();
            throw $e;
        }

        $profileVersions = $this->profileRepository->findAllOldProfilesByUserId($userId);

        return [
            'profile' => $profile,
            'profileVersions' => $profileVersions,
            'profileDetails' => json_decode($profile->getDetails(), true)
        ];
    }
}