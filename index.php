<?php

require_once 'system/route.php';

const STATUS = "DEVELOPEMENT";


switch(STATUS) {
    
    case "DEVELOPEMENT":
    case "TESTING":
        ini_set('display_errors', 'On');
        error_reporting(E_ALL | E_STRICT);
        break;
    
    default:
        ini_set('display_errors', "Off");
        error_reporting(E_ERROR);
    
}


$route = Route::getInstace();
$route->setAtual(@$_SERVER['PATH_INFO']);
$route->rotear();

