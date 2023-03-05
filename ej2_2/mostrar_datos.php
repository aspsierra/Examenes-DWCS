<?php

session_start();
include_once 'autoload.php';

use \Clases\BD\OperacionesBBDD as BBDD;

if(isset($_GET['id'])){
    
    $pdo = unserialize($_SESSION['BD']);
    //$pdo = new BBDD();
    echo $pdo->buscarEmpleados($_GET['id']);
} else {
    header("location:index.php");
}


?>