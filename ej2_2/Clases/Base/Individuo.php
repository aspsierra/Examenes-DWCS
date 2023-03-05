<?php

namespace Clases\Base;

class Individuo{
    protected $id;
    protected $nif;
    protected $nombre;
    protected $sexo;
    protected $fechaNacimiento;
    
    public function __construct($id,$nif,$nombre,$sexo,$fechaNacimiento) {
        $this->id=$id;
        $this->nif=$nif;
        $this->nombre=$nombre;
        $this->sexo=$sexo;
        $this->fechaNacimiento=$fechaNacimiento;
    }
    
    public function __destruct() {
        
    }
    
    public function __toString() {
        return "<li>ID: " . $this->id . "</li>"
                . "<li>NIF:: " . $this->nif . "</li>"
                . "<li>Nombre: " . $this->nombre . "</li>"
                . "<li>Sexo: " . $this->sexo . "</li>"
                . "<li>Fecha de nacimiento: " . $this->fechaNacimiento . "</li>";
    }
}
?>
