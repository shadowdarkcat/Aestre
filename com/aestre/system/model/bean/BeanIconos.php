<?php

/**
 * Description of BeanIconos
 *
 * @author ShadowDarkCat
 */
class BeanIconos {
    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $idIcono;
    private $pathIcono;
    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getIdIcono() {
        return $this->idIcono;
    }

    public function getPathIcono() {
        return $this->pathIcono;
    }

    public function setIdIcono($idIcono) {
        $this->idIcono = $idIcono;
    }

    public function setPathIcono($pathIcono) {
        $this->pathIcono = $pathIcono;
    }
    //</editor-fold>
}
