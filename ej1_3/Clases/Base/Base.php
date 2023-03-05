<?php

namespace Clases\Base;

class Base {

    protected $nombre;
    protected $nota;

    public function __construct($nombre, $nota) {
        $this->nombre = $nombre;
        $this->nota = $nota;
    }

    public function __destruct() {
        
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNota() {
        return $this->nota;
    }

    public function __toString() {
        return "Nombre: " . $this->nombre . "<br>"
                . "Nota: " . $this->nota . "<br>";
    }

}

?>