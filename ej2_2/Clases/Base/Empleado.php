<?php

namespace Clases\Base;

use Clases\Base\Individuo as Padre;

class Empleado extends Padre {

    static $nEmpleados = 0;
    protected $nss;
    protected $direccion;
    protected $salario;
    protected $departamento;
    protected $familiares;
    protected $supervisor;

    public function __construct($id, $nif, $nombre, $sexo, $fecha_nac,
            $nss, $direccion, $salario, $departamento, $familiares, $supervisor) {
        parent::__construct($id, $nif, $nombre, $sexo, $fecha_nac);
        $this->nss = $nss;
        $this->direccion = $direccion;
        $this->departamento = $departamento;
        $this->familiares = $familiares;
        $this->supervisor = $supervisor;
        self::$nEmpleados++;
    }

    public function __destruct() {
        self::$nEmpleados--;
    }

    public function __toString() {
        $msg = "<ul>";
        $msg .= parent::__toString();
        $msg .= "<li>NSS: " . $this->nss . "</li>"
                . "<li>Dirección: " . $this->direccion . "</li>";
        $msg .= "<li>Departamento:" . $this->departamento . "</li>";
        $msg .= "<li>Supervisor: <ul>" . $this->supervisor . "</ul></li>";
        $msg .= "<li>Familiares: ";
        if (gettype($this->familiares) == "array") {
            foreach ($this->familiares as $pariente) {
                $msg .= $pariente;
            }
        } else {
         $msg .= $this->familiares;   
        }

        $msg .= "</li></ul>";
        return $msg;
    }

}
?>

