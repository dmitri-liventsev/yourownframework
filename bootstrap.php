<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

require(ROOT . '/autoload.php');
require(ROOT . '/vendor/autoload.php');

$config = require(ROOT . '/Config/main.php');

$yourOwnFramework = new YourOwnFramework\YourOwnFramework($config);
$yourOwnFramework->run();