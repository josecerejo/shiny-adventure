<?php

class Config {

    
    public static $site_nome = "Nome do Site";
    public static $site_url  = "htt://localhost/shiny-adventure/";
    
    public static $site_root_absolute = "htt://localhost/shiny-adventure/";
    public static $system_root_absolute = "htt://localhost/shiny-adventure/system/";
    public static $view_root_absolute = "htt://localhost:888/shiny-adventure/view/";
    public static $controllers_root_absolute = "htt://localhost:888/shiny-adventure/controllers/";
    
    
    public static function site_root_relative() {
        return ( __DIR__ . "/../" );
    }
    
    public static function rootPath() {
        return __DIR__ . "/";
    }
    
    public static function viewPath() {
        return __DIR__ . "/../view/";
    }
    
    public static function controllersPath() {
        return __DIR__ . "/../controllers/";
    }
    
    public static function globalPath_relative() {
        $serverName = $_SERVER['SERVER_NAME'];
        $phpSelf = $_SERVER['SCRIPT_NAME'];
        $phpSelf = explode("/",$phpSelf);
        $count = count($phpSelf);
        $finalDirectoryPath = "";
        
        for($i = 0; $i < ($count-1) ; $i++) {
            if ( !empty($phpSelf) )
                $finalDirectoryPath .= $phpSelf[$i]."/";
        }
        
        return $finalDirectoryPath ;
    }
    
}


?>
