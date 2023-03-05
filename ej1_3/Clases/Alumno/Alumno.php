<?php

namespace Clases\Alumno;

use \Traits\Orden as OrdenNota;

class Alumno implements \ArrayAccess {

    use OrdenNota;

    private $nombre;
    private $arCursosMaterias = array();

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->arCursosMaterias[$offset]);
    }

    public function offsetGet(mixed $offset): mixed {
        return $this->arCursosMaterias[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void {
        if (isset($offset)) {
            $this->arCursosMaterias[$offset] = $value;
        } else {
            $this->arCursosMaterias[] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void {
        unset($this->arCursosMaterias[$offset]);
    }

    public function __toString() {

        $msg = "Nombre: " . $this->nombre . "<br>"
                . "Materias y Cursos realizados:<ul>";
        foreach ($this->arCursosMaterias as $item) {
            if (get_class($item) == "Clases\Base\Curso")
                $msg .= "<li>Curso, " . $item->getNombre() . ", Nota: " . $item->getNota() . "</li>";
            else
                $msg .= "<li>Materia, " . $item->getNombre() . ", Nota: " . $item->getNota() . "</li>";
        }
        $msg .= "</ul>";

        return $msg;
    }

}

?>