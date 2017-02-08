<?php

namespace App\Model\Repository;

use YourOwnFramework\Db\Repository;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileRepository extends Repository
{
    const CONTAINER_KEY = 'repository.profile';
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
     * @param $id
     * @return null|\YourOwnFramework\Db\ErzatsORMInterface
     */
    public function findOneById($id)
    {
        return $this->findOne('id = :id', ['id' => $id]);
    }
}