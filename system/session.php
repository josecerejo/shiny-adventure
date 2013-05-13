<?php

class Session {
    private static $session;
    
    public static function getInstance() {
        if ( !isset(self::$session) ) {
            self::$session = new Session();
        }
        return  Session::$session;
    }
    
    public function __construct() {
        @session_start();
    }
    
    public function set($name,$value) {
        $_SESSION[$name] = $value;
    }
    
    public function get($name) {
        return (isset($_SESSION[$name])) ? $_SESSION[$name]  : false ;
    }
    
    public function destroy() {
        session_destroy();
    }
}

?>
