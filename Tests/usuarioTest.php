<?php


class usuarioTest extends PHPUnit_Framework_TestCase{
   private $usuario;
   private $db;
   
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    private function retornaInformacoesDoUsuario(){
        return array(
            'id' => 1,
            'nome' => 'Pedro Henrique',
            'email' => 'teste@teste.com',
            'senha' => '1020304050',
            'ultimoLogin' => date('Y-m-d')
        );
    }
    
    public function setUp(){
        parent::setUp();
        $this->db = new Database('localhost', 'root', '123','shiny_adventure');
        $this->usuario = new Usuario($this->db);
    }
    
    public function testUsuarioExiste() {
        $usuarioInfo = $this->retornaInformacoesDoUsuario();
        
        $this->assertTrue($this->usuario->existe($usuarioInfo['id']));
    }
    
    public function testCriarUsuario(){
        $nome = 'Novo Usuario';
        $email = 'novo@usuario.com';
        $senha = 'minhaSenha';
        
        $this->assertFalse($this->usuario->usuarioOnline(),'Verifica se não usuario esta online');
        $this->assertNotEmpty($this->usuario->criarUsuario($nome,$email,$senha));
    }
    
    public function testLogarUsuario(){
        $info = $this->retornaInformacoesDoUsuario();
        $this->assertTrue($this->usuario->logar($info['email'],$info['senha']));
        $this->assertTrue($this->usuario->usuarioOnline(),'Verifica se o usuario esta online');
    }
    
    public function testConseguirInformacoesDoUsuario() {
        $id = 1;
        $retorno = $this->usuario->informacoesUsuario($id);
        $infos = $this->retornaInformacoesDoUsuario();
     
        $this->assertTrue($retorno['id']==$infos['id'],"O id é diferente");
        $this->assertTrue($retorno['nome']==$infos['nome'],"O nome é diferente");
        $this->assertTrue($retorno['email']==$infos['email'],"O email é diferente");
        $this->assertTrue(!empty($retorno['ultimoLogin']),"A data de login esta vazia ou não existe");
    }
    
    public function testEsqueceuUsuario(){
        $info = $this->retornaInformacoesDoUsuario();
                
        $mock = $this->getMock("Mail",array('sendMail'));
        $mock->expects($this->once())
                ->method('sendMail')
                ->will($this->returnValue(true));
        $resultado = $this->usuario->esqueceuSenha($mock,$info['email']);
        
        $this->assertNotEmpty($resultado);
        
        $this->assertTrue($this->usuario->trocarSenha($resultado, $info['email'], "908070605040302010"));
        $this->usuario->trocarSenha($resultado, $info['email'], $info['senha']);
    }
    
    public function testRemoverUsuario(){ 
        $id = $this->db->query("SELECT * FROM usuarios WHERE id <> 1 ORDER BY id DESC LIMIT 1");
        if  ( !empty($id) ) {
            $id = $id[0][0];
        
            $this->assertTrue($this->usuario->apagaUsuario($id));
        }
    }
    
    public function tearDown() {
        parent::tearDown();
        $this->db->query("ALTER TABLE usuarios AUTO_INCREMENT = 2");
    }
    
    
}

?>
