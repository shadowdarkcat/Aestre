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
    private $cpBo;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new ClienteDaoImpl();
        $this->cpBo = new ColoniaBoImpl();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAll($user) {
        if (Utils::isSessionValid($user)) {
            $collection = $this->dao->findAll();
            foreach ($collection as $item) {
                $item->setBeanCp($this->getCp($user, $item->getBeanCp()));
            }
            return $collection;
        }
    }

    public function findById($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $object = $this->dao->findById($obj);
            foreach ($object as $item) {
                $item->setBeanCp($this->getCp($user, $item->getBeanCp()));
            }
            return JsonUtils::createJson($object);
        }
    }

    public function findByIdFromCv($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $collection = $this->dao->findById($obj);
            foreach ($collection as $item) {
                $item->setBeanCp($this->getCp($user, $item->getBeanCp()));
            }
            return $collection;
        }
    }

    public function exist($user, $obj) {
        if (Utils::isSessionValid($user)) {
            return $this->dao->exist($obj);
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
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
     private final function getCp($user, $bean) {
        return $this->cpBo->findById($user, $bean);
    }

    //</editor-fold>
}
