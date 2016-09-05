<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of DispositivoDaoImpl
 *
 * @author ShadowDarkCat
 */
class DispositivoDaoImpl implements DispositivoDao {

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
        return $this->getResultSet(PropertyKey::$jdbc_view_dispositivo);
    }

    public function findById($obj) {
        $args = array($obj->getIdDispositivo());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_dispositivo_id, $args))[0];
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
        $object = [];
        $rs = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($rs)) {
            $object[$index] = SqlUtils::getFields(FactoryDispositivo::newInstance(NULL), $row);
            $index++;
        }
        SqlUtils::close($this->jdbc, $rs);
        return $object;
    }

    //</editor-fold>
}
