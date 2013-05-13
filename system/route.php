<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../controllers/MainController.php';

class Route {
    private static $instance;
    private $defaultRoute = 'home';
    private $atual;
    private $controler;
    
    public static function getInstace() {
        if ( !isset(self::$instancee) )
            self::$instance = new Route ();
        
        return self::$instance;    
    }
    
    public function setDefaultRoute($nome) {
        $this->defaultRoute = $nome;
    }
     
    public function setAtual($rotue) {
        $this->atual = $rotue;
    }
    
    public function getDefaultRoute() {
        return $this->defaultRoute;
    }
    
    public function getAtualRoute() {
        return $this->atual;
    }
    
    public function rotear() {
        $parameters = explode("/",$this->atual);
        $route = @$parameters[1];
        
        if ( empty($route) || is_null($route) ) {
            $this->loadController($this->defaultRoute);
            $this->loadMethod('index');
        } else {
            if ( $this->loadController($route) ) {
                unset($parameters[0]);
                unset($parameters[1]);
                
                $this->loadMethod(array_values($parameters));
            }
        }
    }
    
    private function loadController($name) {
        $path = Config::controllersPath() . strtolower($name) . ".php";
        
        if ( !file_exists($path) ) {
            require Config::controllersPath() . "error404.php";
            $this->controler = new Error404();
            $this->controler->ControllerNaoEncontrado($name);  
            return false;
        } 
        
        require_once $path;
        $name[0] = strtoupper($name[0]);
        $this->controler = new $name;
        return true;
    }
    
    private function loadMethod($parameters) {
        $method = ( is_array($parameters) ) ? @$parameters[0] : $parameters;
        
        if ( is_array($parameters) && count($parameters) > 1 ) {
            $values = array();  

            foreach($parameters as $k => $p) {
                if ( $k > 0 )
                    $values[] = $p;
            }
        } else {
            $values = array('null', 'null' ,'null' ,'null');
        }    
   
        if (method_exists($this->controler, $method)) {
            $this->controler->$method($values);
        } elseif (method_exists($this->controler, 'index')) {
             $this->controler->index($values);
        } else {
            $this->loadController("error404");
            $this->controler->MethodNaoEncontrado($method);
        }
    }
    
}



?>
