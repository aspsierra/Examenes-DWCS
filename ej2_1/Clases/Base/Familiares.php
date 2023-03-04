<?php

namespace Clases\Base;

use \Clases\Base\Base as Padre;

final class Familiares extends Padre {

    protected $parentesco;
    protected $idEmpleado;

    public function __construct($id, $nif, $name, $sex, $date, $paren, $idEmp) {
        parent::__construct($id, $nif, $name, $sex, $date);
        $this->parentesco = $paren;
        $this->idEmpleado = $idEmp;
    }

    public function __destruct() {
        
    }
    
    public function __toString() {
        $msg = "<ul>";
        $msg .= "<li>ID: " . $this->id . "</li>";
        $msg .= "<li>NIF: " . $this->nif . "</li>";
        $msg .= "<li>Nombre: " . $this->nombre . "</li>";
        $msg .= "<li>Parentesco: " . $this->parentesco . "</li>";
        $msg .= "</ul>";
        return $msg;
    }

}

?>