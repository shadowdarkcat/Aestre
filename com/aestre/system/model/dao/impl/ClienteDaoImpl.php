<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of ClienteDaoImpl
 *
 * @author ShadowDarkCat
 */
class ClienteDaoImpl implements ClienteDao {

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
        return $this->getResultSet(PropertyKey::$jdbc_view_cliente);
    }

    public function findById($obj) {
        $args = array($obj->getIdCliente());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_cliente_id, $args))[0];
    }

    public function exist($obj) {
        $args = array($obj->getNombre(), $obj->getPaterno(), $obj->getMaterno());
        return $this->getResultSetFunction(Utils::replaceQuery(PropertyKey::$jdbc_function_exist_cliente, $args)) != 0;
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insert($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_cliente, $this->getParameters(1, $obj)));
    }

    public function update($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_cliente, $this->getParameters(2, $obj)));
    }

    public function delete($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_cliente, $this->getParameters(3, $obj)));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getResultSet($query) {
        $index = 0;
        $object = [];
        $rs = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($rs)) {
            $object[$index] = SqlUtils::getFields(FactoryCliente::newInstance(NULL), $row);
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
        return array($opcion, $obj->getIdCliente()
            , $obj->getNombre()
            , $obj->getPaterno()
            , $obj->getMaterno()
            , $obj->getCalle()
            , $obj->getBeanCp()->getIdCp()
            , $obj->getNoExterior()
            , $obj->getNoInterior()
            , $obj->getTelefono()
            , $obj->getOtroTelefono()
            , $obj->getMail()
            , $obj->getBeanGiro()->getIdGiro()
            , $obj->getActivo()
            , $obj->getRefresh()
        );
    }

    //</editor-fold>
}
