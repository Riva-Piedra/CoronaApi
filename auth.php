<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Authorization');
header('Access-Control-Allow-Origin: *');
require_once "./clases/auth.class.php";
require_once "func/funciones.php";
require_once "clases/pacientes.class.php";
require_once "clases/response.php";

$_Auth = new Auth;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $post_body = file_get_contents("php://input");
    $post_body = json_decode($post_body, true);
    if (isset($post_body['pass2'])){
        $post_body = json_encode($post_body);
        $post_body = $_Auth->registro($post_body);
        echo json_encode($post_body);
        http_response_code(comprobar_error($post_body));
    }  else if( isset($post_body['usuario'])){
        $post_body = json_encode($post_body);
        $post_body = $_Auth->login($post_body);
        echo json_encode($post_body);
        http_response_code(comprobar_error($post_body));
    } else {
        $token = getallheaders()['Authorization'];
        $token = $_Auth->comprobrar_Token($token);
        echo json_encode($token);
        http_response_code(comprobar_error($token));
    }
}

?>