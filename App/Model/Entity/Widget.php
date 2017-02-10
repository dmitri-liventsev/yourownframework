<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace App\Model\Entity;


use YourOwnFramework\Db\ErzatsORM;

/**
 * Class Widget
 * @package App\Model\Entity
 *
 * @method setLastStatus($status)
 */
class Widget extends ErzatsORM
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
        'id', 'userId', 'uic', 'viewCount', 'lastStatus', 'deletedAt', 'createdAt'
    ];

    /**
     * @var array
     */
    protected $utilFields = ['id', 'deletedAt', 'createdAt'];

    public function increaseViewCount()
    {
        $this->query(
            'UPDATE widget SET viewCount = viewCount + 1 WHERE ( id = :id )',
            ['id' => $this->getPrimaryKeyValue()]
        );
    }

    public function increaseUic()
    {
        $this->query(
            'UPDATE widget SET uic = uic + 1 WHERE ( id = :id )',
            ['id' => $this->getPrimaryKeyValue()]
        );
    }
}