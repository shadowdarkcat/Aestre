<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of VehiculoDaoImpl
 *
 * @author ShadowDarkCat
 */
class VehiculoDaoImpl implements VehiculoDao {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $jdbc;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        new PropertyKey();
        $this->jdbc = new Jdbc();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">

    public function findAll() {
        return $this->getResultSet(PropertyKey::$jdbc_view_vehiculos);
    }

    public function findAllById($obj) {
        $args = array($obj->getIdVehiculo());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_vehiculos_id, $args));
    }

    public function findById($obj) {
        $args = array($obj->getIdVehiculo());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_vehiculos_id, $args))[0];
    }

    public function exist($obj) {
        $args = array($obj->getImei(), $obj->getSim());
        return $this->getResultSetFunction(Utils::replaceQuery(PropertyKey::$jdbc_function_exist_vehiculo, $args));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insert($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_vehiculo, $this->getParameters(1, $obj)));
    }

    public function update($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_vehiculo, $this->getParameters(2, $obj)));
    }

    public function delete($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_vehiculo, $this->getParameters(3, $obj)));
    }

    public function updateZona($obj) {
        SqlUtils::execute($this->jdbc, str_replace("'", "", Utils::replaceQuery(PropertyKey::$jdbc_procedure_vehiculo, $this->getParameters(4, $obj))));
    }

    public function updateRuta($obj) {
        SqlUtils::execute($this->jdbc, str_replace("'", "", Utils::replaceQuery(PropertyKey::$jdbc_procedure_vehiculo, $this->getParameters(5, $obj))));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getResultSet($query) {
        $index = 0;
        $object = [];
        $rs = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($rs)) {
            $object[$index] = SqlUtils::getFields(FactoryVehiculo::newInstance(NULL), $row);
            $index++;
        }
        SqlUtils::close($this->jdbc, $rs);
        return $object;
    }

    private function getResultSetFunction($query) {
        $object = NULL;
        $rs = $this->jdbc->query($query);
        while ($row = @mysqli_fetch_array($rs)) {
            $object = $row[0];
        }
        SqlUtils::close($this->jdbc, $rs);
        return $object;
    }

    private function getParameters($opcion, $obj) {
        return array($opcion
            , $obj->getIdVehiculo()
            , $obj->getModelo()
            , $obj->getMarca()
            , $obj->getPlaca()
            , $obj->getColor()
            , $obj->getBeanGiro()->getIdGiro()
            , $obj->getImei()
            , $obj->getSim()
            , $obj->getActivo()
            , $obj->getApagado()
            , $obj->getBeanDispositivo()->getIdDispositivo()
            , $obj->getBeanGeozona()->getId()
            , $obj->getBeanGeoruta()->getId()
            , $obj->getBeanIconos()->getIdIcono()
            , $obj->getIdCliente()
            , $obj->getVerificacion()
        );
    }

    //</editor-fold>
}
