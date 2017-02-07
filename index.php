<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
spl_autoload_extensions(".php");
spl_autoload_register();

define("ROOT",$_SERVER["DOCUMENT_ROOT"]);

require('./vendor/autoload.php');
$config = require('./Config/main.php');

$yourOwnFramework = new YourOwnFramework\YourOwnFramework($config);
$yourOwnFramework->run();