<?php


class usuarioTest extends PHPUnit_Framework_TestCase{
   private $usuario;
   private $db;
   
    private function retornaInformacoesDoUsuario(){
        return array(
            'id' => 1,
            'nome' => 'Pedro Henrique',
            'email' => 'teste@teste.com',
            'senha' => '1020304050',
            'ultimoLogin' => date()
        );
    }
    
    public function setUp(){
        parent::setUp();
        $this->db = new Database('localhost', 'root', '123','shiny_adventure');
        $this->usuario = new Usuario($this->db);
    }
    
    public function testUsuarioExiste(){
        echo 'e eeeeee';
        $usuarioInfo = $this->retornaInformacoesDoUsuario();
        $this->assertTrue($this->usuario->existe($usuarioInfo['id']));
    }
    
    public function testCriarUsuario(){
        $this->markTestIncomplete('Precisa implementação');
    }
    
    public function testRemoverUsuario(){
        $this->markTestIncomplete('Precisa implementação');
    }
    
    public function testLogarUsuario(){
        $this->markTestIncomplete('Precisa implementação');
    }
    
    public function testEsqueceuUsuario(){
        $this->markTestIncomplete('Precisa implementação');
    }
    
    
    
}

?>
