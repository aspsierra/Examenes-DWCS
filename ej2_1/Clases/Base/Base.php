<?php

namespace Clases\Base;

Class Base {

    protected $id;
    protected $nif;
    protected $nombre;
    protected $sexo;
    protected $fechaNac;

    public function __construct($id,$nif,$name,$sex,$date) {
        $this->id=$id;
        $this->nif=$nif;
        $this->nombre=$name;
        $this->sexo=$sex;
        $this->fechaNac=$date;
    }

    public function __destruct() {
        
    }

    function __toString() {
        $msg = "<ul>";
        $msg .= "<li>ID: " . $this->id . "</li>";
        $msg .= "<li>NIF: " . $this->nif . "</li>";
        $msg .= "<li>Nombre: " . $this->nombre . "</li>";
        $msg .= "<li>Sexo: " . $this->sexo. "</li>";
        $msg .= "<li>Fecha de nacimiento: " . $this->fechaNac. "</li>";
        $msg .= "</ul>";
        return $msg;
    }

}

?>