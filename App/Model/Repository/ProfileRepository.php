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
        //TODO: implement it
        $where = '';
        $params = [];

        return $this->findAll($where, $params);
    }

    /**
     * @param $userId
     *
     * @return \YourOwnFramework\Db\ErzatsORMInterface[]
     */
    public function findAllByUserId($userId)
    {
        $where = 'userId = :userId';
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
        return $this->findOne('id = :id', ['id' => $id]);
    }

    /**
     * @return Profile[]
     */
    public function findAllActive()
    {
        $where = 'isActive = 1';

        return $this->findAll($where, []);
    }
}