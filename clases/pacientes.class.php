<?php

require_once "clases/response.php";
require_once "conexion/conexion.class.php";
require_once "auth.class.php";

class Paciente extends Conexion {
    private $id;
    private $dni;
    private $nombre;
    private $apellido;
    private $edad;
    private $grupo;

    // Metodo GET

    public function total(){
        $query = "SELECT COUNT(*) FROM pacientes";
        $data = parent::only_fetch_data($query);
        if(!$data){
            $res = new Response;
            $res = $res->error_400();
            return $res;
        } else {
            return $data;
        }
    }

    public function lista_pacientes($pagina){
        $inicio = 0;
        $cantidad = 5;

        if($pagina > 1){
            $inicio = ($cantidad * $pagina) - $cantidad;
        }

        $query = "SELECT * FROM pacientes LIMIT $inicio, $cantidad";
        $data = parent::fetch_data($query);
        if(!$data){
            $res = new Response;
            $msj = "No hay mas registros";
            $res = $res->error_404($msj);
            return $res;    
        } else {
            return $data;
        }
    }

    public function lista_pacientes_filtrada_edad($pagina, $param){
        $inicio = 0;
        $cantidad = 5;
        $param = trim($param);
        if($pagina > 1){
            $inicio = ($cantidad * $pagina) - $cantidad;
        }
        $query = "SELECT * FROM pacientes WHERE edad >= $param 
                ORDER BY edad LIMIT $inicio, $cantidad";
        $data = parent::fetch_data($query);
        if(!$data){
            $res = new Response;
            $msj = "No hay mas registros";
            $res = $res->code_200($msj);
            return $res;    
        } else {
            return $data;
        }
    }

    public function obtener_paciente($dni){
        $this->dni = trim($dni);
        $query = "SELECT * FROM pacientes WHERE DNI = $this->dni";
        $data = parent::only_fetch_data($query);  
        if(!$data){
            $res = new Response;
            $res = $res->error_404();
            return $res;    
        } else {
            return $data;
        }
    }

    //METODO POST 
    public function insertar_paciente($json, $token){
        $_response = new Response;
        $_Auth = new Auth;
        $token = $_Auth->comprobrar_Token($token);
        if(!$token){
            $res = $_response->error_401();
            return $res;
        } else {
            $data = json_decode($json, true);
            if( !isset($data['nombre']) || 
                !isset($data['apellido']) ||
                !isset($data['DNI']) || 
                !isset($data['edad'])){
                    $res = $_response->error_400();
                    return $res;
            } else {
                $this->nombre = strtolower(normalizar($data['nombre']));
                $this->apellido = strtolower(normalizar($data['apellido']));
                $this->dni = trim($data['DNI']);
                $this->edad = trim($data['edad']);
                $this->grupo = determinar_grupo($this->edad);
                $query = $query = "SELECT DNI FROM pacientes WHERE DNI = $this->dni";
                $double = parent::buscar_duplicados($query);
                if($double){
                    $msj = 'Ya hay un paciente con ese DNI, revise los datos';
                    $res = $_response->error_409($msj);
                    return $res;
                } else {
                    $query = "INSERT INTO pacientes(nombre, apellido, DNI, edad, grupo) 
                        values
                       ('$this->nombre', 
                        '$this->apellido', 
                        '$this->dni', 
                        '$this->edad', 
                        '$this->grupo')";
                    $data = parent::alter_data($query);
                    if(!$data){
                        $res = $_response->error_400();
                        return $res;
                    } else {
                        $msj = "Se crearon $data registros";
                        $res = $_response->code_201($msj);
                        return $res;
                    }    
                }
            }
        }
    }

    // METODO PUT
    public function modificar_paciente($json, $token){

        $_response = new Response;
        $_Auth = new Auth;
        $token = $_Auth->comprobrar_Token($token);
        if(!$token){
            $res = $_response->error_401();
            return $res;
        } else {
            $data = json_decode($json, true);
            if(!isset($data["id"])){
                $res = $_response->error_400();
                return $res;
            }
            $this->id = $data["id"];
            $this->nombre = strtolower(normalizar($data['nombre']));
            $this->apellido = strtolower(normalizar($data['apellido']));
            $this->dni = trim($data['DNI']);
            $this->edad = trim($data['edad']);
            $this->grupo = determinar_grupo($this->edad);
            $query = "UPDATE pacientes SET nombre = '$this->nombre', apellido = '$this->apellido',
            DNI = '$this->dni', edad = '$this->edad', grupo = '$this->grupo' WHERE ID = '$this->id'";
            $data = parent::alter_data($query);
            if(!$data){
                $msj = "No se enviaron datos nuevos";
                $res = $_response->error_400($msj);
                return $res;
            } else {
                $msj = "Se modificaron $data registros";
                $res = $_response->code_201($msj);
                return $res;
            } 
        }
    }
}
?>