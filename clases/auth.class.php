<?php
error_log(0);
require_once "./conexion/conexion.class.php";
require_once "response.php";
require_once "./func/funciones.php";
require "./vendor/autoload.php";

use Firebase\JWT\JWT;

class Auth extends Conexion {

    private $usuario;
    private $password;
    private $token;
    private $key = "Hysd&7A445";

    public function login($json){

        $res = new Response;
        $data = json_decode($json, true);
        $usuario = normalizar($data['usuario']);
        $password = normalizar($data['pass']);
        if(!$usuario || !$password){
            $msj = "Rellene todos los campos";
            $res = $res->error_409($msj);
            return $res;
        } else {
            $password = hash("sha256", $password);
            $query = "SELECT usuario, pass from usuarios WHERE usuario = '$usuario' AND pass = '$password'";
            $result = parent::only_fetch_data($query);
            if($result){
                $res = $res->code_200();
                $this->token = $this->token($usuario, $password);
                $res['token'] = $this->token;
                return $res;
            } else {
                $msj = 'Credenciales Incorrectas';
                $res = $res->error_404($msj);
                return $res;
            }
        }
    }

    public function registro($json){
        $res = new Response;
        $data = json_decode($json, true);
        $this->usuario = normalizar($data['usuario']); 
        $this->password = normalizar($data['pass']);
        $pass2 = normalizar($data['pass2']);
        if(!$this->usuario || !$this->password || !$pass2){
            $msj = "Rellene todos los campos";
            $res = $res->error_409($msj);
            return $res;
        } 

        $query = "SELECT usuario FROM usuarios WHERE usuario = '$this->usuario'";
        $double = parent::buscar_duplicados($query);
        if($double){
            $msj = "El nombre de usuario ya existe";
            $res = $res->error_409($msj);
            return $res;
        }     

        if($this->password === $pass2){
            $pass = hash("sha256", $pass2);
        } else {
            $msj = "Las contraseñas no coinciden";
            $res = $res->error_409($msj);
            return $res;
        }

        $query = "INSERT INTO usuarios(usuario, pass) VALUES('$this->usuario', '$pass')";
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
        $token = array(
        'iat' => $time, // Tiempo que inició el token
        'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
        'data' => [ // información del usuario  
        'pass' => $pass, // key 
        'user' => $usuario // secret
        ]
    );

    $token = $jwt->encode($token, $this->key);

    return $token;
    }

    public function comprobrar_Token($token){
        $res = new Response;
            $jwt = new JWT;
            try {
                $result = $jwt->decode($token, $this->key, array('HS256')); 
                if($result) {
                    return true;
                } else {
                    $res = $res->error_401();
                    return $res;
                }
            } catch (\Throwable $th) {
                $res = $res->error_401();
                $res["token"] = $th->getMessage();
                return $res;
            }
        }
    }


?>