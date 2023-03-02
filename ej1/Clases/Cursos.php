<?php

namespace Clases;

use \Clases\Base as base;
use \Interfaces\CambiaEspecialidad as change;

Class Cursos Extends base implements change {

    static $id = 0;
    protected $especialidad;
    protected $dificultad;

    public function __construct($nombre, $nota, $esp, $dif) {       
        $this->especialidad = $esp;
        $this->dificultad = $dif;
        self::$id++;
        parent::__construct($nombre, $nota);
    }

    public function __clone() {
        $this->dificultad = "Intermedia";
        $this->nombre = "";
        self::$id++;
    }

    public function __destruct() {
        self::$id--;
    }

    public function cambio($param) {
        $this->especialidad = $param;
    }

    public function __toString() {

        return "Curso nº ". self::$id ."<br>"
                . "Nombre: $this->nombre <br>"
                . "Especialidad: $this->especialidad <br>"
                . "Dificultad: $this->dificultad <br>"
                . "Nota: $this->nota";
    }

}

?>
