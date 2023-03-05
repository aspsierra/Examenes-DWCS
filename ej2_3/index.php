<?php
session_start();
include_once 'autoload.php';
use \Clases\BD\OperacionesBBDD as BD;

$pdo = new BD();

$arEmployees = $pdo->searchIdNAme();

if(isset($_POST['enviar'])){
    
    $_SESSION['BD'] = serialize($pdo);
    header('Location:mostrar_datos.php?id=' . $_POST['empleados'] );
    
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

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">

        <select name="empleados" id="empleados">
            <?php
            if(isset($arEmployees)){
                foreach ($arEmployees as $employee) {
                    echo "<option value=" . $employee['id'] . ">" . $employee['name'] . "</option>";
                }
            }
            ?>
        </select>

        <input type="submit" name="enviar" value="Buscar">

    </form>

</body>

</html>