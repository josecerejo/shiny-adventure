<?php


class databaseTest extends PHPUnit_Framework_TestCase{
    private $db;
    
    private function retornaLoginDoBancoDeDados()
    {
        return array(
            'host' => "localhost",
            'user' => "root",
            'password' => "123",
            'database' => 'shiny_adventure'
        );
    }
    
    /**
     * 
     * @expectedException Exception
     */
    public function testDatabaseExceptionConnect() {
        $infos = $this->retornaLoginDoBancoDeDados();
        $this->db = new Database($infos['host'] , "error", $infos['senha'], $infos['database']);
        $this->fail("Esta mensagem não deve aparecer");
    }
    
    public function testDatabaseConnect() {
        $infos = $this->retornaLoginDoBancoDeDados();
        $this->db = new Database($infos['host'] , $infos['usuario'], $infos['senha'], $infos['database']);
        $this->assertTrue($this->db->connected);
    }
}

?>
