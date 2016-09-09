<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new clienteController();
    $controller->clientes();
}

/**
 * Description of clienteController
 *
 * @author ShadowDarkCat
 */
class clienteController {

    private $session;
    private $method;
    private $clienteBo;

    public function __construct() {
        $this->clienteBo = new ClienteBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function clientes() {
        $dto = new DtoCliente();
        $colonia = new BeanCp();
        switch ($this->method) {
            case 0:
                $this->findAll(FALSE);
                break;
            case 1:
                $this->insert($dto, $colonia);
                break;
            case 2:
                $this->update($dto, $colonia);
                break;
            case 3:
                $this->delete($dto, $colonia);
                break;
            case 4:
                echo (json_encode($this->findById($dto, $colonia)));
                break;
        }
    }

    public function findAllToUsuario() {
        unset($_SESSION[PropertyKey::$session_clientes]);
        $clientes = $this->clienteBo->findAll($this->session);
        if (!empty($clientes)) {
            $_SESSION[PropertyKey::$session_clientes] = serialize($clientes);
        }
    }

    public function findAll($exist) {
        $this->redirect($this->clienteBo->findAll($this->session), $exist);
    }

    private function findById(DtoCliente $cliente, BeanCp $colonia) {
        return $this->clienteBo->findById($this->session, $this->getParametersFromRequest($cliente, $colonia));
    }

    private function redirect($clientes, $exist) {
        if (!empty($clientes)) {
            $_SESSION[PropertyKey::$session_clientes] = serialize($clientes);
        }
        $_SESSION[PropertyKey::$session_exists] = serialize($exist);
        echo(PropertyKey::$php_main_cliente);
    }

    private function insert(DtoCliente $cliente, BeanCp $colonia) {
        $dto = $this->getParametersFromRequest($cliente, $colonia);
        $exist = $this->clienteBo->exist($this->session, $dto);
        if (!$exist) {
            $this->clienteBo->insert($this->session, $dto);
            $this->findAll(FALSE);
        } else {
            $this->findAll(TRUE);
        }
    }

    private function update(DtoCliente $cliente, BeanCp $colonia) {
        $this->clienteBo->update($this->session, $this->getParametersFromRequest($cliente, $colonia));
        $this->findAll(FALSE);
    }

    private function delete(DtoCliente $cliente, BeanCp $colonia) {
        $this->clienteBo->delete($this->session, $this->getParametersFromRequest($cliente, $colonia));
        $this->findAll(FALSE);
    }

    private function getParametersFromRequest(DtoCliente $cliente, BeanCp $colonia) {
        $cliente->setIdCliente(isset($_REQUEST[PropertyKey::$view_cliente_id]) ? $_REQUEST[PropertyKey::$view_cliente_id] : NULL );
        $cliente->setNombre(strtoupper($_REQUEST[PropertyKey::$view_nombre]));
        $cliente->setPaterno(strtoupper($_REQUEST[PropertyKey::$view_paterno]));
        $cliente->setMaterno(strtoupper($_REQUEST[PropertyKey::$view_materno]));
        $cliente->setCalle(strtoupper($_REQUEST[PropertyKey::$view_calle]));
        $cliente->setNoExterior(strtoupper($_REQUEST[PropertyKey::$view_noExt]));
        $cliente->setNoInterior(isset($_REQUEST[PropertyKey::$view_noInt]) ? strtoupper($_REQUEST[PropertyKey::$view_noInt]) : NULL);
        $cliente->setBeanCp(FactoryCp::newInstance($_REQUEST[PropertyKey::$view_idCp]));
        $cliente->setTelefono($_REQUEST[PropertyKey::$view_telefono]);
        $cliente->setOtroTelefono(isset($_REQUEST[PropertyKey::$view_otro_telefono]) ? $_REQUEST[PropertyKey::$view_otro_telefono] : NULL);
        $cliente->setMail(strtolower($_REQUEST[PropertyKey::$view_mail]));
        $cliente->setGiro($_REQUEST[PropertyKey::$view_giro]);
        $cliente->setActivo(isset($_REQUEST[PropertyKey::$view_chkActivo]) ? Utils::isIsset($_REQUEST[PropertyKey::$view_chkActivo]) : Utils::isIsset(NULL));
        $cliente->setRefresh(NULL);
        return $cliente;
    }

}
