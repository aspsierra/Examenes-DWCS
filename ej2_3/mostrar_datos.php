<?php

session_start();

include_once 'autoload.php';

use Clases\BD\OperacionesBBDD as BD;

if (isset($_GET['id'])) {
    $pdo = unserialize($_SESSION['BD']);
    echo($pdo->buscar_datos_empleados($_GET['id']));
} else {
    header('Location:index.php');
}
?>