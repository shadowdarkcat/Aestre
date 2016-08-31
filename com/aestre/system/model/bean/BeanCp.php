<?php

/**
 * Description of BeanCp
 *
 * @author ShadowDarkCat
 */
class BeanCp {
    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $idCp;
    private $cp;
    private $col;
    private $delegacion;
    private $municipio;
    private $estado;
    private $ciudad;
    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getIdCp() {
        return $this->idCp;
    }

    public function getCp() {
        return $this->cp;
    }

    public function getCol() {
        return $this->col;
    }

    public function getDelegacion() {
        return $this->delegacion;
    }

    public function getMunicipio() {
        return $this->municipio;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function setIdCp($idCp) {
        $this->idCp = $idCp;
    }

    public function setCp($cp) {
        $this->cp = $cp;
    }

    public function setCol($col) {
        $this->col = $col;
    }

    public function setDelegacion($delegacion) {
        $this->delegacion = $delegacion;
    }

    public function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }
    //</editor-fold>
}
