<?php


class usuarioTest extends PHPUnit_Framework_TestCase{
   private $usuario;
   
    private function retornaInformacoesDoUsuario(){
        return array(
            'id' => 15,
            'nome' => 'Pedro Henrique',
            'email' => 'teste@teste.com',
            'senha' => '1020304050'
        );
    }
    
    public function setUp(){
        $this->usuario = new Usuario();
    }
    
    public function testUsuarioExiste(){
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
