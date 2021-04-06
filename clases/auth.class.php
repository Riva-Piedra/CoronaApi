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
        $usuario = $data['usuario'];
        $password = $data['password'];
        $query = "SELECT id, usuario, pass from usuarios WHERE usuario = '$usuario' AND pass = '$password'";
        $result = parent::only_fetch_data($query);
        if($result){
            $res = $res->code_200();
            return $res;
        } else {
            $res = $res->error_404();
            return $res;
        }
    }

    private function registro($json){
        $res = new Response;
        $data = json_decode($json, true);
        $this->usuario = $data['usuario'];
        $this->password = $data['pass'];
        $pass2 = $data['pass2'];
        $query = "INSERT INTO usuarios(usuario, pass) values('$this->usuario', '$this->password')";
        $result = parent::alter_data($query);
        if($result){
            $res = $res->code_201();
            return $res;
        } else {
            $res = $res->error_404();
            return $res;
        }
    }

    private function Token($usuario, $pass, $id) {
        $time = time();
        $key = "Hysd&";
        $token = array(
        'iat' => $time, // Tiempo que inició el token
        'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
        'data' => [ // información del usuario
        'id' => $id,   
        'pass' => $pass, // key 
        'name' => $usuario // secret
        ]
    );

    $token = JTW::encode($token, $key);

    return $token;
    }
}


?>