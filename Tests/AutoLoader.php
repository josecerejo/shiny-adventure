<?php

function load($className){
    $fileName = __DIR__.'/../system/'.strtolower($className).".php";
    if (file_exists($fileName))
        require_once $fileName;
}

spl_autoload_register('load');

?>
