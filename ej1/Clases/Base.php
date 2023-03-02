<?php

namespace Clases;

Class Base {

    protected $nombre;
    protected $nota;

    public function __construct($nombre, $nota) {
        $this->nombre = $nombre;
        $this->nota = $nota;
    }
    
    public function getNombre(){
        return $this->nombre;
    }
    
    public function getNota(){
        return $this->nota;
    }

}

?>
