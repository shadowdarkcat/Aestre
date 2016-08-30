<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload',FALSE);
/**
 * Clase que guarda los archivos ini devueltos por el PropertyRead
 *
 * @author ShadowDarkCat
 */
class BeanProperty {

//<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $jdbc_property;
    private $system_property;

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->jdbc_property = PropertyRead::readProperty(realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/resources/jdbc.ini');
        $this->system_property = PropertyRead::readProperty(realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/resources/system.ini');
    }

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Accesores">
    public function getJdbc_property() {
        return $this->jdbc_property;
    }

    public function getSystem_property() {
        return $this->system_property;
    }

//</editor-fold>
}
