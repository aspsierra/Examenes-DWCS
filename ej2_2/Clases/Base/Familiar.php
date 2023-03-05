<?php

namespace Clases\Base;
use \Clases\Base\Individuo as Padre;

final class Familiar extends Padre{
    private $parentesco;
    private $empleado;
    
    public function __construct($id, $nif, $nombre, $sexo, $fecha_nac ,
            $parentesco, $empleado) {
        parent::__construct($id, $nif, $nombre, $sexo, $fecha_nac);
        $this->parentesco=$parentesco;
        $this->empleado=$empleado;
    }
    
    public function __destruct() {
        
    }
    
    public function __toString() {
        return "<ul>" . parent::__toString() .
                "<li>Parentesco: " . $this->parentesco . "</li>"
                . "</ul>";
    }
}

?>