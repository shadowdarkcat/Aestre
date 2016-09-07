<?php

/**
 * Description of BeanLicencia
 *
 * @author ShadowDarkCat
 */
class BeanLicencia {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $idLicencia;
    private $licencia;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getIdLicencia() {
        return $this->idLicencia;
    }

    public function getLicencia() {
        return $this->licencia;
    }

    public function setIdLicencia($idLicencia) {
        $this->idLicencia = $idLicencia;
    }

    public function setLicencia($licencia) {
        $this->licencia = $licencia;
    }

    //</editor-fold>
}
