<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of ConductorBoImpl
 *
 * @author ShadowDarkCat
 */
class ConductorBoImpl implements ConductorBo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $dao;
    private $cpBo;
    private $licenciaBo;
    private $clienteVehiculoBo;
    private $vehiculoBo;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new ConductorDaoImpl();
        $this->cpBo = new ColoniaBoImpl();
        $this->licenciaBo = new LicenciaBoImpl();
        $this->clienteVehiculoBo = new ClienteVehiculoBoImpl();
        $this->vehiculoBo = new VehiculoBoImpl();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAll($user) {
        if (Utils::isSessionValid($user)) {
            $collection = $this->dao->findAll();
            foreach ($collection as $item) {
                $item->setBeanCp($this->getCp($user, $item->getBeanCp()));
                $item->setBeanLicencia($this->getLicencia($user, $item->getBeanLicencia()));
                $res = $this->getClienteVehiculo($user, $item)[0];
                $item->setDtoVehiculo($this->getVehiculo(
                                $user, FactoryVehiculo::newInstance(
                                        $res->getIdVehiculo()
                                )
                        )
                );
            }
            return $collection;
        }
    }

    public function findById($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $object = $this->dao->findById($obj);
            foreach ($object as $item) {
                $item->setBeanCp($this->getCp($user, $item->getBeanCp()));
                $item->setBeanLicencia($this->getLicencia($user, $item->getBeanLicencia()));
                $res = $this->getClienteVehiculo($user, $item)[0];
                $item->setDtoVehiculo($this->getVehiculo(
                                $user, FactoryVehiculo::newInstance(
                                        $res->getIdVehiculo()
                                )
                        )
                );
            }
            return JsonUtils::createJson($object);
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
            $this->dao->getInsert($obj);
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

    private final function getLicencia($user, $bean) {
        return $this->licenciaBo->findById($user, $bean);
    }

    private final function getClienteVehiculo($user, $dto) {
        $obj = FactoryClienteVehiculo::newInstance(NULL);
        $obj->setIdConductor($dto->getIdConductor());
        return $this->clienteVehiculoBo->findById($user, $obj);
    }

    private final function getVehiculo($user, $obj) {
        return $this->vehiculoBo->findById($user, $obj);
    }

    //</editor-fold>
}
