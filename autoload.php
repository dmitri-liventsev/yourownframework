<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

spl_autoload_extensions(".php");
spl_autoload_register();

function my_autoloader($class) {
    include ROOT . '/' . $class . '.php';
}

spl_autoload_register('my_autoloader');