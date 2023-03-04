<?php

namespace Clases\Base;

class Departamento {

    protected $num;
    protected $nombre;

    public function __construct($num, $nombre) {
        $this->num=$num;
        $this->nombre=$nombre;
    }

    public function __destruct() {
        
    }
    
    public function __toString() {
        $msg = "<ul>";
        $msg .= "<li>Número: " . $this->num . "</li>";
        $msg .= "<li>Nombre: " . $this->nombre . "</li>";
        $msg .= "</ul>";
        return $msg;
    }

}

?>