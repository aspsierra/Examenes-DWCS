<?php
session_start();

include_once 'autoload.php';

use \Clases\BBDD\OperacionesBBDD as BBDD;

$pdo = new BBDD();

$nombresEmpleados = $pdo->buscarNombresIDsEmpleados();

if(isset($_POST["Enviar"])){
    $_SESSION['BD']=serialize($pdo);
    header("Location:mostrar_datos.php?id=".$_POST['empleado']);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen</title>
    </head>
    <body>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <select name="empleado" id="empleado">
<?php
foreach ($nombresEmpleados as $value) {
    echo "<option value=" . $value['id'] . ">" . $value['nombre'] . "</option>";
}
?>
            </select>

            <input type="submit" name="Enviar" value="Buscar">
        </form>

    </body>
</html>