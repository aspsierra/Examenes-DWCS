<?php

namespace Clases;

use \Clases\Base as Padre;
use \Interfaces\Cambio as CambioEsp;

Class Curso Extends Padre Implements CambioEsp {

    static $id = 0;
    private $especialidad;
    private $dificultad;

    public function __construct($name, $nota, $esp, $dif) {
        parent::__construct($name, $nota);
        $this->dificultad = $dif;
        $this->especialidad = $esp;
        self::$id++;
    }

    public function __destruct() {
        self::$id--;
    }

    public function __clone() {
        $this->dificultad = "Intermedio";
        $this->nombre = "";
        self::$id++;
    }

    public function cambio($nombre) {
        $this->especialidad = $nombre;
    }

    public function __toString() {
        $msg = "Curso nº " . self::$id . "<br>";
        $msg .= parent::__toString() . "<br>";
        $msg .= "Especialidad: " . $this->especialidad . "<br>"
                . "Dificultad: " . $this->dificultad . "<br>";
        return $msg;
    }

}

?>