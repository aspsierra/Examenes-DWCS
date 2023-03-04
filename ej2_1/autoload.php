<?php

spl_autoload_register(function ($class) {
    try {
        $file = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        //throw new Exception("Archivo no encontrado, $file");
        if (file_exists($file)) {
            include $file;
        }else{
            throw new Exception("Archivo no encontrado, $file");
        }
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
})
?>