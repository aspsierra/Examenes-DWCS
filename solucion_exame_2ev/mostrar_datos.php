<?php

require_once 'autoload.php';

use \DB\operacionesBBDD as con;

$db = new con;

session_start();

if (isset($_SESSION['empleado'])) {

    $id_empleado = $_SESSION['empleado'];
    echo $db->buscar_datos_empleado($id_empleado);
} else {
    header('Location: index.php');
}
