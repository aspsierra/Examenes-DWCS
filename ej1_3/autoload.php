<?php

function load($nombre) {
    try {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $nombre) . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            throw new Exception("Archivo no encontrado, $file");
        }
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
}

spl_autoload_register("load");
?>