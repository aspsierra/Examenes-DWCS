<?php

declare(strict_types=1);

namespace Traits;

Trait Ordenacion {

    public function ordenar() {
        try {

            usort($this->arMateriasCursos, [$this,"cmp"]);
        } catch (TypeError $exc) {
            echo "Error " . $exc->getCode() . ": " . $exc->getMessage();
        } catch (Exception $exc) {
            echo "Error " . $exc->getCode() . ": " . $exc->getMessage();
        }
    }

    function cmp(object $a, object $b) {
        if ($a->getNota() == $b->getNota()) {
            return 0;
        }
        return ($a->getNota() > $b->getNota()) ? -1 : 1;
    }

}

?>