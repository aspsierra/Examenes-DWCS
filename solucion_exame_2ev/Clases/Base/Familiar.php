<?php

namespace Base;

use \Base\Individuo as Individuo;

final class Familiar extends Individuo {

    private $parentesco;
    private $id_empleado;

    function __construct($id, $nif, $nombre, $sexo, $fecha_nac, $parentesco, $id_empleado) {
        parent::__construct($id, $nif, $nombre, $sexo, $fecha_nac);
        $this->parentesco = $parentesco;
        $this->id_empleado = $id_empleado;
    }

    function __toString() {
        return '<li>ID: ' . $this->id . ', NIF: ' . $this->nif . ', Nombre: ' . $this->nombre
                . ', Sexo: ' . $this->sexo . ', Fecha Nacimieto: ' . $this->fecha_nac
                . ', Parentesco: ' . $this->parentesco . ', ID_EMPLEADO: ' . $this->id_empleado;
    }

}
