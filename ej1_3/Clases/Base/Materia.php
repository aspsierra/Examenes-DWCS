<?php

namespace Clases\Base;

use \Clases\Base\Base as Padre;
use \Interfaces\Cambio as CambiaCiclo;

class Materia extends Padre implements CambiaCiclo {

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

    public function cambioNombre($nombre) {
        $this->ciclo = $nombre;
    }

    public function __toString() {
        return parent::__toString() . ""
                . "Ciclo: " . $this->ciclo . "<br>"
                . "Curso: " . $this->curso . "<br>"
                . "Código: " . self::$id . "<br>";
    }

}

?>