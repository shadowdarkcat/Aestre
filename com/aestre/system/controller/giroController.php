<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (isset($_REQUEST['method'])) {
    $controller = new giroController();
    $controller->giros();
}

/**
 * Description of giroController
 *
 * @author ShadowDarkCat
 */
class giroController {

    private $session;
    private $method;
    private $giroBo;

    public function __construct() {
        $this->giroBo = new GiroBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function giros() {
        switch ($this->method) {
            case 0:
                $this->findAll();
                break;
        }
    }

    private function findAll() {
        $giro = $this->giroBo->findAll($this->session);
        if (!empty($giro)) {
            $_SESSION[PropertyKey::$session_giro] = serialize($giro);
        }
    }

}
