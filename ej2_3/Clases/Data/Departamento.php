<?php

namespace Clases\Data;

class Departamento{
    private $numero;
    private $nombre;
    private $director;
    
    public function __construct($numero, $nombre, $director) {
        $this->numero=$numero;
        $this->nombre=$nombre;
        $this->director=$director;
    }
    
    public function __destruct() {
        
    }
    
    public function __toString() {
        return "<li>ID:" . $this->numero . "</li>"
                . "<li>NIF:" . $this->nombre . "</li>"
                . "<li>Nombre:" . $this->director . "</li>";
                
    }
}

?>