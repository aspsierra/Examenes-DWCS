<?php

namespace Clases\Base;

class Departamento{
    private $numero;
    private $nombre;
    
    public function __construct($numero,$nombre) {
        $this->numero=$numero;
        $this->nombre=$nombre;
    }
    
    public function __destruct() {
        
    }
    
    public function __toString() {
        return "<ul><li>Número: " . $this->numero. "</li>"
                . "<li>Nombre: " . $this->nombre. "</li></ul>";
    }
}

?>