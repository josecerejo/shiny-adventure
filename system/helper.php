<?php

class Helper {

    public static function hashGenerator($n) {
        $caracteresValidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321_qwertyuioplkjhgfdsazxcvbnm";
        $numeroDeCharValidos = strlen($caracteresValidos) - 1;
        $finalHash  = "";
        
         srand((double) microtime() * 1000000); 
        
        for ( $i = 0; $i < $n ; $i++) {
            $x = rand(0, $numeroDeCharValidos);
            $finalHash .= $caracteresValidos[$x];
          
        }
        return $finalHash;
    }
    
    public static function dataParaMinutos($string) {
        $strTmp = substr($string, strlen($string) -1 );
        
        if (substr($string, strlen($string) - 1) == "D" ) {
            return ( time() + ($strTmp*24*60*60) );
        }
        
        if (substr($string, strlen($string) - 1) == "M" ) {
            return ( time() + ($strTmp*60) );
        }
                
        return $string;
    }
    
    public static function thisURL() {
        return $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }
    
    public static function redirect($to) {        
        header("Location: {$to}");
    }
}


?>
