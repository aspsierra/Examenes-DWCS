<?php

namespace Alumno;
use \Traits\Ordenacion as Ordenacion;

Class Alumno implements \ArrayAccess{
    
    use Ordenacion;
    
    private $nombre;
    private $arMateriasCursos = [];
    
    public function __construct($nombre) {
        $this->nombre=$nombre;
    }
    
    public function offsetExists($offset){
        return isset($this->$arMateriasCursos[$offset]);
    }
    public function offsetGet($offset){
        return $this->arMateriasCursos[$offset];
    }
    public function offsetSet($offset,$value){
        if($offset){
            $this->arMateriasCursos[$offset]=$value;
        } else {
            $this->arMateriasCursos[]=$value;
        }
        
    }
    public function  offsetUnset($offset){
        unset($this->arMateriasCursos[$offset]);
    }
   
    public function __toString(){
        $materias = "<ul>";
        foreach ($this->arMateriasCursos as $item) {
            $materias .= "<li>" . $item->getNombre() . ", nota: ". $item->getNota() ."</li>";
        }
        $materias .="</ul>";
        return "Nombre: " . $this->nombre ."<br>"
                . "Cursos y materias asociados: <br>"
                . $materias;
    }
    
}
?>
