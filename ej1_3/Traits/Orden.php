<?php

declare (strict_types=1);

namespace Traits;

trait Orden {

    public function ordenar() {
        try {
            usort($this->arCursosMaterias, function (object $a, object $b) {
                if ($a->getNota() == $b->getNota()) {
                    return 0;
                }
                return ($a->getNota() > $b->getNota()) ? -1 : 1;
            });
        } catch (\TypeError $exc) {
            echo $exc->getMessage();
        } catch (\Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
?>

