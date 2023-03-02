<?php

include 'autoload.php';

use \Clases\Cursos as course;
use \Clases\Materias as subject;
use \Alumno\Alumno as student;

echo '<br><br> <b>Declaro un curso</b><br> <br>';
$curso = new course("DAW", 7, "Programación", "Alta");
echo $curso;

echo '<br><br><b> Lo clono </b><br><br>';
$curso2 = clone $curso;
echo $curso2;

echo '<br><br> <b>Declaro una materia</b><br> <br>';
$materia = new subject("DWCS", 5, "DAW", "2º");
echo $materia;

echo '<br><br> <b>Declaro un Alumno</b><br> <br>';

$alumno = new student("Pepe");
$alumno[]=$materia;
$alumno[]=$curso;
$alumno[]=$curso2;
$alumno[]=new course("DIW", 10, "Informática", "Intermedia");


echo $alumno;

echo '<br><br> <b>Y ahora ordeno el array</b><br> <br>';

$alumno->ordenar();

echo $alumno;
?>
    
