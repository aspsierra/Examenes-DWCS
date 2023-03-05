<?php

spl_autoload_register(function ($nombres) {
    try {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $nombres) . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            throw new Exception("Archivo no encontrado, $file");
        }
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }

    
})
?>