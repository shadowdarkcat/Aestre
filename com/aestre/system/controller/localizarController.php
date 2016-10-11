<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new localizarController();
    $controller->localizar();
}

class localizarController {

    private $session;
    private $method;
    private $localizarBo;

    public function __construct() {
        $this->localizarBo = new LocalizarBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        $this->getClienteVehiculo($this->session->getIdCliente());
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function localizar() {
        switch ($this->method) {
            case 0:
                echo (json_encode($this->findAll()));
                break;
            case 1:
                echo (json_encode($this->findById()));
                break;
            case 2:
                echo(json_encode($this->findByDate()));
                break;
        }
    }

    private function findAll() {
        $dto = unserialize($_SESSION[PropertyKey::$session_clientes]);
        return $this->localizarBo->findAllById($this->session, $dto);
    }

    private function findById() {
        $dto = unserialize($_SESSION[PropertyKey::$session_clientes]);
        $imei = ($_REQUEST['txtImei']);
        foreach ($dto->getVehiculos() as $item) {
            if (($item->getImei() == $imei) && (!empty($item))) {
                $dtoVehiculo = $item;
                $dtoVehiculo->setImei($imei);
                break;
            }
        }
        $dto->setVehiculos(array($dtoVehiculo));
        return $this->localizarBo->findAllById($this->session, $dto);
    }

    private function findByDate() {
        $dto = unserialize($_SESSION[PropertyKey::$session_clientes]);
        $imei = ($_REQUEST['txtImei']);
        $fi = ($_REQUEST['txtFechaInicial']);
        $ff = ($_REQUEST['txtFechaFinal']);
        $hi = ($_REQUEST['txtHoraInicial']);
        $hf = ($_REQUEST['txtHoraFinal']);
        foreach ($dto->getVehiculos() as $item) {
            if (($item->getImei() == $imei) && (!empty($item))) {
                $dtoVehiculo = $item;
                $dtoVehiculo->setImei($imei);
                break;
            }
        }
        $dto->setVehiculos(array($dtoVehiculo));
        return $this->localizarBo->findByDate($this->session, $dto, $fi, $ff, $hi, $hf);
    }

    private function getClienteVehiculo($id) {
        $controller = new clienteVehiculoController();
        $controller->findByIdCliente($id);
    }

}
