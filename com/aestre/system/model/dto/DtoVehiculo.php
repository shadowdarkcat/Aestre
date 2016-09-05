<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of DtoVehiculo
 *
 * @author ShadowDarkCat
 */
class DtoVehiculo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $idVehiculo;
    private $modelo;
    private $marca;
    private $placa;
    private $color;
    private $beanGiro;
    private $imei;
    private $sim;
    private $activo;
    private $apagado;
    private $beanDispositivo;
    private $beanZona;
    private $beanRuta;
    private $beanIconos;
    private $verificacion;
    private $clientes;
    private $idCliente;
    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getIdVehiculo() {
        return $this->idVehiculo;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function getColor() {
        return $this->color;
    }

    public function getBeanGiro() {
        return $this->beanGiro;
    }

    public function getImei() {
        return $this->imei;
    }

    public function getSim() {
        return $this->sim;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getApagado() {
        return $this->apagado;
    }

    public function getBeanDispositivo() {
        return $this->beanDispositivo;
    }

    public function getBeanZona() {
        return $this->beanZona;
    }

    public function getBeanRuta() {
        return $this->beanRuta;
    }

    public function getBeanIconos() {
        return $this->beanIconos;
    }

    public function getVerificacion() {
        return $this->verificacion;
    }

    public function getClientes() {
        return $this->clientes;
    }

    public function getIdCliente() {
        return $this->idCliente;
    }

    public function setIdVehiculo($idVehiculo) {
        $this->idVehiculo = $idVehiculo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setBeanGiro($beanGiro) {
        $this->beanGiro = $beanGiro;
    }

    public function setImei($imei) {
        $this->imei = $imei;
    }

    public function setSim($sim) {
        $this->sim = $sim;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function setApagado($apagado) {
        $this->apagado = $apagado;
    }

    public function setBeanDispositivo($beanDispositivo) {
        $this->beanDispositivo = $beanDispositivo;
    }

    public function setBeanZona($beanZona) {
        $this->beanZona = $beanZona;
    }

    public function setBeanRuta($beanRuta) {
        $this->beanRuta = $beanRuta;
    }

    public function setBeanIconos($beanIconos) {
        $this->beanIconos = $beanIconos;
    }

    public function setVerificacion($verificacion) {
        $this->verificacion = $verificacion;
    }

    public function setClientes($clientes) {
        $this->clientes = $clientes;
    }

    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

        //</editor-fold>
}
