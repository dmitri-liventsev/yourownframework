<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

define("ROOT", __DIR__);
require(ROOT . '/vendor/autoload.php');

spl_autoload_extensions(".php");
spl_autoload_register();

function my_autoloader($class) {
    $class = str_replace("\\", "/", $class);
    include ROOT . '/' . $class . '.php';
}

spl_autoload_register('my_autoloader');