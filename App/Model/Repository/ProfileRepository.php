<?php

namespace App\Model\Repository;

use App\Model\Entity\Profile;
use YourOwnFramework\Db\Repository;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileRepository extends Repository
{
    const CONTAINER_KEY = 'repository.profile';

    /**
     * @var string
     */
    protected $table = 'profile';

    /**
     * @return \YourOwnFramework\Db\ErzatsORMInterface[]
     */
    public function findAllNotChecked()
    {
        $where = [
            'status = :status',
            'deletedAt IS NULL'
        ];
        $params = ['status' => Profile::STATUS_NOT_CHECKED];

        return $this->findAll($where, $params);
    }

    /**
     * @param $userId
     *
     * @return \YourOwnFramework\Db\ErzatsORMInterface[]
     */
    public function findAllByUserId($userId)
    {
        $where = [
            'userId = :userId',
            'deletedAt IS NULL'
        ];
        $params = ['userId' => $userId];

        return $this->findAll($where, $params);
    }

    /**
     * @param int $userId
     *
     * @return null|Profile
     */
    public function findActiveProfileByUserId($userId)
    {
        $where = [
            'userId = :userId',
            'isActive = 1',
            'deletedAt IS NULL'
        ];
        $params = ['userId' => $userId];

        return $this->findOne($where, $params);
    }

    /**
     * @param $id
     * @return null|\YourOwnFramework\Db\ErzatsORMInterface
     */
    public function findOneById($id)
    {
        return $this->findOne(['id = :id', 'deletedAt IS NULL'], ['id' => $id]);
    }

    /**
     * @return Profile[]
     */
    public function findAllActive()
    {
        $where = [
            'isActive = 1',
            'deletedAt IS NULL'
        ];

        return $this->findAll($where, []);
    }

    /**
     * Don`t ask me why i don`t use joins %) or count(viewCount).
     * I just to lazy to implement a real ORM just for test assignment
     *
     * @param int $userId
     * @return array
     */
    public function getProfileStatisticsByUserId(int $userId)
    {
        $allUserProfiles = $this->findAllByUserId($userId);

        $viewCount = 0;
        $uicCount = 0;

        /** @var Profile $profile */
        foreach ($allUserProfiles as $profile) {
            $viewCount += $profile->getViewCount();
            $uicCount += $profile->getUic();
        }

        return ['view' => $viewCount, 'uic' => $uicCount];
    }
}