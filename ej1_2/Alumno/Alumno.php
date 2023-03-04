<?php

namespace Alumno;

use \Traits\Orden as Ordenar;

Class Alumno Implements \ArrayAccess {

    use Ordenar;

    private $nombre;
    private $arMateriasCursos = [];

    public function __construct($name) {
        $this->nombre = $name;
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->arMateriasCursos[$offset]);
    }

    public function offsetGet(mixed $offset): mixed {
        return $this->arMateriasCursos[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void {
        if (isset($offset)) {
            $this->arMateriasCursos[$offset] = $value;
        } else {
            $this->arMateriasCursos[] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void {
        unset($this->arMateriasCursos[$offset]);
    }
    
    public function __toString() {
        $msg = "Nombre: " . $this->nombre . "<br>";
        $msg .= "Cursos y materias realizados: <br><ul>";
        foreach ($this->arMateriasCursos as $item) {
            $msg .= "<li>" . $item->getNombre() .", Nota: " .$item->getNota() . "</li>";
        }
        $msg .= "</ul>";
        return $msg;
        
    }

}

?>