<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

require(ROOT . '/autoload.php');
require(ROOT . '/vendor/autoload.php');

$config = require(ROOT . '/Config/main.php');

try {
    $yourOwnFramework = new YourOwnFramework\YourOwnFramework($config);
    $yourOwnFramework->run();
} catch (\YourOwnFramework\Exception\HttpNotFoundException $e) {
    http_response_code(404);
    echo "404, every body like 404.";
} catch (Throwable $e) {
    http_response_code(500);
    echo "Oops something went wrong!";
}
