<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new dispositivoController();
    $controller->dispositivos();
}

/**
 * Description of dispositivoController
 *
 * @author ShadowDarkCat
 */
class dispositivoController {

    private $session;
    private $method;
    private $dispositivoBo;

    public function __construct() {
        $this->dispositivoBo = new DispositivoBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function dispositivos() {
        switch ($this->method) {
            case 0:
                $this->findAll();
                break;
        }
    }
    private function findAll() {
        $dispositivos = $this->dispositivoBo->findAll($this->session);
        if (!empty($dispositivos)) {
            $_SESSION[PropertyKey::$session_dispositivos] = serialize($dispositivos);
        }
    }
}
