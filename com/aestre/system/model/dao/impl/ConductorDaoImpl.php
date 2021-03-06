<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of ConductorDaoImpl
 *
 * @author ShadowDarkCat
 */
class ConductorDaoImpl implements ConductorDao {

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
        return $this->getResultSet(PropertyKey::$jdbc_view_conductor);
    }

    public function findById($obj) {
        $args = array($obj->getIdCliente());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_conductor_id, $args))[0];
    }

    public function exist($obj) {
        $args = array($obj->getNombre(), $obj->getPaterno(), $obj->getMaterno());
        return $this->getResultSetFunction(Utils::replaceQuery(PropertyKey::$jdbc_function_exist_conductor, $args)) != 0;
    }

    public function getInsert($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_conductor, $this->getParameters(1, $obj)));
        $obj->setIdConductor($this->getResultSetFunction(PropertyKey::$jdbc_function_last_conductor));
        return $obj;
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insert($obj) {
        
    }

    public function update($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_conductor, $this->getParameters(2, $obj)));
    }

    public function delete($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_conductor, $this->getParameters(3, $obj)));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getResultSet($query) {
        $index = 0;
        $object;
        $rs = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($rs)) {
            $object[$index] = SqlUtils::getFields(FactoryConductor::newInstance(NULL), $row);
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
        return array($opcion, $obj->getIdConductor()
            , $obj->getNombre()
            , $obj->getPaterno()
            , $obj->getMaterno()
            , $obj->getTelefono()
            , $obj->getOtroTelefono()
            , $obj->getMail()
            , $obj->getCalle()
            , $obj->getNoExterior()
            , $obj->getNoInterior()
            , $obj->getBeanCp()->getIdCp()
            , $obj->getNoLicencia()
            , $obj->getVigencia()
            , $obj->getBeanLicencia()->getIdLicencia()
            , $obj->getActivo()
            , $obj->getDtoVehiculo()->getIdVehiculo()
        );
    }

    //</editor-fold>
}
