<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of VehiculoBoImpl
 *
 * @author ShadowDarkCat
 */
class VehiculoBoImpl implements VehiculoBo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $dao;
    private $giroBo;
    private $dispositivoBo;
    /* private $zonaBo;
      private $rutaBo; */
    private $clienteBo;
    private $clienteVehiculoBo;
    private $iconosBo;
    private $indedxV;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new VehiculoDaoImpl();
        $this->giroBo = new GiroBoImpl();
        $this->dispositivoBo = new DispositivoBoImpl();
        $this->iconosBo = new IconosBoImpl();
        $this->clienteBo = new ClienteBoImpl();
        $this->clienteVehiculoBo = new ClienteVehiculoBoImpl();
        $this->indexV = 0;
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">    
    public function exist($user, $obj) {
        if (Utils::isSessionValid($user)) {
            return $this->dao->exist($obj);
        }
    }

    public function findAll($user) {
        $index = 0;
        $indexV = 0;
        $idAnterior = 0;
        $object = FactoryClienteVehiculo::newInstance(NULL);
        $objCliente = NULL;
        $dc = FactoryCliente::newInstance(NULL);
        $objVehiculo = array();
        $dv = NULL;
        if (Utils::isSessionValid($user)) {
            foreach ($this->getClienteVehiculo($user, $object)as $cv) {
                $dv = FactoryVehiculo::newInstance(NULL);
                $dv->setIdVehiculo($cv->getIdVehiculo());
                if ($idAnterior != $cv->getIdCliente()) {
                    if ($indexV != 0) {
                        $dc->setVehiculos($objVehiculo);
                        $objCliente[$index] = $dc;
                        $objVehiculo = array();
                        $index++;
                        $this->indedxV = 0;
                        $dc = NULL;
                    }
                    $dc = $this->getCliente($cv->getIdCliente(), $user);
                    $idAnterior = $dc->getIdCliente();
                }
                $rsVehiculo = $this->dao->findAllById($dv);
                foreach ($rsVehiculo as $item) {
                    $dv = $item;
                    $dv->setBeanGiro($this->getGiro($user, $item->getBeanGiro()));
                    $dv->setBeanDispositivo($this->getDispositivo($user, $item->getBeanDispositivo()));
                    $dv->setBeanIconos($this->getIconos($user, $item->getBeanIconos()));
                    if (empty($this->indedxV)) {
                        $objVehiculo[0] = $dv;
                    } else {
                        $objVehiculo[$this->indedxV] = $dv;
                    }
                    $this->indedxV ++;
                    $indexV = $this->indedxV;
                }
            }
            $cont = count($objCliente);
            if ($cont > 0) {
                $dc->setVehiculos($objVehiculo);
                $objCliente[$cont] = $dc;
            } else {
                $objCliente[0] = $dc;
                $objCliente[0]->setVehiculos($objVehiculo);
            }
            $obj = FactoryCliente::newInstance(NULL);
            $obj->setClientes($objCliente);
            return $obj;
        }
    }

    /*
     * $collection = $this->dao->findAll();
      foreach ($collection as $item) {
      $item->setBeanGiro($this->getGiro($user, $item->getBeanGiro()));
      $item->setBeanDispositivo($this->getDispositivo($user, $item->getBeanDispositivo()));
      //$item->setBeanZona($beanZona);
      //$item->setBeanRuta($beanRuta);
      $item->setBeanIconos($this->getIconos($user, $item->getBeanIconos()));
      }
     */

    public function findById($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $obj = $this->dao->findById($obj);
            foreach ($obj as $item) {
                $item->setBeanGiro($this->getGiro($user, $item->getBeanGiro()));
                $item->setBeanDispositivo($this->getDispositivo($user, $item->getBeanDispositivo()));
                $item->setBeanIconos($this->getIconos($user, $item->getBeanIconos()));
            }
            return $obj;
        }
    }

    public function findAllById($user, $obj) {
        if (Utils::isSessionValid($user)) {
            $obj = $this->dao->findById($obj);
            foreach ($obj as $item) {
                $item->setBeanGiro($this->getGiro($user, $item->getBeanGiro()));
                $item->setBeanDispositivo($this->getDispositivo($user, $item->getBeanDispositivo()));
                $item->setBeanIconos($this->getIconos($user, $item->getBeanIconos()));
            }
            return JsonUtils::createJson($obj);
        }
    }

    public function find($user, $object) {
        if (Utils::isSessionValid($user)) {
            $object = $this->dao->findAllById($object);
            foreach ($object as $item) {
                $item->setBeanGiro($this->getGiro($user, $item->getBeanGiro()));
                $item->setBeanDispositivo($this->getDispositivo($user, $item->getBeanDispositivo()));
                $item->setBeanIconos($this->getIconos($user, $item->getBeanIconos()));
            }
            return $object;
        }
    }

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

    /*
     * public function updateZona($object, DtoLogin $user) {
      if (Utils::isSessionValid($user)) {
      $index = 0;
      foreach ($object as $item) {
      $this->dao->updateZona($item);
      $index++;
      }
      return $index;
      }
      }

      public function updateRuta($object, DtoLogin $user) {
      if (Utils::isSessionValid($user)) {
      $index = 0;
      foreach ($object as $item) {
      $this->dao->updateRuta($item);
      $index++;
      }
      return $index;
      }
      }
     */

    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private final function getGiro($user, $obj) {
        return $this->giroBo->findById($user, $obj);
    }

    private final function getDispositivo($user, $obj) {
        return $this->dispositivoBo->findById($user, $obj);
    }

    //private final function getZona($user,$obj){}
    //private final function getRuta($user,$obj){}
    private function getIconos($user, $obj) {
        return $this->iconosBo->findById($user, $obj);
    }

    private function getClienteVehiculo($user, $obj) {
        return $this->clienteVehiculoBo->findById($user, $obj);
    }

    private function getCliente($id, DtoLogin $user) {
        return $this->clienteBo->findByIdFromCv($user, FactoryCliente::newInstance($id));
    }

    //</editor-fold>
}
