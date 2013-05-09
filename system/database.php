<?php

class Database {
    private $host;
    private $usuario;
    private $senha;
    private $database;
    private $db;
    public $connected;
    
    public function __construct($host,$usuario,$senha,$database){
        $this->usuario = $usuario;
        $this->host = $host;
        $this->senha = $senha;
        $this->database = $database;
        
        $this->db = new PDO("mysql:dbname={$this->database};host={$this->host};port=3333",$this->usuario,$this->senha);
        if ( !$this->db )
            throw new Exception ("Erro ao conectar no banco de dados.".$this->db->errorInfo());
        
        $this->connected = true;
    }
    
    
}

?>
