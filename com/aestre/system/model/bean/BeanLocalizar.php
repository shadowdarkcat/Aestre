<?php

/**
 * Description of BeanLocalizar
 *
 * @author ShadowDarkCat
 */
class BeanLocalizar {

    //<editor-fold defaultstate="collapsed" desc="Campos Clase">
    private $id;
    private $imei;
    private $lat;
    private $lon;
    private $dateTime;
    private $address;
    private $speed;
    private $json;
    private $evento;
    private $odometro;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getId() {
        return $this->id;
    }

    public function getImei() {
        return $this->imei;
    }

    public function getLat() {
        return $this->lat;
    }

    public function getLon() {
        return $this->lon;
    }

    public function getDateTime() {
        return $this->dateTime;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getSpeed() {
        return $this->speed;
    }

    public function getJson() {
        return $this->json;
    }

    public function getEvento() {
        return $this->evento;
    }

    public function getOdometro() {
        return $this->odometro;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setImei($imei) {
        $this->imei = $imei;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function setLon($lon) {
        $this->lon = $lon;
    }

    public function setDateTime($dateTime) {
        $this->dateTime = $dateTime;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setSpeed($speed) {
        $this->speed = $speed;
    }

    public function setJson($json) {
        $this->json = $json;
    }

    public function setEvento($evento) {
        $this->evento = $evento;
    }

    public function setOdometro($odometro) {
        $this->odometro = $odometro;
    }

    //</editor-fold>
}
