<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

use Interop\Container\ContainerInterface;
use YourOwnFramework\YourOwnFramework;

return [
    'templatePath' => '/App/View/',
    'layoutPath' => '/App/View/Layout/',
    YourOwnFramework::CONTAINER_CONTAINER_KEY => require(__DIR__.'/container.php')
];