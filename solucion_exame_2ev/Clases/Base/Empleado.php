<?php

namespace Base;

use \Base\Individuo as Individuo;

class Empleado extends Individuo {

    static $num_empleados = 0;
    protected $nss;
    protected $direccion;
    protected $salario;
    protected $departamento;
    protected $supervisor;
    protected $familiares = array();

    function __construct($id, $nif, $nombre, $sexo, $fecha_nac, $nss, $direccion, $salario, $departamento, $supervisor, $familiares) {
        parent::__construct($id, $nif, $nombre, $sexo, $fecha_nac);
        $this->nss = $nss;
        $this->direccion = $direccion;
        $this->salario = $salario;
        $this->departamento = $departamento;
        $this->supervisor = $supervisor;
        $this->familiares = $familiares;
        ++self::$num_empleados;
    }

    public function __destruct() {
        --self::$num_empleados;
    }

    public function __toString() {
        $datos = '<ul><li>ID: ' . $this->id
                . '</li><li>NIF: ' . $this->nif
                . '</li><li>Nombre: ' . $this->nombre
                . '</li><li>Sexo: ' . $this->sexo
                . '</li><li>Fecha Nacimiento: ' . $this->fecha_nac
                . '</li><li>NSS: ' . $this->nss
                . '</li><li>Direccion: ' . $this->direccion
                . '</li><li>Salario: ' . $this->salario
                . '</li><li>Departamento: ' . $this->departamento
                . '</li><li>Supervisor: ' . $this->supervisor
                . '</li><li>Familiares:<ul>';

        foreach ($this->familiares as $value) {
            $datos .= $value;
        }
        $datos .= '</ul></li>';

        return $datos;
    }

}
