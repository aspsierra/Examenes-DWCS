<?php
session_start();
include_once 'autoload.php';

use \Clases\BBDD\OperacionesBBDD as bd;



if(isset($_GET['id'])){
    $pdo = unserialize($_SESSION['BD']);
    var_dump($pdo);
    echo $pdo->buscar_datos_empleados($_GET['id']);
}

?>