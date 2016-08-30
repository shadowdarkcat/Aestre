<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of ClienteBoImpl
 *
 * @author ShadowDarkCat
 */
class ClienteBoImpl implements ClienteBo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $dao;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new ClienteDaoImpl();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAll($user) {
        if (Utils::isSessionValid($user)) {
            return $this->dao->findAll();
        }
    }

    public function findById($user, $obj) {
        if (Utils::isSessionValid($user)) {
            return $this->dao->findById($obj);
        }
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insert($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $this->dao->insert($obj);
        }
    }

    public function update($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $this->dao->update($obj);
        }
    }

    public function delete($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $this->dao->delete($obj);
        }
    }

    //</editor-fold>
}
