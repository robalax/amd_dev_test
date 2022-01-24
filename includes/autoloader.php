<?php 

spl_autoload_register('autoLoad');

function autoLoad($className)
{
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    include_once $className.'.php';
}