<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of BeanClienteVehiculo
 *
 * @author ShadowDarkCat
 */
class BeanClienteVehiculo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $id;
    private $idCliente;
    private $idVehiculo;
    private $idConductor;
    private $exitZone;
    private $enterZone;
    private $exitRuta;
    private $enterRuta;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getId() {
        return $this->id;
    }

    public function getIdCliente() {
        return $this->idCliente;
    }

    public function getIdVehiculo() {
        return $this->idVehiculo;
    }

    public function getIdConductor() {
        return $this->idConductor;
    }

    public function getExitZone() {
        return $this->exitZone;
    }

    public function getEnterZone() {
        return $this->enterZone;
    }

    public function getExitRuta() {
        return $this->exitRuta;
    }

    public function getEnterRuta() {
        return $this->enterRuta;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function setIdVehiculo($idVehiculo) {
        $this->idVehiculo = $idVehiculo;
    }

    public function setIdConductor($idConductor) {
        $this->idConductor = $idConductor;
    }

    public function setExitZone($exitZone) {
        $this->exitZone = $exitZone;
    }

    public function setEnterZone($enterZone) {
        $this->enterZone = $enterZone;
    }

    public function setExitRuta($exitRuta) {
        $this->exitRuta = $exitRuta;
    }

    public function setEnterRuta($enterRuta) {
        $this->enterRuta = $enterRuta;
    }

    //</editor-fold>
}
