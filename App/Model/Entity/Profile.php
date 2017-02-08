<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace App\Model\Entity;

use YourOwnFramework\ErzatsORM;

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