<?php

namespace Base;

class Individuo {

    protected $id;
    protected $nif;
    protected $nombre;
    protected $sexo;
    protected $fecha_nac;

    function __construct($id, $nif, $nombre, $sexo, $fecha_nac) {
        $this->id = $id;
        $this->nif = $nif;
        $this->nombre = $nombre;
        $this->sexo = $sexo;
        $this->fecha_nac = $fecha_nac;
    }

    function __toString() {
        return '<ul><li>ID: ' . $this->id . ', NIF: ' . $this->nif
                . ', Nombre: ' . $this->nombre . ', Sexo: ' . $this->sexo
                . ', Fecha Nacimiento: ' . $this->fecha_nac . '</li></ul>';
    }

}
