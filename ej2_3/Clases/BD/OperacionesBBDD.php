<?php

declare(strict_types=1);

namespace Clases\BD;

use \Clases\Data\Empleado as Employee;
use \Clases\Data\Familiar as Relative;
use \Clases\Data\Departamento as Department;
use \Clases\Data\Individuo as Supervisor;

class OperacionesBBDD {

    private $nombre;
    private $usuario;
    private $pwd;
    private $servidor;
    private $pdo;

    public function __construct() {
        $dbConfig = $this->leerConfig(__DIR__ . '\..\..\ConfigBD\configuracion.xml', __DIR__ . '\..\..\ConfigBD\configuracion.xsd');
        $this->nombre = $dbConfig['nombre'];
        $this->pwd = $dbConfig['pwd'];
        $this->servidor = $dbConfig['servidor'];
        $this->usuario = $dbConfig['usuario'];
        $this->pdo = $this->connectDB();
    }

    public function leerConfig(string $xmlRoute, string $xsdRoute): array {
        /*$config = new \DOMDocument();
        $config->load($xmlRoute);
        if (!$config->schemaValidate($xsdRoute)) {
            throw new \Exception("El arcivo .xml no es válido");
        }*/
        $xml = simplexml_load_file($xmlRoute);
        
        var_dump($xml);
        return[
            'nombre' => "" . $xml->xpath('//nombre')[0],
            'usuario' => "".$xml->xpath('//nombreUser[../rol="estandar"]')[0],
            'pwd' => "".$xml->xpath('//usuario/clave')[0],
            'servidor' => "" . $xml->xpath('//servidor')[0]
        ];
        
        var_dump($ar);
    }

    public function connectDB(): object {
        try {
            $con = new \PDO("mysql:dbname=$this->nombre;host=$this->servidor",
                    $this->usuario, $this->pwd);
            return $con;
        } catch (\PDOException $ex) {
            echo 'ERROR ' . $ex->getCode() . ", " . $ex->getMessage();
        }
    }

    public function __destruct() {
        unset($this->pdo);
    }

    public function __serialize(): array {
        return [
            'nombre' => $this->nombre,
            'usuario' => $this->usuario,
            'pwd' => $this->pwd,
            'servidor' => $this->servidor
        ];
    }

    public function __unserialize(array $data) {
        $this->nombre = $data['nombre'];
        $this->usuario = $data['usuario'];
        $this->pwd = $data['pwd'];
        $this->servidor = $data['servidor'];
        $this->pdo = $this->connectDB();
    }

    public function borrar_familiares(int $idEmpleado) {
        $consulta = "DELETE FROM familiares WHERE EMPLEADO = :idEmpleado";
        try {
            $this->pdo->beginTransaction();
            $borrados = 0;
            if ($data = $this->pdo->prepare($consulta)) {
                $data->bindParam(':idEmpleado', $idEmpleado, \PDO::PARAM_INT);
                while ($reponse = $data->execute()) {
                    $borrados++;
                }
            }
            $this->pdo->commit();
            unset($data);
            return $borrados;
        } catch (Exception $exc) {
            $this->pdo->rollBack();
            echo 'ERROR ' . $ex->getCode() . ", " . $ex->getMessage();
        }
    }

    public function buscar_datos_empleados(int $idEmpleado) {
        $consult = "SELECT * FROM empleados WHERE ID_EMPLEADO = ?";

        if ($stmnt = $this->pdo->prepare($consult)) {
            $stmnt->bindParam(1, $idEmpleado, \PDO::PARAM_INT);
            $stmnt->execute();
            if ($response = $stmnt->fetch(\PDO::FETCH_ASSOC)) {
                $relatives = $this->searchRelatives($response['ID_EMPLEADO']);
                count($relatives) == 0 ? $relatives = "No tiene familiares registrados" : $relatives = $relatives;
                $response['SUPERVISOR'] != null ? $supervisor = $this->searchSuperior($response['SUPERVISOR']) : $supervisor = "No tiene supervisor asignado";
                $response['DEPARTAMENTO'] != null ? $department = $this->searchDepartment($response['DEPARTAMENTO']) : $department = "No tiene departamento asignado";

                $employee = new Employee($response['ID_EMPLEADO'], $response['NIF'],
                        $response['NOMBRE'], $response['SEXO'], $response['FECHA_NAC'],
                        $response['NSS'], $response['DIRECCION'], $response['SALARIO'],
                        $relatives, $department, $supervisor);
            }
        }

        unset($stmnt);
        return $employee;
    }

    public function searchRelatives(string $idEmpleado): array {
        $relatives = [];
        $consult = "SELECT * FROM familiares WHERE EMPLEADO = ?";

        if ($stmnt = $this->pdo->prepare($consult)) {
            $stmnt->bindParam(1, $idEmpleado, \PDO::PARAM_INT);
            $stmnt->execute();
            while ($row = $stmnt->fetch(\PDO::FETCH_ASSOC)) {
                array_push($relatives, new Relative($row['ID_FAMILIA'], $row['NIF'],
                                $row['NOMBRE'], $row['SEXO'], $row['FECHA_NAC'],
                                $row['PARENTESCO'], $row['EMPLEADO']));
            }
        }
        unset($stmnt);
        return $relatives;
    }

    public function searchSuperior(string $idSuperior): object {
        $consult = "SELECT * FROM empleados WHERE ID_EMPLEADO = ?";

        if ($stmnt = $this->pdo->prepare($consult)) {
            $stmnt->bindParam(1, $idSuperior, \PDO::PARAM_INT);
            $stmnt->execute();
            while ($row = $stmnt->fetch(\PDO::FETCH_ASSOC)) {
                $superior = new Supervisor($row['ID_EMPLEADO'], $row['NIF'],
                        $row['NOMBRE'], $row['SEXO'], $row['FECHA_NAC']);
            }
        }
        unset($stmnt);
        return $superior;
    }

    public function searchDepartment(string $idDepartment): object {
        $consulta = "SELECT NUMERO, NOMBRE, (SELECT NOMBRE FROM empleados WHERE empleados.ID_EMPLEADO = departamentos.DIRECTOR) AS DIRECTOR FROM departamentos WHERE NUMERO = ?";

        if ($stmnt = $this->pdo->prepare($consulta)) {
            $stmnt->bindParam(1, $idDepartment, \PDO::FETCH_ASSOC);
            $stmnt->execute();
            if ($response = $stmnt->fetch(\PDO::FETCH_ASSOC)) {
                $department = new Department($response['NUMERO'], $response['NOMBRE'], $response['DIRECTOR']);
            }
        }
        unset($stmnt);
        return $department;
    }

    public function searchIdNAme(): array {
        $consult = "SELECT ID_EMPLEADO, NOMBRE FROM empleados";
        $arEmployees = [];
        if ($stmnt = $this->pdo->query($consult)) {
            $stmnt->execute();
            while ($row = $stmnt->fetch()) {
                array_push($arEmployees, ['id' => $row[0], 'name' => $row[1]]);
            }
        }

        unset($stmnt);
        return $arEmployees;
    }

}

?>
