<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of ColoniaBoImpl
 *
 * @author ShadowDarkCat
 */
class ColoniaBoImpl implements ColoniaBo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $dao;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new ColoniaDaoImpl();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAll($user) {
        if (Utils::isSessionValid($user)) {
            $object = array();
            foreach ($this->dao->findAll() as $val) {
                $object[] = array('idCp' => $val->getIdCp(), 'cp' => $val->getCp()
                    , 'col' => $val->getCol(), 'dele' => $val->getDelegacion()
                    , 'muni' => $val->getMunicipio(), 'estado' => $val->getEstado()
                    , 'ciudad' => $val->getCiudad());
            }
            return $object;
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
