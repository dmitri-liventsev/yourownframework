<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace App\Model\Entity;

use YourOwnFramework\Db\ErzatsORM;

/**
 * Class Profile
 *
 * @package App\Model\Entity
 *
 * @method getId()
 * @method getUserId()
 * @method getDetails()
 * @method getStatus()
 * @method getIsActive()
 * @method getCreatedAt()
 * @method getDeletedAt()
 */
class Profile extends ErzatsORM
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $params = [
        'id', 'userId', 'details', 'isActive', 'status', 'deletedAt'
    ];
}