<?php
    namespace Model;

    class Pacientes extends ActiveRecord{

        public static $columnasDB = ['id','nombre','propietario','email','veterinarioId'];
        public static $tabla = 'pacientes';

        public function __construct($args=[]){
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->propietario = $args['propietario'] ?? '';
            $this->email = $args['email'] ?? '';
            $this->veterinarioId = $args['veterinarioId'] ?? '';
        }   
    
            public function generarToken(){
                $this->token = bin2hex(openssl_random_pseudo_bytes(32,$cstrong));
            }
            public function hashearPassoword(){
                $this->password = password_hash($this->password,PASSWORD_BCRYPT);
            }
        }
?>