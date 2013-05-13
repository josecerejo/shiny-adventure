<?php

class Database {
    private $host;
    private $usuario;
    private $senha;
    private $database;
    private $db;
    private $sth;
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
    
    public function query( $sql , $value = null) {
        if ( empty($value) ) {
            $this->sth = $this->db->prepare($sql);
            if  ( $this->sth->execute() )
                return $this->sth->fetchAll();
            else
                return false;
        } else {
            $this->sth = $this->db->prepare($sql);
            if ( isset($value) ) {
                if (is_array($value)) {
                    $interator = 1;
                    foreach ( $value as $v) {
                        $this->sth->bindValue($interator++, $v);
                    }
                    if  ( $this->sth->execute() )
                        return $this->sth->fetchAll();
                    else
                        return false;
                } else {
                    $interator = 1;
                    $this->sth = $this->db->prepare($sql);
                    $this->sth->bindValue($interator, $value);
                    if  ( $this->sth->execute() )
                        return $this->sth->fetchAll();
                    else
                        return false;
                }
            }
        } 
    }
  
    public function lastInsertID() {
        $retorno = $this->query("SELECT LAST_INSERT_ID();");
        return $retorno[0][0];
    }
    
    
}

?>
