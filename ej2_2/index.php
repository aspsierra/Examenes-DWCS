<?php
session_start();
require_once 'autoload.php';

use \Clases\BD\OperacionesBBDD as BBDD;

$pdo = new BBDD();
$listaEmpleados=$pdo->buscarIdsEmpleados();

if(isset($_POST['enviar'])){
    
    $_SESSION['BD']= serialize($pdo);
    header("Location:mostrar_datos.php?id=".$_POST['empleados']);
     
}

unset($pdo);

?>



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen</title>
</head>

<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <select name="empleados" id="empleados">
            
            <?php
            if(isset($listaEmpleados)){
                foreach ($listaEmpleados as $empleado) {
                    echo "<option value=".$empleado[0].">".$empleado[1]."</option>";
                }
            }
            ?>
            <option value=""></option>
        </select>

        <input type="submit" name="enviar" value="Buscar">

    </form>

</body>

</html>

