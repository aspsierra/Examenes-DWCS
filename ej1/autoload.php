<?php

function cargar($clase) {

    $nombres = explode('\\', $clase);

    $archivo = __DIR__ . DIRECTORY_SEPARATOR . $nombres[0] . DIRECTORY_SEPARATOR . $nombres[1].".php";

    if(file_exists($archivo)){
        include $archivo;
    }
}

spl_autoload_register("cargar");


//call_user_func("cargar")
?>