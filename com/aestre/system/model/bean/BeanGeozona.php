<?php

/**
 * Description of BeanGeozona
 *
 * @author ShadowDarkCat
 */
class BeanGeozona {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $id;
    private $nombre;
    private $json;
    private $idVehiculo;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getJson() {
        return $this->json;
    }

    public function getIdVehiculo() {
        return $this->idVehiculo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setJson($json) {
        $this->json = $json;
    }

    public function setIdVehiculo($idVehiculo) {
        $this->idVehiculo = $idVehiculo;
    }

    //</editor-fold>
}
