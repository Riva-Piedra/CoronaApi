<?php

require_once "../conexion/conexion.class.php";
require_once "response.php";
require "./vendor/autoload.php";

use Firebase\JWT\JWT;

class Auth extends Conexion {

    private $usuario;
    private $password;
    private $token;

    private function login($json){

        $res = new Response;
        $data = json_decode($json, true);
        $usuario = trim(strtolower(filter_var($data['usuario'], FILTER_SANITIZE_STRING))) ;
        $password = trim(filter_var($data['pass'], FILTER_SANITIZE_STRING));
        if(empty($usuario) || empty($password)){
            $msj = "Rellene todos los campos";
            $res = $res->error_409($msj);
            return $res;
        } else {
            $password = hash("md5", $password);
            $query = "SELECT usuario, pass from usuarios WHERE usuario = '$usuario' AND pass = '$password'";
            $result = parent::only_fetch_data($query);
            if($result){
                $res = $res->code_200();
                $this->token = $this->token($usuario, $password);
                $res['token'] = $this->token;
                return $res;
            } else {
                $res = $res->error_404();
                return $res;
            }
        }
    }

    private function registro($json){
        $res = new Response;
        $data = json_decode($json, true);
        $this->usuario = trim(strtolower(filter_var($data['usuario'], FILTER_SANITIZE_STRING))); 
        $this->password = trim(filter_var($data['pass'], FILTER_SANITIZE_STRING));
        $pass2 = $data['pass2'];
        if(empty($this->usuario) || empty($this->password || empty($pass2))){
            $msj = "Rellene todos los campos";
            $res = $res->error_409($msj);
            return $res;
        }
            
        if($this->password === $pass2){
            $pass = hash("md5", $this->pass);
        } else {
            $msj = "Las contraseñas no coinciden";
            $res = $res->error_409($msj);
            return $res;
        }

        $query = "INSERT INTO usuarios(usuario, pass) values('$this->usuario', '$pass')";
        $result = parent::alter_data($query);
        if($result){
            $res = $res->code_201();
            return $res;
        } else {
            $res = $res->error_404();
            return $res;
        }
    }

    private function token($usuario, $pass) {
        $jwt = new JWT;
        $time = time();
        $key = "Hysd&7A445";
        $token = array(
        'iat' => $time, // Tiempo que inició el token
        'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
        'data' => [ // información del usuario  
        'pass' => $pass, // key 
        'user' => $usuario // secret
        ]
    );

    $token = $jwt->encode($token, $key);

    return $token;
    }
}


?>