<?php

/**
 * Description of BeanGiro
 *
 * @author ShadowDarkCat
 */
class BeanGiro {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $idGiro;
    private $giro;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getIdGiro() {
        return $this->idGiro;
    }

    public function getGiro() {
        return $this->giro;
    }

    public function setIdGiro($idGiro) {
        $this->idGiro = $idGiro;
    }

    public function setGiro($giro) {
        $this->giro = $giro;
    }

    //</editor-fold>
}
