<?php

require_once __DIR__ . "/../system/route.php";

class routeTest extends PHPUnit_Framework_TestCase{
    private $route;
    
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    public function __construct() {
        $this->route = Route::getInstace();
    }
    
    public function testAbrirURLPrincipalDoSite() {
        $this->markTestSkipped();
        $this->route->setAtual(null);
        $this->route->rotear();
        $this->expectOutputString("It works");
    }
    
    public function testAbrirURLPrincipalDoSitePorParametro() {
        $this->route->setAtual('/testController');
        $this->route->rotear();
        $this->expectOutputString("index metodo");
    }
    
    public function testAbrirPaginaInicialComOutroMetodo() {
        $this->route->setAtual('/testController/outroMetodo/');
        $this->route->rotear();
        $this->expectOutputString("Outro Metodo");        
    }
    
    public function testAbrirPaginaComMetodoEParametros() {
        $this->route->setAtual('/testController/metodoComParametro/EsteEOParametro');
        $this->route->rotear();
        $this->expectOutputString("EsteEOParametro");
    }
    
    public function testAbrirPaginaComMetodoEParametrosSemParametros() {
        $this->route->setAtual('/testController/metodoComParametro');
        $this->route->rotear();
        $this->expectOutputString("null");
    }
    
    public function testAbrirPaginaComControllerIndefinido() {
        $this->route->setAtual('/meuController');
        $this->route->rotear();
        $this->expectOutputString('Erro ao encontrar o controller: meuController');
    }
    
    public function testAbrirViewEspecifica() {
        $this->route->setAtual('/testController/loadHTMLView');
        $this->route->rotear();
        $this->expectOutputRegex('/Valor Do Nome/i');
    }
}

?>
