<?php

namespace Clases\Data;

use \Clases\Data\Individuo as Padre;

final class Familiar extends Padre {
    
    static $nRelatives = 0;
    private $parentesco;
    private $empleado;

    public function __construct($id, $nif, $nombre, $sexo, $fechaNacimiento, $parentesco, $empleado) {
        parent::__construct($id, $nif, $nombre, $sexo, $fechaNacimiento);
        $this->parentesco = $parentesco;
        $this->empleado = $empleado;
        self::$nRelatives++;
    }

    public function __destruct() {
        self::$nRelatives--;
    }

    public function __toString() {
        return parent::__toString() . ""
                . "<li>Parentesco:" . $this->parentesco . "</li>";
               
    }

}

?>