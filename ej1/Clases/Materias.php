<?php

namespace Clases;

use \Clases\Base as base;

Class Materias Extends Base {

    static $id = 0;
    protected $ciclo;
    protected $curso;

    public function __construct($nombre, $nota, $ciclo, $curso) {
        parent::__construct($nombre, $nota);
        $this->ciclo = $ciclo;
        $this->curso = $curso;
        self::$id++;
    }

    public function __destruct() {
        self::$id--;
    }
    
    public function __toString() {
        
        return "Materia nº " . self::$id."<br>"
                . "Nombre: $this->nombre <br>"
                . "Ciclo: $this->ciclo <br>"
                . "Curso: $this->curso <br>"
                . "Nota: $this->nota";
        
    }

}

?>
