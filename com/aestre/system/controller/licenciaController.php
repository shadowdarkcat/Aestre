<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new iconosController();
    $controller->licencias();
}

/**
 * Description of licenciaController
 *
 * @author ShadowDarkCat
 */
class licenciaController {

    private $session;
    private $method;
    private $licenciaBo;

    public function __construct() {
        $this->licenciaBo = new LicenciaBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function licencias() {
        switch ($this->method) {
            case 0:
                $this->findAll();
                break;
        }
    }

    private function findAll() {
        $licencias = $this->licenciaBo->findAll($this->session);
        if (!empty($licencias)) {
            $_SESSION[PropertyKey::$session_licencias] = serialize($licencias);
        }
    }

}
