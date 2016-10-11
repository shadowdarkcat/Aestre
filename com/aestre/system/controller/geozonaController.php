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

    public function __construct() {
        $this->geozonaBo = new GeozonaBoImpl();
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
                //  $this->update();
                break;
            case 5:
                //  echo (json_encode($this->findById()));
                break;
        }
    }

    public function find() {
        $_SESSION['zonaJson'] = json_encode($this->geozonaBo->findAll($this->session));
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

    private function update(DtoZona $zona, BeanCp $colonia) {
        $this->geozonaBo->update($this->getParametersFromRequest($zona, $colonia), $this->session);
        $this->findAll(0);
    }

    private function getParametersFromRequest() {
        $zona = new BeanGeozona();
        $zona->setId(isset($_REQUEST['txtIdZona']) ? strtoupper($_REQUEST['txtIdZona']) : NULL );
        $zona->setNombre(strtoupper($_REQUEST['txtNombre']));
        $zona->setJson($_REQUEST['json']);
        $zona->setIdVehiculo($_REQUEST['idVehiculos']);
        return $zona;
    }

    private function redirect($zona, $exist) {
        if (!empty($zona)) {
            $_SESSION['zonas'] = json_encode($zona);
        }
        $_SESSION['exist'] = serialize($exist);
    }

}
