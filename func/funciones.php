<?php

function comprobar_error($data){
    if(isset($data['result']['error_code'])){
      return $data['result']['error_code'];
    } else if (isset($data['result']['successful_code'])) {
        return $data['result']['successful_code'];
    } else {
        return 200;
    }
}

function determinar_grupo($edad){
    if($edad >= 55){
        return 'riesgo';
    } else {
        return 'seguro';
    }
}   

?>