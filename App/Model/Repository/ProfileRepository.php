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
     * @return Profile[]
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
     * @return Profile[]
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
     * @param $userId
     *
     * @return Profile[]
     */
    public function findAllOldProfilesByUserId($userId)
    {
        $where = [
            'userId = :userId',
            'isActive = 0',
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
}