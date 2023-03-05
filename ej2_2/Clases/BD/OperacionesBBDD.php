<?php

namespace Clases\BD;

use \Clases\Base\Familiar as Familia;
use \Clases\Base\Empleado as Empleado;
use \Clases\Base\Individuo as Supervisor;
use \Clases\Base\Departamento as Departamento;

class OperacionesBBDD {

    private $nombre;
    private $usuario;
    private $pwd;
    private $servidor;
    private $pdo;

    public function __construct() {

        $configBD = $this->leerConfiguracion(__DIR__ . "\..\..\ConfigBBDD\configuracion.xml", __DIR__ . "\..\..\ConfigBBDD\configuracion.xsd");
        $this->nombre = $configBD['nombre'];
        $this->usuario = $configBD['usuario'];
        $this->pwd = $configBD['pwd'];
        $this->servidor = $configBD['servidor'];
        $this->pdo = $this->conexion();
    }

    public function leerConfiguracion($xmlRoute, $xsdRoute) {

        $config = new \DOMDocument();
        $config->load($xmlRoute);
        if (!$config->schemaValidate($xsdRoute)) {
            throw new \Exception("ey");
        }

        $xml = simplexml_load_file($xmlRoute);

        return[
            'nombre' => $xml->xpath('//nombre[. ="examen"]')[0] . "",
            'usuario' => $xml->xpath('//usuario')[0] . "",
            'pwd' => $xml->xpath('//clave')[0] . "",
            'servidor' => $xml->xpath('//servidor')[0] . ""
        ];
    }

    public function conexion() {
        try {
            $pdo = new \PDO("mysql:dbname=" . $this->nombre . ";host=" . $this->servidor, $this->usuario, $this->pwd);
            return $pdo;
        } catch (\PDOException $exc) {
            echo("ERROR " . $exc->getCode() . ": " . $exc->getMessage());
        }
        
    }

    public function __destruct() {
        unset($this->pdo);
    }

    public function __serialize() {
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
        $this->pdo = $this->conexion();
    }

    public function borrarFamiliares($idEmpleado) {
        $consulta = "DELETE FROM familiares WHERE EMPLEADO = $idEmpleado";
        try {
            $this->pdo->beginTransaction();
            $stmnt = $this->pdo->prepare($consulta);
            $stmnt->execute();
            $this->pdo->commit();
        } catch (Exception $exc) {
            $this->pdo->rollBack();
            throw $exc;
        } finally {
            unset($stmnt);
        }
    }

    public function buscarEmpleados($idEmpleado) {
        $consulta = "SELECT * FROM empleados WHERE ID_EMPLEADO = :idEmpleado";
        $empleado = null;

        if ($stmnt = $this->pdo->prepare($consulta)) {
            $stmnt->bindParam(':idEmpleado', $idEmpleado, \PDO::PARAM_INT);
            $stmnt->execute();
            if ($respuesta = $stmnt->fetch(\PDO::FETCH_ASSOC)) {
                $familia = $this->buscarFamiliares($respuesta['ID_EMPLEADO']);
                $supervisor = isset($respuesta['SUPERVISOR']) ? $this->buscarSupervisor($respuesta['SUPERVISOR']) : "No tiene supervisor";
                $departamento = $this->buscarDepartamento($respuesta['ID_EMPLEADO']);
                $empleado = new Empleado($respuesta['ID_EMPLEADO'], $respuesta['NIF'],
                        $respuesta['NOMBRE'], $respuesta['SEXO'], $respuesta['FECHA_NAC'],
                        $respuesta['NSS'], $respuesta['DIRECCION'], $respuesta['SALARIO'], $departamento, $familia, $supervisor);
            }
        }

        return $empleado;
    }

    public function buscarFamiliares($idEmpleado) {
        $consulta = "SELECT * FROM familiares WHERE EMPLEADO = :idEmpleado";
        $familia = [];

        if ($stmnt = $this->pdo->prepare($consulta)) {
            $stmnt->bindParam('idEmpleado', $idEmpleado, \PDO::PARAM_INT);
            $stmnt->execute();
            while ($respuesta = $stmnt->fetch(\PDO::FETCH_ASSOC)) {
                array_push($familia, new Familia($respuesta['ID_FAMILIA'], $respuesta['NIF'],
                                $respuesta['NOMBRE'], $respuesta['SEXO'], $respuesta['FECHA_NAC'],
                                $respuesta['PARENTESCO'], $respuesta['EMPLEADO']));
            }
        }

        if (count($familia) > 0) {
            return $familia;
        } else {
            return "No tiene familiares registrados";
        }
    }

    public function buscarSupervisor($idSupervisor) {
        $consulta = "SELECT * FROM empleados WHERE ID_EMPLEADO = :idSupervisor";
        $supervisor = "No asociado a ningún supervisor";

        if ($stmnt = $this->pdo->prepare($consulta)) {
            $stmnt->bindParam(':idSupervisor', $idSupervisor, \PDO::PARAM_INT);
            $stmnt->execute();
            if ($respuesta = $stmnt->fetch(\PDO::FETCH_ASSOC)) {
                $supervisor = new Supervisor($respuesta['ID_EMPLEADO'], $respuesta['NIF'],
                        $respuesta['NOMBRE'], $respuesta['SEXO'], $respuesta['FECHA_NAC']);
            }
        }

        return $supervisor;
    }

    public function buscarDepartamento($idDepartamento) {
        $consulta = "SELECT NUMERO, NOMBRE FROM departamentos WHERE NUMERO = :idDepartamento";
        $departamento = "No asociado a ningún departamento";

        if ($stmnt = $this->pdo->prepare($consulta)) {
            $stmnt->bindParam(':idDepartamento', $idDepartamento, \PDO::PARAM_INT);
            $stmnt->execute();
            if ($respuesta = $stmnt->fetch()) {
                $departamento = new Departamento($respuesta['NUMERO'], $respuesta['NOMBRE']);
            }
        }

        return $departamento;
    }
    
    public function buscarIdsEmpleados(){
        $consulta = "SELECT ID_EMPLEADO, NOMBRE FROM empleados";
        $empleados = array();
        if($stmnt = $this->pdo->query($consulta)) {
            while($respuesta= $stmnt->fetch(\PDO::FETCH_ASSOC)){
                array_push($empleados, [$respuesta['ID_EMPLEADO'], $respuesta['NOMBRE']]);
            }
        }
        return $empleados;
    }

}

?>