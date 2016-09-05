<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of ClienteVehiculoDaoImpl
 *
 * @author ShadowDarkCat
 */
class ClienteVehiculoDaoImpl implements ClienteVehiculoDao {

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
        return NULL;
    }

    public function findById($obj) {
        $args = NULL;
        if (!empty($obj->getIdCliente())) {
            $args = array($obj->getIdCliente());
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_cliente_vehiculo_cliente, $args);
        } else if (!empty($obj->getIdVehiculo())) {
            $args = array($obj->getIdVehiculo());
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_cliente_vehiculo_vehiculo, $args);
        } else if (!empty($obj->getIdConductor())) {
            $args = array($obj->getIdConductor());
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_cliente_vehiculo_conductor, $args);
        } else {
            $query = PropertyKey::$jdbc_view_cliente_vehiculo;
        }
        return $this->getResultSet($query);
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">

    public function insert($obj) {
        
    }

    public function update($obj) {
        
    }

    public function delete($obj) {
        
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getResultSet($query) {
        $index = 0;
        $obj = [];
        $rs = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($rs)) {
            $obj[$index] = SqlUtils::getFields(FactoryClienteVehiculo::newInstance(NULL), $row);
            $index++;
        }
        SqlUtils::close($this->jdbc, $rs);
        return $obj;
    }

    //</editor-fold>
}
