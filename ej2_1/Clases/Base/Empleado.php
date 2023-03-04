<?php

namespace Clases\Base;

use \Clases\Base\Base as Padre;

Class Empleado extends Padre {

    static $nEmpleados = 0;
    private $nss;
    private $direccion;
    private $salario;
    private $departamento;
    private $supervisor;
    private $familiares = [];

    public function __construct($id, $nif, $name, $sex, $date, $nss, $dir, $sal, $dep, $sup, $fam) {
        parent::__construct($id, $nif, $name, $sex, $date);
        $this->nss = $nss;
        $this->direccion = $dir;
        $this->salario = $sal;
        $this->departamento = $dep;
        $this->supervisor = $sup;
        $this->familiares = $fam;
        self::$nEmpleados++;
    }

    public function __destruct() {
        self::$nEmpleados--;
    }

    public function __toString() {
        
        $msg = "<ul>";
        $msg .= "<li>ID: " . $this->id . "</li>";
        $msg .= "<li>NIF: " . $this->nif . "</li>";
        $msg .= "<li>Nombre: " . $this->nombre . "</li>";
        $msg .= "<li>Sexo: " . $this->sexo. "</li>";
        $msg .= "<li>Fecha de nacimiento: " . $this->fechaNac. "</li>";
        $msg .= "<li>NSS: " . $this->nss . "</li>";
        $msg .= "<li>Dirección: " . $this->direccion. "</li>";
        $msg .= "<li>Salario: " . $this->salario. "</li>";
        $msg .= "<li>Departamento: " . $this->departamento. "</li>";
        $msg .= "<li>Supervisor: " . $this->supervisor. "</li>";
        foreach ($this->familiares as $value) {
            $msg .= "<li>Familiares: " . $value. "</li>";
        }       
        return $msg;
    }

}

?>