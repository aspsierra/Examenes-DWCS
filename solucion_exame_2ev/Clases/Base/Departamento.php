<?php

namespace Base;

class Departamento {

    protected $numero;
    protected $nombre;
    protected $director;
    protected $prima_sueldo;
    protected $fecha_inicio;

    function __construct($numero, $nombre, $director, $prima_sueldo, $fecha_inicio) {
        $this->numero = $numero;
        $this->nombre = $nombre;
        $this->director = $director;
        $this->prima_sueldo = $prima_sueldo;
        $this->fecha_inicio = $fecha_inicio;
    }

}
