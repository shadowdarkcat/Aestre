<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
session_start();
if (isset($_REQUEST['method'])) {
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
                // $this->update($cliente, $colonia);
                break;
            case 3:
                //$this->delete($cliente, $colonia);
                break;
            case 4:
                // $this->activate($cliente, $colonia);
                break;
            case 5:
                // echo (json_encode($this->findById($cliente, $colonia)));
                break;
        }
    }

    public function findAll($exist) {
        $this->redirect($this->clienteBo->findAll($this->session), $exist);
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

    private function getParametersFromRequest(DtoCliente $cliente, BeanCp $colonia) {
        $cliente->setIdCliente(isset($_REQUEST[PropertyKey::$view_cliente_id]) ? strtoupper($_REQUEST[PropertyKey::$view_cliente_id]) : NULL );
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
        $cliente->setBeanGiro(FactoryGiro::newInstance($_REQUEST[PropertyKey::$view_cboGiro]));
        $cliente->setActivo(Utils::isChecked($_REQUEST[PropertyKey::$view_chkActivo]));
        $cliente->setRefresh(NULL);
        return $cliente;
    }

}
