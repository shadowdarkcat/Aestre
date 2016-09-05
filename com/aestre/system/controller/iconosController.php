<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new iconosController();
    $controller->iconos();
}

/**
 * Description of iconosController
 *
 * @author ShadowDarkCat
 */
class iconosController {

    private $session;
    private $method;
    private $iconosBo;

    public function __construct() {
        $this->iconosBo = new IconosBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function iconos() {
        switch ($this->method) {
            case 0:
                $this->findAll();
                break;
        }
    }

    private function findAll() {
        $iconos = $this->iconosBo->findAll($this->session);
        if (!empty($iconos)) {
            $_SESSION[PropertyKey::$session_iconos] = serialize($iconos);
        }
    }

}
