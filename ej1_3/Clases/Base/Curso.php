<?php

namespace Clases\Base;

use \Clases\Base\Base as Padre;
use \Interfaces\Cambio as CambioEsp;

class Curso extends Padre implements CambioEsp {

    static $id = 0;
    protected $especialidad;
    protected $dificultad;

    public function __construct($nombre, $nota, $especialidad, $dificultad) {
        parent::__construct($nombre, $nota);
        $this->especialidad = $especialidad;
        $this->dificultad = $dificultad;
        self::$id++;
    }

    public function __destruct() {
        self::$id--;
    }

    public function cambioNombre($nombre) {
        $this->especialidad = $nombre;
    }

    public function __clone() {
        $this->dificultad = "Intermedio";
        $this->nombre = "";
        self::$id++;
    }

    public function __toString() {
        return parent::__toString() . ""
                . "Especialidad: " . $this->especialidad . "<br>"
                . "Dificultad: " . $this->dificultad . "<br>"
                . "Código: " . self::$id . "<br>";
    }

}

?>