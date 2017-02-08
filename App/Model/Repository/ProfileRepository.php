<?php

namespace App\Model\Repository;

use YourOwnFramework\Repository;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileRepository extends Repository
{
    /**
     * @return \YourOwnFramework\ErzatsORMInterface[]
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
     * @return null|\YourOwnFramework\ErzatsORMInterface
     */
    public function findOneById($id)
    {
        return $this->findOne('id = :id', ['id' => $id]);
    }
}