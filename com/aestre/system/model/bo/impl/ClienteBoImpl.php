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
    private $giroBo;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new ClienteDaoImpl();
        $this->cpBo = new ColoniaBoImpl();
        $this->giroBo = new GiroBoImpl();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAll($user) {
        if (Utils::isSessionValid($user)) {
            $collection = $this->dao->findAll();
            foreach ($collection as $item) {
                $item->setBeanCp($this->getCp($user, $item->getBeanCp()));
                $item->setBeanGiro($this->getGiro($user, $item->getBeanGiro()));
            }
            return $collection;
        }
    }

    public function findById($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $object = $this->clienteDao->findById($object);
            foreach ($object as $item) {
                $item->setBeanCp($this->getCp($user, $item->getBeanCp()));
                $item->setBeanGiro($this->getGiro($user, $item->getBeanGiro()));
            }
            return $this->createJson($object);
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
    private function createJson($object) {
        $json = array();
        foreach ($object as $val) {
            $json[] = array(
                'id' => $val->getIdCliente(), 'nombre' => $val->getNombre()
                , 'paterno' => $val->getPaterno(), 'materno' => $val->getMaterno()
                , 'calle' => $val->getCalle(), 'exterior' => $val->getNoExterior()
                , 'interior' => ($val->getNoInterior() == 'NULL' ? 'S/N' : $val->getNoInterior())
                , 'idCp' => $val->getBeanCp()->getIdCp(), 'cp' => $val->getBeanCp()->getCp()
                , 'col' => $val->getBeanCp()->getCol()
                , 'dele' => (empty($val->getBeanCp()->getDelegacion()) ? 'NULL' : $val->getBeanCp()->getDelegacion())
                , 'muni' => (empty($val->getBeanCp()->getMunicipio()) ? 'NULL' : $val->getBeanCp()->getMunicipio())
                , 'estado' => $val->getBeanCp()->getEstado()
                , 'ciudad' => (empty($val->getBeanCp()->getCiudad()) ? 'NA' : $val->getBeanCp()->getCiudad())
                , 'casa' => $val->getTelefono()
                , 'otro' => (empty($val->getOtroTelefono()) ? 'NA' : $val->getOtroTelefono())
                , 'mail' => $val->getMail(), 'giro' => (empty($val->getBeanGiro()->getGiro()) ? 'NA' : $val->getBeanGiro()->getGiro())
            );
        }
        return $json;
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos Privados">
    private final function getCp($user, $bean) {
        return $this->cpBo->findById($user, $bean);
    }

    private final function getGiro($user, $bean) {
        return $this->giroBo->findById($user, $bean);
    }

    //</editor-fold>
}
