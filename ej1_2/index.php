<?php

include_once 'autoload.php';

use \Clases\Curso as Course;
use \Clases\Materia as Subject;
use \Alumno\Alumno as Student;


echo "<br><br> <b> Creo un curso </b> <br><br>";
$curso = new Course("DAW", 7, "Informática", "Alta");
echo $curso;

echo "<br><br> <b> Lo clono y le asigno un nombre al clonado </b> <br><br>";
$cursoClon = clone $curso;
$cursoClon->cambio("DAM");
echo $cursoClon;

echo "<br><br> <b>Elimino el clon y creo uno nuevo</b> <br><br>";
unset($cursoClon);
$curso2 = new Course("AUROIN", 8, "Electricidad", "Intermedia");
echo $curso2;

echo "<br><br> <b>Ahora creo un alumno y le asigno unas cuantas materias y cursos</b> <br><br>";
$alumno = new Student("Paco");
$alumno[] = $curso;
$alumno[] = $curso2;
$alumno[] = new Subject("SPA", 5, "AUROIN", "2º");
$alumno[] = new Subject("DWCC", 9, "DAW", "2º");
echo $alumno;

echo "<br><br> <b>Ordeno las materias del alumno</b> <br><br>";
$alumno->ordenar();
echo $alumno;



?>