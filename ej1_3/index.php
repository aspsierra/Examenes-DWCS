<?php

include_once 'autoload.php';

use \Clases\Base\Materia as Subject;
use \Clases\Base\Curso as Course;
use \Clases\Alumno\Alumno as Student;

echo '<br><b>Creo un Curso</b><br>';

$curso = new Course("AUROIN", 8, "Electricidad", "Intermedia");
echo $curso;

echo '<br><b>Lo clono y le cambio la especialidad</b><br>';

$cursoClon = clone $curso;
$cursoClon->cambioNombre("MANELE");
echo $cursoClon;

echo '<br><b>Elimino el clon y creo uno nuevo</b><br>';
unset($cursoClon);
$curso2 = new Course("DAW", 6, "Informática", "Alta");
echo $curso2;

echo '<br><b>Ahora creo un alumno</b><br>';
$alumno = new Student("Paco");
$alumno[] = $curso2;
$alumno[] = new Subject("SPA", 5, "AUROIN", "2º");
$alumno[] = $curso;
$alumno[] = new Subject("DWCC", 7, "DAW", "2º");
echo $alumno;

echo '<br><b>Y ordeno el array de materias y cursos</b><br>';
$alumno->ordenar();
echo $alumno;
?>