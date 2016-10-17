<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new geozonaController();
    $controller->geozonas();
}

/**
 * Description of geozonaController
 *
 * @author ShadowDarkCat
 */
class geozonaController {

    private $session;
    private $method;
    private $geozonaBo;
    private $vehiculoBo;

    public function __construct() {
        unset($_SESSION[PropertyKey::$session_zona_json]);
        $this->geozonaBo = new GeozonaBoImpl();
        $this->vehiculoBo = new VehiculoBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function geozonas() {
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
                echo(json_encode($this->updateZona()));
                break;
        }
    }

    public function find() {
        $_SESSION[PropertyKey::$session_zona_json] = json_encode($this->geozonaBo->findAll($this->session));
    }

    public function findAll($exist) {
        $this->redirect($this->geozonaBo->findAll($this->session), $exist);
    }

    private function findById() {
        return $this->geozonaBo->findById($this->getParametersFromRequest(), $this->session);
    }

    private function insert() {
        $zona = $this->getParametersFromRequest();
        $exist = $this->geozonaBo->verifyExists($this->session, $zona);
        if (!$exist) {
            return $this->geozonaBo->insert($this->session, $zona);
        }
    }

    private function update() {
        return $this->geozonaBo->update($this->session, $this->getParametersFromRequest());
    }

    private function delete() {
        return $this->geozonaBo->delete($this->session, $this->getParametersFromRequest());
    }

    private function updateZona() {
        $bean = FactoryGeozona::newInstance(NULL);
        foreach ($_REQUEST[PropertyKey::$view_ids_vehiculos] as $item) {
            $dto = FactoryVehiculo::newInstance($item);
            $bean->setId(isset($_REQUEST[PropertyKey::$view_id_zona]) ? strtoupper($_REQUEST[PropertyKey::$view_id_zona]) : NULL );
            $dto->setBeanGeozona($bean);
            $dto->setBeanGeoruta(FactoryGeoruta::newInstance(NULL));
            $dto->setBeanGiro(FactoryGiro::newInstance(NULL));
            $dto->setBeanDispositivo(FactoryDispositivo::newInstance(NULL));
            $dto->setBeanIconos(FactoryIconos::newInstance(NULL));
            $array[] = $dto;
        }
        $json[] = array('contador' => $this->vehiculoBo->updateZona($this->session, $array));
        return $json;
    }

    private function getParametersFromRequest() {
        $zona = new BeanGeozona();
        $zona->setId(isset($_REQUEST[PropertyKey::$view_id_zona]) ? strtoupper($_REQUEST[PropertyKey::$view_id_zona]) : NULL );
        $zona->setNombre(strtoupper($_REQUEST[PropertyKey::$view_nombre]));
        $zona->setJson($_REQUEST[PropertyKey::$view_json]);
        if (empty($_REQUEST[PropertyKey::$view_ids_vehiculos])) {
            $zona->setIdVehiculo(NULL);
        } else {
            $zona->setIdVehiculo($_REQUEST[PropertyKey::$view_ids_vehiculos]);
        }
        return $zona;
    }

    private function redirect($zona, $exist) {
        if (!empty($zona)) {
            $_SESSION[PropertyKey::$session_zona_json] = json_encode($zona);
        }
        $_SESSION[PropertyKey::$session_exists] = serialize($exist);
    }

}
