<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once "func/funciones.php";
require_once "clases/pacientes.class.php";
require_once "clases/response.php";

$_paciente = new Paciente;
$_response = new Response;

// PETICIONES POR METODO GET
if($_SERVER["REQUEST_METHOD"] == "GET"){
    //--Se comprueban las variables y si estas dan algun error
    if(isset($_GET["pagina"]) && isset($_GET["edad"])){ 
        $edad = $_GET["edad"];
        $pagina = $_GET["pagina"];
        $data = $_paciente->lista_pacientes_filtrada_edad($pagina, $edad);
        //Respuesta Final
        echo json_encode($data);   
        http_response_code(comprobar_error($data));

    } else if(isset($_GET["pagina"])){
            $pagina = $_GET["pagina"];
            $data = $_paciente->lista_pacientes($pagina);
            //Respuesta Final
            echo json_encode($data);   
            http_response_code(comprobar_error($data));

        } else if(isset($_GET["id"])){
                $id = $_GET["id"];
                $data = $_paciente->obtener_paciente($id);
                //Respuesta Final
                echo json_encode($data);
                http_response_code(comprobar_error($data));

        } else {
            //Error en la petición por metodo GET
            $_response = $_response->code_200();
            echo json_encode($_response);
    }
    // PETICIONES POR METODO POST
} else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $post_body = file_get_contents("php://input");
    $post_body = $_paciente->insertar_paciente($post_body);
    //Respuesta Final / Los errores se comprueban en insertar_paciente y los devuelven si existen
    http_response_code(comprobar_error($post_body));
    echo json_encode($post_body);
    http_response_code(comprobar_error($post_body));
  // PETICIONES POR METODO PUT  
} else if($_SERVER["REQUEST_METHOD"] == "PUT"){
    $put_body = file_get_contents("php://input");
    $put_body = $_paciente->modificar_paciente($put_body);
    echo json_encode($put_body);
    http_response_code(comprobar_error($put_body));
} else {
    $res = $_response->error_405();
    http_response_code(comprobar_error($res));
    echo json_encode($res);
}  

?>