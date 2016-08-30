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
        //$colonia = new BeanColonia();
        switch ($this->method) {
            case 0:
                $this->findAll(0);
                break;
            case 1:
                //$this->insert($cliente, $colonia);
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

    private function findAll($exist) {
        $this->redirect($this->clienteBo->findAll($this->session), $exist);
    }

    private function redirect($clientes, $exist) {
        if (!empty($clientes)) {
            $_SESSION[PropertyKey::$session_clientes] = serialize($clientes);
        }
        $_SESSION[PropertyKey::$session_exists] = $exist;
        header(PropertyKey::$php_main_cliente);
        die();
    }

}
