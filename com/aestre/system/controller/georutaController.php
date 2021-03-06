<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new georutaController();
    $controller->georutas();
}

class georutaController {

    private $session;
    private $method;
    private $georutaBo;
    private $vehiculoBo;

    public function __construct() {
        unset($_SESSION[PropertyKey::$session_ruta_json]);
        $this->georutaBo = new GeorutaBoImpl();
        $this->vehiculoBo = new VehiculoBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function georutas() {
        switch ($this->method) {
            case 0:
                $this->findAll(false);
                break;
            case 1:
                echo(json_encode($this->insert()));
                break;
            case 2:
                echo(json_encode($this->update()));
                break;
            case 3:
                echo(json_encode($this->delete()));
                break;
            case 4:
                //  echo (json_encode($this->findById()));
                break;
            case 5:
                echo(json_encode($this->updateRuta()));
                break;
        }
    }

    public function find() {
        $_SESSION[PropertyKey::$session_ruta_json] = json_encode($this->georutaBo->findAll($this->session));
    }

    public function findAll($exist) {
        $this->redirect($this->georutaBo->findAll($this->session), $exist);
    }

    private function findById() {
        return $this->georutaBo->findById($this->getParametersFromRequest(), $this->session);
    }

    private function insert() {
        $ruta = $this->getParametersFromRequest();
        $exist = $this->georutaBo->verifyExists($this->session, $ruta);
        if (!$exist) {
            return $this->georutaBo->insert($this->session, $ruta);
        }
    }

    private function update() {
        return $this->georutaBo->update($this->session, $this->getParametersFromRequest());
    }

    private function delete() {
        return $this->georutaBo->delete($this->session, $this->getParametersFromRequest());
    }

    private function updateRuta() {
        $bean = FactoryGeoruta::newInstance(NULL);
        foreach ($_REQUEST[PropertyKey::$view_ids_vehiculos] as $item) {
            $dto = FactoryVehiculo::newInstance($item);
            $bean->setId(isset($_REQUEST[PropertyKey::$view_id_ruta]) ? strtoupper($_REQUEST[PropertyKey::$view_id_ruta]) : NULL );
            $dto->setBeanGeozona(FactoryGeozona::newInstance(NULL));
            $dto->setBeanGeoruta($bean);
            $dto->setBeanGiro(FactoryGiro::newInstance(NULL));
            $dto->setBeanDispositivo(FactoryDispositivo::newInstance(NULL));
            $dto->setBeanIconos(FactoryIconos::newInstance(NULL));
            $array[] = $dto;
        }
        $json[] = array('contador' => $this->vehiculoBo->updateRuta($this->session, $array));
        return $json;
    }

    private function getParametersFromRequest() {
        $ruta = FactoryGeoruta::newInstance(isset($_REQUEST[PropertyKey::$view_id_ruta]) ? strtoupper($_REQUEST[PropertyKey::$view_id_ruta]) : NULL );
        $ruta->setNombre(strtoupper($_REQUEST[PropertyKey::$view_nombre]));
        $ruta->setJson($_REQUEST[PropertyKey::$view_json]);
        if (empty($_REQUEST[PropertyKey::$view_ids_vehiculos])) {
            $ruta->setIdVehiculo(NULL);
        } else {
            $ruta->setIdVehiculo($_REQUEST[PropertyKey::$view_ids_vehiculos]);
        }
        $ruta->setLenght($_REQUEST[PropertyKey::$view_lenght]);
        return $ruta;
    }

    private function redirect($ruta, $exist) {
        if (!empty($ruta)) {
            $_SESSION[PropertyKey::$session_ruta_json] = json_encode($ruta);
        }
        $_SESSION[PropertyKey::$session_exists] = serialize($exist);
    }

}
