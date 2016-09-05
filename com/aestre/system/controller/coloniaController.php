<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new coloniaController();
    $controller->colonias();
}
/**
 * Description of coloniaController
 *
 * @author ShadowDarkCat
 */
class coloniaController {
    private $session;
    private $method;
    private $coloniaBo;

    public function __construct() {
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        $this->coloniaBo = new ColoniaBoImpl();
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function colonias() {
        switch ($this->method) {
            case 0:
                $_SESSION[PropertyKey::$session_colonias]=json_encode($this->coloniaBo->findAll($this->session));
                break;
        }
    }
}
