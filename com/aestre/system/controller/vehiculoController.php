<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new vehiculoController();
    $controller->vehiculos();
}

/**
 * Description of vehiculoController
 *
 * @author ShadowDarkCat
 */
class vehiculoController {

    private $session;
    private $method;
    private $vehiculoBo;
    private $giroBo;
    private $dispositivoBo;
    private $iconosBo;
    private $clienteBo;

    public function __construct() {
        $this->vehiculoBo = new VehiculoBoImpl();
        $this->giroBo = new GiroBoImpl();
        $this->dispositivoBo = new DispositivoBoImpl();
        $this->iconosBo = new IconosBoImpl();
        $this->clienteBo = new ClienteBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
        unset($_SESSION[PropertyKey::$session_clientes]);
        $_SESSION[PropertyKey::$session_clientes] = serialize($this->clienteBo->findAll($this->session));
    }

    public function vehiculos() {
        $vehiculo = FactoryVehiculo::newInstance(NULL);
        switch ($this->method) {
            case 0:
                $this->findAll(FALSE);
                break;
            case 1:
                $this->insert($vehiculo);
                break;
            case 2:
                $this->update($vehiculo);
                break;
            case 3:
                $this->delete($vehiculo);
                break;
        }
    }

    public function findAllToConductor() {
        $this->vehiculoBo->findAll($this->session);
        if (!empty($vehiculos)) {
            $_SESSION[PropertyKey::$session_vehiculos] = serialize($vehiculos);
        }
    }

    private function findAll($exist) {
        if (!empty($this->session->getIdCliente())) {
            $object = $this->vehiculoBo->findAll($this->session);
            foreach ($object->getClientes() as $item) {
                if ($this->session->getIdCliente() == $item->getId()) {
                    echo(json_encode(JsonUtils::createJson($item->getVehiculos())));
                    break;
                }
            }
        } else {
            $this->redirect($this->vehiculoBo->findAll($this->session), $exist);
        }
    }

    private function findById(DtoVehiculo $vehiculo) {
        return $this->vehiculoBo->findById($this->session, $this->getParametersFromRequest($vehiculo));
    }

    private function findAllById(DtoVehiculo $vehiculo) {
        return $this->vehiculoBo->findAllById($this->session, $this->getParametersFromRequest($vehiculo));
    }

    private function insert(DtoVehiculo $dto) {
        $vehiculo = $this->getParametersFromRequest($dto);
        $exist = $this->vehiculoBo->exist($this->session, $vehiculo);
        if (!$exist) {
            $this->vehiculoBo->insert($this->session, $vehiculo);
        }
        $this->findAll($exist);
    }

    private function update(DtoVehiculo $vehiculo) {
        $this->vehiculoBo->update($this->session, $this->getParametersFromRequest($vehiculo));
        $this->findAll(FALSE);
    }

    private function delete(DtoVehiculo $vehiculo) {
        $this->vehiculoBo->delete($this->session, $this->getParametersFromRequest($vehiculo));
        $this->findAll(FALSE);
    }

    private function activate(DtoVehiculo $vehiculo) {
        $this->vehiculoBo->delete($this->session, $this->getParametersFromRequest($vehiculo));
        $this->findAll(FALSE);
    }

    private function redirect($vehiculos, $exist) {
        if (!empty($vehiculos)) {
            $_SESSION[PropertyKey::$session_vehiculos] = serialize($vehiculos);
        }
        $_SESSION[PropertyKey::$session_exists] = $exist;
        echo(PropertyKey::$php_main_vehiculo);
    }

    private function getParametersFromRequest(DtoVehiculo $vehiculo) {
        /* $beanZona = new BeanGeozona();
          $beanRuta = new BeanGeoruta(); */
        $vehiculo->setIdVehiculo(isset($_REQUEST[PropertyKey::$view_vehiculo_id]) ? strtoupper($_REQUEST[PropertyKey::$view_vehiculo_id]) : NULL );
        $vehiculo->setModelo(strtoupper($_REQUEST[PropertyKey::$view_modelo]));
        $vehiculo->setMarca(strtoupper($_REQUEST[PropertyKey::$view_marca]));
        $vehiculo->setPlaca(strtoupper($_REQUEST[PropertyKey::$view_placa]));
        $vehiculo->setColor(strtoupper($_REQUEST[PropertyKey::$view_color]));
        $vehiculo->setBeanGiro(FactoryGiro::newInstance($_REQUEST[PropertyKey::$view_cboGiro]));
        $vehiculo->setImei($_REQUEST[PropertyKey::$view_imei]);
        $vehiculo->setSim($_REQUEST[PropertyKey::$view_telefono]);
        $vehiculo->setApagado(NULL);
        $vehiculo->setBeanDispositivo(FactoryDispositivo::newInstance($_REQUEST[PropertyKey::$view_cbo_gps]));
        $vehiculo->setBeanZona(NULL); //$beanZona->setId(isset($_REQUEST['txtIdZona']) ? $_REQUEST['txtIdZona'] : NULL );
        $vehiculo->setBeanRuta(NULL); //$beanRuta->setId(isset($_REQUEST['txtIdRuta']) ? $_REQUEST['txtIdRuta'] : NULL );
        $vehiculo->setBeanIconos(FactoryIconos::newInstance($_REQUEST[PropertyKey::$view_icono_id]));
        $vehiculo->setActivo(isset($_REQUEST[PropertyKey::$view_chkActivo]) ? Utils::isIsset($_REQUEST[PropertyKey::$view_chkActivo]) : Utils::isIsset(NULL));
        $vehiculo->setIdCliente($_REQUEST[PropertyKey::$view_cbo_clientes]);
        $vehiculo->setVerificacion(date('Y-m-d', strtotime(str_replace('-', '/', $_REQUEST[PropertyKey::$view_dtp_verificacion]))));
        return $vehiculo;
    }

}
