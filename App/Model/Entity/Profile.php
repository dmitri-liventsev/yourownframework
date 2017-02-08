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
 * @method getText1()
 * @method getText2()
 * @method getText3()
 * @method getText4()
 * @method getText5()
 * @method getText6()
 * @method getText7()
 * @method getText8()
 * @method getCheckbox1()
 * @method getCheckbox2()
 * @method getCheckbox3()
 * @method getRadio1()
 * @method getCreatedAt()
 * @method getId()
 */
class Profile extends ErzatsORM
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $table = 'profile';

    /**
     * @var array
     */
    protected $params = [
        'id', 'text1', 'text2', 'text3', 'text4', 'text5', 'text6', 'text7', 'text8',
        'checkbox1', 'checkbox2', 'checkbox3', 'radio1', 'isActive', 'deletedAt'
    ];
}