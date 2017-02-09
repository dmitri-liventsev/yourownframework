<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

use YourOwnFramework\YourOwnFramework;

return [
    'templateDirectory' => '/App/View/',
    'layoutDirectory' => '/App/View/Layout/',
    YourOwnFramework::CONTAINER_CONTAINER_KEY => require(__DIR__.'/container.php')
];