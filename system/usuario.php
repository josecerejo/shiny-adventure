<?php

include_once 'database.php';

class Usuario{
	private $nome;
	private $id;
	private $email;
	private $senha;
        private $db;

        public function __construct( Database $db) {
            $this->db = $db;
        }
        
	public function existe($id){
            $resultado = $db->query('SELECT * FROM usuarios WHERE id = ?',$id);
            if ( count($resultado[0]) == 1 ) {
                return true;
            } else {
                return false;
            }     
	}


}
