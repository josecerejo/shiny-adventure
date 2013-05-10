<?php


class databaseTest extends PHPUnit_Framework_TestCase {
    private $db;
    
    private function retornaLoginDoBancoDeDados() {
        return array(
            'host' => "localhost",
            'user' => "root",
            'password' => "123",
            'database' => 'shiny_adventure'
        );
    }
    
    public function setUp() {
        parent::setUp();
        $infos = $this->retornaLoginDoBancoDeDados();
        $this->db = new Database($infos['host'] , $infos['user'], $infos['password'], $infos['database']);
    }
    
    public function testDatabaQueryWithoutParamns() {
        $value = $this->db->query("SELECT * FROM test");
        $this->assertContains('pedro',$value[0]);
    }
    
    public function testDatabaQueryWithParamns() {
        $value = $this->db->query("SELECT * FROM test WHERE nome = ?",'pedro');
        $this->assertContains('pedro',$value[0]);
    }
    
    
}

?>
