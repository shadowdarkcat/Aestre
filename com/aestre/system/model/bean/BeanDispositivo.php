<?php

/**
 * Description of BeanDispositivo
 *
 * @author ShadowDarkCat
 */
class BeanDispositivo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $idDispositivo;
    private $dispositivo;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getIdDispositivo() {
        return $this->idDispositivo;
    }

    public function getDispositivo() {
        return $this->dispositivo;
    }

    public function setIdDispositivo($idDispositivo) {
        $this->idDispositivo = $idDispositivo;
    }

    public function setDispositivo($dispositivo) {
        $this->dispositivo = $dispositivo;
    }

    //</editor-fold>
}
