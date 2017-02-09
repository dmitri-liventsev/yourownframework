<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace App\Model\Repository;

use YourOwnFramework\Db\Repository;

class UicRepository extends Repository
{
    const CONTAINER_KEY = 'repository.uic';

    /**
     * @var string
     */
    protected $table = 'uic';

    /**
     * @param $ip
     * @param $profileId
     *
     * @return array
     */
    public function findByIpAndProfileId($ip, $profileId)
    {
        $where = [
            'ip = :ip',
            'profileId = :profileId',
            'deletedAt IS NULL'
        ];

        return $this->findAll($where, ['ip' => $ip, 'profileId' => $profileId]);
    }

    public function isUnique($ip, $profileId)
    {
        return count($this->findByIpAndProfileId($ip, $profileId)) == 0;
    }
}