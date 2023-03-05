<?php

namespace Clases\Data;

use \Clases\Data\Individuo as Padre;

class Empleado extends Padre {

    static $nEmpleados = 0;
    protected $nss;
    protected $direccion;
    protected $salario;
    protected $familiares;
    protected $departamento;
    protected $supervisor;

    public function __construct($id, $nif, $nombre, $sexo, $fechaNacimiento,
            $nss, $direccion, $salario, $familiares, $departamento, $supervisor) {
        parent::__construct($id, $nif, $nombre, $sexo, $fechaNacimiento);
        $this->nss = $nss;
        $this->direccion = $direccion;
        $this->salario = $salario;
        $this->familiares = $familiares;
        $this->departamento = $departamento;
        $this->supervisor = $supervisor;
        self::$nEmpleados++;
    }

    public function __destruct() {
        self::$nEmpleados--;
    }

    public function __toString() {
        $msg = "<ul>";
        $msg .= parent::__toString();
        $msg .= "<li>ID:" . $this->nss . "</li>"
                . "<li>NIF:" . $this->direccion . "</li>"
                . "<li>Nombre:" . $this->salario . "</li>"
                . "<li>Departamento: <ul>" . $this->departamento . " </ul></li>"
                . "<li>Supervisor: <ul>" . $this->supervisor . " </ul> </li>";
        if (gettype($this->familiares) == "array") {
            $msg .= "<li>Familiares: " . count($this->familiares) . " </li>";
            foreach ($this->familiares as $pariente) {
                $msg .= "<ul>" . $pariente . "</ul>";
            }
        } else if (gettype($this->familiares) == "string") {
            $msg .= "<li>Familiares: " . $this->familiares . " </li>";
        }

        $msg .= "</ul>";
        return $msg;
    }

}

?>