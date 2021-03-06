<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

use YourOwnFramework\Exception\SecurityException;

try {
    require('autoload.php');

    $config = require(ROOT . '/Config/main.php');

    $yourOwnFramework = new YourOwnFramework\YourOwnFramework($config);
    $yourOwnFramework->run();
} catch (\YourOwnFramework\Exception\HttpNotFoundException $e) {
    http_response_code(404);
    echo " 404, everybody like 404.";
} catch(SecurityException $e) {
    http_response_code(403);
    echo " Why you try to hack me? %(";
} catch(\YourOwnFramework\Exception\HttpUnauthorized $e) {
    http_response_code(401);
    echo " Just sign-in and try again!";
} catch (Throwable $e) {
    http_response_code(500);
    echo " You broke it! Why did you broke it?! It was born in love.... but than you damage it....;-(";
}
