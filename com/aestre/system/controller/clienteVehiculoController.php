<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Description of clienteVehiculoController
 *
 * @author ShadowDarkCat
 */
class clienteVehiculoController {

    private $beanClienteVehiculo;
    private $clienteBo;
    private $vehiculoBo;
    private $clienteVehiculoBo;
    private $usoBo;
    private $dispositivoBo;
    private $iconBo;
    private $indexV;
    private $session;

    public function __construct() {
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        $this->beanClienteVehiculo = FactoryClienteVehiculo::newInstance(NULL);
        $this->clienteVehiculoBo = new ClienteVehiculoBoImpl();
        $this->clienteBo = new ClienteBoImpl();
        $this->vehiculoBo = new VehiculoBoImpl();
        $this->usoBo = new GiroBoImpl();
        $this->dispositivoBo = new DispositivoBoImpl();
        $this->iconBo = new IconosBoImpl();
        $this->indexV = 0;
    }

    public function findByIdCliente($id) {
        $dto = FactoryCliente::newInstance(NULL);
        $this->beanClienteVehiculo->setIdCliente($id);
        $index = 0;
        $idAnterior = 0;
        $object = FactoryClienteVehiculo::newInstance(NULL);
        $objVehiculo = array();
        $dv = NULL;
        foreach ($this->clienteVehiculoBo->findById($this->session, $this->beanClienteVehiculo)as $cv) {
            $dto->setIdCliente($cv->getIdCliente());
            $dv = FactoryVehiculo::newInstance(NULL);
            $dv->setIdVehiculo($cv->getIdVehiculo());
            if ($idAnterior != $cv->getIdCliente()) {
                $dto = $this->clienteBo->findByIdFromCv($this->session, $dto);
                $idAnterior = $dto->getIdCliente();
            }
            $rsVehiculo = $this->vehiculoBo->find($this->session, $dv);
            foreach ($rsVehiculo as $item) {
                $dv = $item;
                $dv->setBeanGiro($this->usoBo->findById($this->session, $item->getBeanGiro()));
                $dv->setBeanDispositivo($this->dispositivoBo->findById($this->session, $item->getBeanDispositivo()));
                $dv->setBeanIconos($this->iconBo->findById($this->session, $item->getBeanIconos()));
                if (empty($this->indexV)) {
                    $objVehiculo[0] = $dv;
                } else {
                    $objVehiculo[$this->indexV] = $dv;
                }
                $this->indexV++;
            }
        }
        $dto->setVehiculos($objVehiculo);
        $_SESSION[PropertyKey::$session_clientes] = serialize($dto);
    }

}
