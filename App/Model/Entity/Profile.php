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
 * @method getViewCount()
 * @method getUic()
 * @method getCreatedAt()
 * @method getDeletedAt()
 * @method setId($id)
 * @method setUserId($userId)
 * @method setDetails($details)
 * @method setStatus($status)
 * @method setIsActive($isActive)
 * @method setViewCount($viewCount)
 * @method setUic($Uic)
 * @method setCreatedAt($createdAt)
 * @method setDeletedAt($deletedAt)
 */
class Profile extends ErzatsORM
{
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    const STATUS_NOT_CHECKED = 'not_checked';
    const LEN_MAX = 2;

    protected $table = 'profile';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $params = [
        'id', 'userId', 'details', 'isActive', 'status', 'deletedAt', 'createdAt'
    ];

    private $detailsAtToCheck = ['text1', 'text2', 'text3', 'text4', 'text5', 'text6', 'text7', 'text8'];

    /**
     * @var array
     */
    protected $utilFields = ['id', 'createdAt'];

    /**
     * @return bool
     */
    public function isValid() :bool
    {
        return $this->getStatus() == self::STATUS_VALID;
    }

    public function checkDetails()
    {
        $status = true;

        $details = json_decode($this->getDetails(), true);
        if (!$details) {
            $status = false;
        }

        foreach ($this->detailsAtToCheck as $detailName) {
            $status = $status && (isset($details[$detailName]) && strlen($details[$detailName]) >= self::LEN_MAX);
        }

        return $status;
    }

    public function isNotChecked()
    {
        return $this->getStatus() == self::STATUS_NOT_CHECKED;
    }
}