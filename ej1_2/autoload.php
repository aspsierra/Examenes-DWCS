<?php

function load($nombre) {

    $file = str_replace('\\', DIRECTORY_SEPARATOR, $nombre) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
}

spl_autoload_register("load");
?>