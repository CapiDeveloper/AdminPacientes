<?php

namespace Controller;

use Firebase\JWT\JWT;
include_once __DIR__.'/../Includes/app.php';

use Model\Veterinarios;

class VeterinarioController{
    public static function registrar(){
      $alertas = [];
      
      if ($_SERVER["REQUEST_METHOD"] === 'POST') {

        $veterinarios = new Veterinarios($_POST);
        $existeVeterinario = Veterinarios::find('email',$_POST['email']);

        if (!$existeVeterinario ) {
          // Guardarmos registro
          $veterinarios->generarToken();
          $veterinarios->hashearPassoword();
          $resultado = $veterinarios->guardar();
          debuguear($resultado);
        }else{
            $alertas[]='El usuario ya existe';
            echo 'Existe usuario';
        }
      }// fin post
    }
    public static function confirmar(){
      $alerta = '';

      $tokenURL = $_GET['token'];
      $existeToken = Veterinarios::find('token',$tokenURL);

      if($existeToken){

        $array = [
          'id'=> $existeToken->id,
          'nombre' => $existeToken->nombre,
          'password' => $existeToken->password,
          'email' => $existeToken->email,
          'telefono' => $existeToken->telefono,
          'web' => $existeToken->web,
          'confirmado' => true,
          'token' => NULL
        ];

        $usuario = new Veterinarios($array);
        // Actualizado
        $resultado = $usuario->actualizar();
        
      }else{
        //Alerta de error
        $alerta = 'Token no valido';
      }

    }
    public static function autenticar(){
      if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        //Verificar si existe usuario
        $existeUsuario = Veterinarios::find('email',$email);
        if ($existeUsuario) {
          // verificar confirmacion
          if ($existeUsuario->confirmado == 'true') {
            
            // Confirmar password
              if (password_verify($password,$existeUsuario->password)) {
                
                // Creacion de Token con JWT
                $time = time();
                  $token = [
                    'iat' => $time, // Tiempo que inició el token
                    'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
                    'data' => [ // información del usuario
                        'id' => $existeUsuario->id,
                        'name' => $existeUsuario->nombre
                    ]
                  ];

                  $jwt = JWT::encode($token, $_ENV['JWT_SECRET'],'HS256');
                  echo json_encode($jwt);
              }else{
                // passowrd incorrecto
                echo 'password incorrecto';
              }
          }else{
            // No esta confirmado el usuario
            echo 'No esta confirmado su cuenta';
          }
          
        }else{
          echo 'No existe usuario';
        }
      }
    }
    public static function perfil(){

        if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
          header('HTTP/1.0 400 Bad Request');
          echo 'Token not found in request';
          exit;
       }

       //En $jwt esta almacenado el token que tiene el usuario en el navegador
       $jwt = $matches[1];

       //Verificar si el token existe
        if (!$jwt) {
            header('HTTP/1.0 400 Bad Request');
            exit;
        }
        
        // decodificacion JWT
        $info= json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $jwt)[1]))));

        // id extraido de JWT
        $idVeterinario =  $info->data->id;
        $usuario = Veterinarios::find('id',$idVeterinario);
        
      }

      public static function olvidePassword(){
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

          $usuario =  Veterinarios::find('email',$_POST['email']);
          
          // Si no existe agregar mensaje de errores
          if (!$usuario) {
            return;  
          }

          // Generar token en BD
          $usuario->token = bin2hex(openssl_random_pseudo_bytes(32,$cstrong));
          
        }
        
      }
      public static function comprobarToken(){
        if ($_SERVER['REQUEST_METHOD']==='POST') {
          
        }

      }
}
?>