<?php

namespace Clases;

use \Clases\Base as Padre;
use Interfaces\Cambio as CambioCiclo;

Class Materia Extends Padre Implements CambioCiclo {

    static $id = 0;
    private $ciclo;
    private $curso;

    public function __construct($name, $nota, $ciclo, $curso) {
        parent::__construct($name, $nota);
        $this->ciclo = $ciclo;
        $this->curso = $curso;
        self::$id++;
    }

    public function __destruct() {
        self::$id--;
    }

    public function cambio($nombre) {
        $this->ciclo = $param;
    }

}

?>