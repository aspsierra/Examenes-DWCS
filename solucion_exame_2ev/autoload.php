<?php

spl_autoload_register(function ($clase) {

    $file = __DIR__ . DIRECTORY_SEPARATOR . 'Clases' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $clase) . ".php";

    // Comprobamos que la variable $file no esté vacia
    if ($file != "") {
        if (file_exists($file)) { // Comprobamos si el archivo existe
            include $file;
        }
    }
});

