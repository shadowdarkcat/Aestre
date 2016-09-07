<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of DtoConductor
 *
 * @author ShadowDarkCat
 */
class DtoConductor {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $idConductor;
    private $nombre;
    private $paterno;
    private $materno;
    private $calle;
    private $beanCp;
    private $noExterior;
    private $noInterior;
    private $telefono;
    private $otroTelefono;
    private $mail;
    private $noLicencia;
    private $vigencia;
    private $beanLicencia;
    private $activo;
    private $dtoVehiculo;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getIdConductor() {
        return $this->idConductor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPaterno() {
        return $this->paterno;
    }

    public function getMaterno() {
        return $this->materno;
    }

    public function getCalle() {
        return $this->calle;
    }

    public function getBeanCp() {
        return $this->beanCp;
    }

    public function getNoExterior() {
        return $this->noExterior;
    }

    public function getNoInterior() {
        return $this->noInterior;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getOtroTelefono() {
        return $this->otroTelefono;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getNoLicencia() {
        return $this->noLicencia;
    }

    public function getVigencia() {
        return $this->vigencia;
    }

    public function getBeanLicencia() {
        return $this->beanLicencia;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getDtoVehiculo() {
        return $this->dtoVehiculo;
    }

    public function setIdConductor($idConductor) {
        $this->idConductor = $idConductor;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPaterno($paterno) {
        $this->paterno = $paterno;
    }

    public function setMaterno($materno) {
        $this->materno = $materno;
    }

    public function setCalle($calle) {
        $this->calle = $calle;
    }

    public function setBeanCp($beanCp) {
        $this->beanCp = $beanCp;
    }

    public function setNoExterior($noExterior) {
        $this->noExterior = $noExterior;
    }

    public function setNoInterior($noInterior) {
        $this->noInterior = $noInterior;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setOtroTelefono($otroTelefono) {
        $this->otroTelefono = $otroTelefono;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setNoLicencia($noLicencia) {
        $this->noLicencia = $noLicencia;
    }

    public function setVigencia($vigencia) {
        $this->vigencia = $vigencia;
    }

    public function setBeanLicencia($beanLicencia) {
        $this->beanLicencia = $beanLicencia;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function setDtoVehiculo($dtoVehiculo) {
        $this->dtoVehiculo = $dtoVehiculo;
    }

    //</editor-fold>
}
