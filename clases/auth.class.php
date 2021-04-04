<?php

require_once "../conexion/conexion.class.php";
require_once "response.php";

class Auth extends Conexion {

    private $usuario;
    private $password;
    private $token;

    private function login($json){
        $res = new Response;
        $data = json_decode($json, true);
        $usuario = $data['usuario'];
        $password = $data['password'];
        $query = "SELECT usuario, pass from usuarios WHERE usuario = '$usuario' AND pass = '$password'";
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
}


?>