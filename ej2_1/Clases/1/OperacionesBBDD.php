<?php

declare (strict_types=1);

namespace Clases\BBDD;

use \Clases\Base\Familiares as Familia;
use \Clases\Base\Empleado as Empleado;
use \Clases\Base\Departamento as Departamento;
use \Clases\Base\Base as Supervisor;

class OperacionesBBDD {

    private $nombreBBDD;
    private $usuario;
    private $pwd;
    private $servidor;
    private $pdo;

    public function __construct() {    
        $DBConfig = $this->leer_configuracion(__DIR__ . '\..\..\ConfigBBDD\configuracion.xml', __DIR__ . '\..\..\ConfigBBDD\configuracion.xsd');

        $this->nombreBBDD = $DBConfig['nombreBD'];
        $this->usuario = $DBConfig['user'];
        $this->pwd = $DBConfig['pass'];
        $this->servidor = $DBConfig['servidor'];
        $this->pdo = $this->conexion();
    }

    public function leer_configuracion(string $xmlRoute, string $xsdRoute) {
        $config = new \DOMDocument();
        $config->load($xmlRoute);

        if (!$config->schemaValidate($xsdRoute)) {
            throw new \Exception("Archivo no válido");
        }

        $xmlFile = simplexml_load_file($xmlRoute);

        return [
            "servidor" => $xmlFile->xpath('//servidor')[0],
            "nombreBD" => $xmlFile->xpath('//nombre')[0],
            "user" => $xmlFile->xpath('//usuario')[0],
            "pass" => $xmlFile->xpath('//clave')[0],
        ];
    }

    public function conexion() {
        try {
            $pdo = new \PDO("mysql:dbname=" . $this->nombreBBDD . ";host=" . $this->servidor, "$this->usuario", "$this->pwd");

            return $pdo;
        } catch (\PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function __serialize(): array {
        return [
            'nombreBBDD' => "$this->nombreBBDD",
            'usuario' => "$this->usuario",
            'pwd' => "$this->pwd",
            'servidor' => "$this->servidor"
        ];
    }

    public function __unserialize(array $data) {
        $this->nombreBBDD = $data['nombreBBDD'];
        $this->usuario = $data['usuario'];
        $this->pwd = $data['pwd'];
        $this->servidor = $data['servidor'];
        $this->pdo = $this->conexion();
    }

    public function __destruct() {
        unset($this->pdo);
    }

    public function __toString() {       
    }

    public function borrar_familiares(int $idEmpleado) {
        $stmt = "DELETE FROM familiares WHERE EMPLEADO = :id ";

        try {
            $this->pdo->beginTransaction();

            $delete = $this->pdo->prepare($stmt);
            $delete->bindParam(':id', $idEmpleado, PDO::PARAM_INT);
            $delete->execute();
            $this->pdo->commit();
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
        }
    }

    public function buscar_datos_empleados( int $id) {
        $stmnt = "SELECT * FROM empleados WHERE ID_EMPLEADO = ?";
        if ($data = $this->pdo->prepare($stmnt)) {
            $data->bindParam(1, $id, \PDO::PARAM_INT);
            $data->execute();
            if ($res = $data->fetch(\PDO::FETCH_ASSOC)) {
                $familia = $this->buscarFamiliar($id);
                $departamento = $this->buscarDepartamentos($id);
                $supervisor = isset($res['SUPERVISOR']) ? $this->BuscarSupervisor($res['SUPERVISOR']) : "No tiene supervisor";
                $empleado = new Empleado($res['ID_EMPLEADO'],
                        $res['NIF'], $res['NOMBRE'], $res['SEXO'],
                        $res['FECHA_NAC'], $res['NSS'], $res['DIRECCION'],
                        $res['SALARIO'], $departamento, $supervisor, $familia);
            }
        };
        unset($data);
        return($empleado);
    }

    public function buscarFamiliar( int $id) {

        $stmnt = "SELECT * FROM familiares WHERE EMPLEADO = ?";
        $familiares = array();

        if ($data = $this->pdo->prepare($stmnt)) {
            $data->bindParam(1, $id, \PDO::PARAM_INT);
            $data->execute();
            while ($res = $data->fetch(\PDO::FETCH_ASSOC)) {
                array_push($familiares, new Familia($res['ID_FAMILIA'],
                                $res['NIF'],
                                $res['NOMBRE'],
                                $res['SEXO'],
                                $res['FECHA_NAC'],
                                $res['PARENTESCO'],
                                $res['EMPLEADO']));
            }
        }

        unset($data);
        return $familiares;
    }

    public function buscarDepartamentos( int $id) {
        $stmnt = "SELECT NUMERO, NOMBRE FROM departamentos WHERE NUMERO = ?";
        $departamento = null;
        if ($data = $this->pdo->prepare($stmnt)) {
            $data->bindParam(1, $id, \PDO::PARAM_INT);
            $data->execute();
            while ($res = $data->fetch(\PDO::FETCH_ASSOC)) {
                $departamento = new Departamento($res['NUMERO'], $res['NOMBRE']);
            }
        }

        unset($data);
        return $departamento;
    }

    public function BuscarSupervisor($id) {
        $stmnt = "SELECT * FROM empleados WHERE ID_EMPLEADO = ?";
        $supervisor = null;
        if ($data = $this->pdo->prepare($stmnt)) {
            $data->bindParam(1, $id, \PDO::PARAM_INT);
            $data->execute();
            if ($res = $data->fetch(\PDO::FETCH_ASSOC)) {
                $supervisor = new Supervisor($res['ID_EMPLEADO'],
                        $res['NIF'], $res['NOMBRE'], $res['SEXO'],
                        $res['FECHA_NAC']);
            }
        };
        unset($data);
        return($supervisor);
    }

    public function buscarNombresIDsEmpleados() {
        $stmnt = "SELECT ID_EMPLEADO, NOMBRE FROM empleados";
        $arEmpleados = array();
        if ($data = $this->pdo->query($stmnt)) {
            while ($fila = $data->fetch(\PDO::FETCH_ASSOC)) {
                array_push($arEmpleados, ['id' => $fila['ID_EMPLEADO'], 'nombre' => $fila['NOMBRE']]);
            }
        }
        unset($data);
        return $arEmpleados;
    }

}

?>