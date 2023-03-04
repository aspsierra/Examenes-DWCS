<?php

/**
 * 
 * Archivo de ejemplo donde serializamos y recuperamos los datos de una conexión
 * a la base de datos
 * 
 * Nota: Para usar este ejemplo borrar el archivo "conexion.txt" que se crea en
 * la carpeta "EjemploSerializacion". En la primera ejecución se os creará el
 * archivo y en la siguiente ya se hace uso del mismo para recuperar la conexión
 * sin tener que crear un objecto de forma manual.
 */
require_once __DIR__ . '/../autoload.php';

use DB\operacionesBBDD as db;

// Comprobamos si no existe el fichero con los datos de la conexion selizada
if (!file_exists('conexion.txt')) {

    echo '<h1>Serializamos una conexión a la Base de Datos</h1>';

    $con = new db; // Creamos la conexión
    // Serializamos la conexión donde guardamos todos los datos menos el puntero de la conexión
    $serial = serialize($con);

    // Mostramos por pantalla los datos serializados
    echo 'Datos de la conexión serializada:';
    var_dump($serial);

    // Guardamos los datos de la conexion serializada en un archivo .txt
    $fp = fopen("conexion.txt", "w");
    fwrite($fp, $serial);
    fclose($fp);
    unset($con); // Cerramos la conexión
} else {

    echo '<h1>Conexión desde fichero serializado</h1>';

    /**
     * Recuperamos la información del fichero
     * 
     * Empleamos los siguientes métidos
     *   file — Transfiere un fichero completo a un array
     *      Referencia: https://www.php.net/manual/es/function.file.php
     *  implode — Une elementos de un array en un string
     *      Referencia: https://www.php.net/manual/es/function.implode
     *  Signo @ delante de file es un operador de control de errores
     *      Referencia: https://www.php.net/manual/es/language.operators.errorcontrol.php
     */
    $array_conexion = implode("", @file("conexion.txt"));

    // Mostramos los datos de conexion una vez los tenemos deselizados 
    echo 'Datos de la conexión deserializada:';

    /**
     * Deserializamos los datos de la conexión y al momento de hacerlo
     * se nos creará un nuevo puntero PDO realizando una llamada al método 
     * connect() que estable una conexión a la base de datos 
     */
    $a = unserialize($array_conexion);

    var_dump($a);
}



