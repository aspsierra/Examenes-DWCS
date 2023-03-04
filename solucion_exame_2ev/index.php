<?php
require_once 'autoload.php';

use \DB\operacionesBBDD as con;

$db = new con;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
            <form>
                <!--Select-->
                <select name = "empleado">
                    <?php
                    echo $db->obtenerIDs_Empleados();
                    ?>
                </select>

                <input type = "submit" name = "Enviar" style = "margin-left: 3px" value = "Enviar"/>
            </form>
            <?php
            if (isset($_POST['Enviar'])) {
                session_start();
                $_SESSION['empleado'] = $_POST['empleado'];
                header("Location: mostrar_datos.php");
            }
            ?>
    </body>
</html>
