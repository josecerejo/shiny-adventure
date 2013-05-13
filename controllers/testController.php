<?php

class testController extends MainController{
    
    public function index() {
         echo "index metodo";
    }
    
    public function outroMetodo() {
        echo "Outro Metodo";
    }
    
    public function metodoComParametro($params = array()) {
        echo $params[0];
    }
    
    public function loadHTMLView() {
        $this->loadView("testeView.html",array('nome'=>'Valor Do Nome'));        
    }
}

?>
