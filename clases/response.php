<?php

class Response {

    public $response = [
        'status' => 'ok',
        'result' => array()
    ];

    /** CODIGOS 200 **/

    public function code_200($msj = 'Datos incorrectos o incompletos. revise la peticion'){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_code' => '200',
            'error_msg' => $msj
        );

        return $this->response;
    }

    public function code_201($msj = 'Se creó el registro'){
        $this->response['status'] = 'ok';
        $this->response['result'] = array(
            'successful_code' => '201',
            'successful_msg' => $msj
        );

        return $this->response;
    }


    public function code_204(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_code' => '204',
            'error_msg' => 'No hay mas registros'
        );

        return $this->response;
    }


    /** CODIGOS 400 **/

    public function error_400($msj = "Datos enviados incompletos o con formato erroneo"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_code" => "400",
            "error_msg" => $msj
        );

        return $this->response;
    }

    public function error_401($msj = "No estas autorizado, vuelvete a logear porfavor"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_code" => "401",
            "error_msg" => $msj
        );

        return $this->response;
    }

    public function error_404($msj = 'No se ha encontrado el recurso solicitado, probablemente no exista'){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_code' => '404',
            'error_msg' => $msj
        );

        return $this->response;
    }

    public function error_405(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_code' => '405',
            'error_msg' => 'El metodo no esta permitido'
        );

        return $this->response;
    }

    public function error_409($msj = 'Conflicto con el recurso solicitado'){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_code' => '409',
            'error_msg' => $msj
        );

        return $this->response;
    }

}


?>