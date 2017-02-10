<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace App\Model\Repository;

use App\Model\Entity\Widget;
use YourOwnFramework\Db\Repository;

class WidgetRepository extends Repository
{
    const CONTAINER_KEY = 'repository.widget';

    /**
     * @var string
     */
    protected $table = 'widget';

    /**
     * @param $userId
     *
     * @return Widget
     */
    public function findByUserId($userId)
    {
        $where = [
            'userId = :userId',
            'deletedAt IS NULL'
        ];
        $params = ['userId' => $userId];

        return $this->findOne($where, $params);
    }

    /**
     * @return Widget[]
     */
    public function findAllWidgets()
    {
        $where = [
            'deletedAt IS NULL'
        ];

        return $this->findAll($where, []);
    }
}
