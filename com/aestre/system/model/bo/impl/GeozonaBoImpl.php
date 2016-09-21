<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of GeozonaBoImpl
 *
 * @author ShadowDarkCat
 */
class GeozonaBoImpl implements GeozonaBo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $dao;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new GeozonaDaoImpl();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAll($user) {
        if (Utils::isSessionValid($user)) {
            return JsonUtils::createJson($this->dao->findAll());
        }
    }

    public function findById($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $obj = $this->dao->findById($obj);
            return JsonUtils::createJson($obj);
        }
    }

    public function find($user, $obj) {
        if (Utils::isSessionValid($user)) {
            return $this->dao->findById($obj);
        }
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insert($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $rs = $this->dao->insert($obj);
            $json[] = array('contador' => $rs);
            return $json;
        }
    }

    public function update($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $this->dao->update($obj);
            $json[] = array(TRUE);
            return $json;
        }
    }

    public function delete($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $this->dao->delete($obj);
            $json[] = array(TRUE);
            return $json;
        }
    }

    //</editor-fold>
}
