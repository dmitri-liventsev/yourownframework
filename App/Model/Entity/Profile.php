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
 * @method setId($id)
 * @method setUserId($userId)
 * @method setDetails($details)
 * @method setStatus($status)
 * @method setIsActive($isActive)
 * @method setCreatedAt($createdAt)
 * @method setDeletedAt($deletedAt)
 */
class Profile extends ErzatsORM
{
    protected $table = 'profile';

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