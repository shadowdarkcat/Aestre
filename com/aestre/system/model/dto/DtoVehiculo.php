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
    private $beanGeozona;
    private $beanGeoruta;
    private $beanIconos;
    private $verificacion;
    private $clientes;
    private $idCliente;
    private $beanLocalizar;
    private $dtoConductor;
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

    public function getBeanGeozona() {
        return $this->beanGeozona;
    }

    public function getBeanGeoruta() {
        return $this->beanGeoruta;
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

    public function getBeanLocalizar() {
        return $this->beanLocalizar;
    }

    public function getDtoConductor() {
        return $this->dtoConductor;
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

    public function setBeanGeozona($beanGeozona) {
        $this->beanGeozona = $beanGeozona;
    }

    public function setBeanGeoruta($beanGeoruta) {
        $this->beanGeoruta = $beanGeoruta;
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

    public function setBeanLocalizar($beanLocalizar) {
        $this->beanLocalizar = $beanLocalizar;
    }

    public function setDtoConductor($dtoConductor) {
        $this->dtoConductor = $dtoConductor;
    }

        //</editor-fold>
}
