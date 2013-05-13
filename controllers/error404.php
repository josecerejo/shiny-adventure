<?php

class Error404 extends MainController {
    
    public function index() {
        echo "404 - Error";
    }
    
    public function ControllerNaoEncontrado($nome) {
        echo "Erro ao encontrar o controller: ", $nome;
    }
    
    public function MethodNaoEncontrado($nome) {
        echo "Erro ao encontrar o metodo: ", $nome;
    }
    
    public function viewNaoEncontrada($nome) {
        echo "Erro ao encontrar a view: ",$nome[0];
    }
}

?>
