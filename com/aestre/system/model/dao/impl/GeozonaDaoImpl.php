<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of GeozonaDaoImpl
 *
 * @author ShadowDarkCat
 */
class GeozonaDaoImpl implements GeozonaDao {

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
        return $this->getResultSet(PropertyKey::$jdbc_view_geozona);
    }

    public function findById($obj) {
        $args = array($obj->getId());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_geozona_id, $args));
    }

    public function verifyExists($obj){
        $args = array($obj->getNombre());
        return $this->getResultSetFunction(Utils::replaceQuery(PropertyKey::$jdbc_function_exist_zona, $args)) != 0;       
    }
    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insert($obj) {
        $cont = 0;
        $array = $obj->getIdVehiculo();
        $obj->setIdVehiculo(NULL);
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_zona, $this->getParameters(1, $obj)));
        $obj->setId($this->getResultSetFunction(PropertyKey::$jdbc_function_last_zona));
        foreach ($array as $item) {
            $obj->setIdVehiculo($item);
            SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_zona, $this->getParameters(4, $obj)));
            $cont++;
        }
        return $cont;
    }

    public function update($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_zona, $this->getParameters(2, $obj)));
    }

    public function delete($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_zona, $this->getParameters(3, $obj)));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getResultSet($query) {
        $index = 0;
        $obj = [];
        $rs = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($rs)) {
            $obj[$index] = SqlUtils::getFields(FactoryGeozona::newInstance(NULL), $row);
            $index++;
        }
        SqlUtils::close($this->jdbc, $rs);
        return $obj;
    }

    private function getResultSetFunction($query) {
        $obj = NULL;
        $rs = $this->jdbc->query($query);
        while ($row = @mysqli_fetch_array($rs)) {
            $obj = $row[0];
        }
        SqlUtils::close($this->jdbc, $rs);
        return $obj;
    }

    private function getParameters($opcion, $obj) {
        return array(
            $opcion
            , $obj->getId()
            , $obj->getIdVehiculo()
            , $obj->getNombre()
            , $obj->getJson()
        );
    }

    //</editor-fold>

}
/*
 * CALL sp_geozona(1,NULL,NULL,'PRUEBA',\''{"latLng":[{"lat":"20.269067846063408","long":" -98.800048828125"},{"lat":"19.44242094658899","long":" -100.184326171875"},{"lat":"18.23630772344136","long":" -99.173583984375"},{"lat":"19.938926531706414","long":" -97.855224609375"}],"colorZona":"#AB2567"}\'');
 * 
 */