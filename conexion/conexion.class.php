<?php

// Clase padre para las demas hereden los metodos para obtener la informacion que corresponda
// Pacientes usara los metodos en sus propios metodos para consultar y modificar la DB

class Conexion {

    private $conexion;

    public function __construct()
    {
        $this->conexion = new PDO("mysql:dbname=apirest;host=localhost", "root", "");
    }
    //Obtener multiples datos
    protected function fetch_data($sql){
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        if($res == []){
            return false;
        }
        return $res;
    }
    // Obtener datos unicos->para GET
    protected function only_fetch_data($sql){
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_ASSOC);
        if($res == []){
            return false;
        }
        return $res;
    }
    //Saber si una columna fue alterada. Si el resultado es 0 significa que algo no fue bien->Para POST y PUT
    protected function alter_data($sql){
        $query = $this->conexion->prepare($sql);
        $query->execute();
        $row = $query->rowCount();
        if($row < 1){
            return false;
        } else {
            return $row;
        }
    }

    //Buscar datos duplicados
    protected function buscar_duplicados($query){
        $data = $this->conexion->prepare($query);
        $data->execute();
        $row = $data->rowCount();
        if($row >= 1){
            return true;
        } else {
            return false;
        }
    }
}

?>