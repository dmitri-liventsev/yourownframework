<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace App\Model\Entity;

use YourOwnFramework\Db\ErzatsORM;

/**
 * Class Uic
 * @package App\Model\Entity
 *
 * @method setIp($ip)
 * @method setProfileId($profileId)
 */
class Uic extends ErzatsORM
{
    protected $table = 'uic';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $params = [
        'id', 'ip', 'profileId', 'deletedAt', 'createdAt'
    ];

    /**
     * @var array
     */
    protected $utilFields = ['id', 'deletedAt', 'createdAt'];
}