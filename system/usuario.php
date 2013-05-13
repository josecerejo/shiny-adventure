<?php

require_once __DIR__ . "/database.php";
require_once __DIR__ . "/session.php";

class Usuario{
	private $nome;
	private $id;
	private $email;
        private $ultimoLogin;
        private $db;
        private $sessionHandle;
        private $tempoRecupercaoSenha;

        public function __construct( Database $db) {
            $this->db = $db;
            $this->sessionHandle = Session::getInstance();
            
            /**
             *  Valores para definir o tempo de recupercao de senha
             *  1D .. nD = numero de dias seguido pela letra D
             *  60M ..nM = numero de minutos seguido pela letra M
             */
            $this->tempoRecupercaoSenha = "1D";
        }
        
	public function existe($id){
            $resultado = $this->db->query('SELECT * FROM usuarios WHERE id = ?',$id);
            if ( !empty($resultado) && count($resultado[0]['id']) == $id ) {
                return true;
            } else {
                return false;
            }     
	}
        
        
        public function usuarioOnline() {
            if ( $this->sessionHandle->get('auth') === true ) {
                return true;
            }
            return false;
        }
        
        public function criarUsuario($nome,$email,$senha) {
            $senha = md5($senha);
            $ultimoLogin = Date('Y-m-d');
            $this->db->query("INSERT INTO usuarios (nome, email, senha, ultimoLogin ) VALUES( ? , ? , ? , ?);",array( $nome, $email, $senha , $ultimoLogin));   
            $this->id =$this->db->lastInsertID();
            $this->nome = $nome;
            $this->email = $email;
            $this->ultimoLogin = $ultimoLogin;
            return $this->id;
        }
        
        public function apagaUsuario($id) {
            if ( !empty($id) ){
                if ( $this->db->query("DELETE FROM usuarios WHERE id= ?",$id) !== false ) {
                    return true;
                } else {
                    return false;
                }
            } else {
               throw new Exception("ID não informado");
            }
        }
        
        public function esqueceuSenha(Mail $emailHandle,$email) {
            $resultados  = $this->db->query("SELECT * FROM usuarios WHERE email= ? ",$email);
            $count = count($resultados);
            if (  $count === 1) { 
                $hash = Helper::hashGenerator(20);
                
                $link = Config::$site_url . "/usuario/recuperarSenha/?codigo=" . $hash;
                
                $html = file_get_contents(Config::viewPath(). "recuperarSenhaEmail.html");
                $html = str_ireplace("{{LINK}}", $link, $html);
                
                if( $emailHandle->sendMail($email,"Recuperação de senha do site" . Config::$site_nome ,$html) &&  $this->registrarNovaChaveRecuperacao($email,$hash) ) {
                    return $hash;
                }
                throw new Exception("Erro ao enviar o email de recuperação!");
            }
            return false;
        }
        
        private function registrarNovaChaveRecuperacao($email,$chave) {
            $tempoReal = Helper::dataParaMinutos($this->tempoRecupercaoSenha);
            $this->db->query("INSERT INTO tb_recuperacaoSenha (email, tempoMaximo, chave) VALUES ( ? , ? , ? )",array( $email, $tempoReal, $chave));
            return true;
        }
        
        public function trocarSenha($hash,$email,$novaSenha) {
            $resultado = $this->db->query("SELECT * FROM tb_recuperacaoSenha WHERE email = ? AND chave = ? ;", array($email , $hash));
            if  ( !empty($resultado) ) {
                if ( $resultado[0]['tempoMaximo'] <= time() )
                {
                    $senha = md5($novaSenha);
                    $this->db->query("UPDATE usuarios SET senha = ? WHERE email = ?",array($senha, $email));
                    return true;
                } else {
                    throw new Exception("O tempo de recuperação expirou!");
                }   
            }
            throw new Exception("Não encontramos a está requisição no banco de dados");
        }
        
        public function logar($email, $senha) {
            $senha = md5($senha);
            $sql = "SELECT * FROM usuarios WHERE email = ?;";
            $resultado = $this->db->query($sql,$email);
            if  ( $resultado[0]['senha'] == $senha) {
                $dateTmp = date("Y-d-m");
                $this->db->query("UPDATE TABLE usuarios SET ultimoLogin = ? WHERE id = ? ",array($dateTmp,$resultado[0]['id']));
                $this->nome = $resultado[0]['nome'];
                $this->email = $resultado[0]['email'];
                $this->id = $resultado[0]['id'];
                $this->ultimoLogin = $dateTmp;
                
                $this->sessionHandle->set('nome',$this->nome);
                $this->sessionHandle->set('email',$this->email);
                $this->sessionHandle->set('id',$this->id);
                $this->sessionHandle->set('ultimoLogin',$this->ultimoLogin);
                $this->sessionHandle->set('auth',true);
                return true;
            } else {
                $this->sessionHandle->set('auth',false);
                return false;
            }
        }
        
        public function deslogar() {
            // Desloga o usuario atual
            // Vamos setar primeiramente para falso se 
            // esta autenticado, depois destruir a session
            if ( ! $this->usuarioOnline() ) {
                return false;
            }
            
            $this->sessionHandle->set('auth',false);
            $this->sessionHandle->destroy();
            return true;
        }
      
        public function informacoesUsuario($id) {
            $resultado = $this->db->query("SELECT id,nome,email,ultimoLogin FROM usuarios WHERE id = ? ",$id);
            return $resultado[0];
        }

}
