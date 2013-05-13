<?php


require_once __DIR__ . "/../system/helper.php";
require_once __DIR__ . "/../system/config.php";
require_once __DIR__ . "/../system/database.php";
require_once __DIR__ . "/../system/session.php";
require_once __DIR__ . "/../system/DatabaseConfig.php";

include_once __DIR__ . "/../system/usuario.php";


abstract class MainController {
    protected $usuario;
    private $db;
    
    public function __construct() {
        global $config_db;
        //$this->db = new Database(HOST, USUARIO, SENHA, DATABASE);
       //  $this->usuario = new Usuario($this->db);
    }
    
    public function get($param = null) {
        if (is_null($param))
            return $_GET;
        else
            return $_GET[$param];
    }
    
    public function post($param = null) {
        if (is_null($param))
            return $_POST;
        else
            return $_POST[$param];
    }
    
    public function loadView($viewName,$viewData = array()) {
        $path = __DIR__ . "/../view/" . strtolower($viewName);
        if ( !file_exists($path) ) {
            $viewName = explode(".", $viewName);
            $viewName = $viewName[0];
            Helper::redirect(Config::globalPath_relative()."error404/viewNaoEncontrada/{$viewName}");
            return false;
        }
        
        extract($viewData);

        ob_start();
        require $path;
        $html = ob_get_contents();
        
        ob_end_clean();
        
        echo $html;
    }
}

?>
