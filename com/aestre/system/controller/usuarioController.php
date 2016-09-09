<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new usuarioController();
    $controller->usuarios();
}

/**
 * Description of usuarioController
 *
 * @author ShadowDarkCat
 */
class usuarioController {

    private $session;
    private $method;
    private $loginBo;
    private $menuBo;
    private $clienteBo;

    public function __construct() {
        $this->loginBo = new LoginBoImpl();
        $this->menuBo = new MenuBoImpl();
        $this->clienteBo = new ClienteBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function usuarios() {
        $usuario = new DtoLogin();
        switch ($this->method) {
            case 0:
                $this->findAll(FALSE);
                break;
            case 6:
                echo(json_encode($this->getMenu($usuario)));
                break;
        }
    }

    private function findAll($exist) {
        $this->redirect($this->loginBo->findAll($this->session), $exist);
    }

    private function getMenu($usuario) {
        $id = isset($_REQUEST[PropertyKey::$view_usuario_id]) ? strtoupper($_REQUEST[PropertyKey::$view_usuario_id]) : NULL;
        $str = NULL;
        if (empty($id)) {
            $ar = $this->menuBo->getConvercionMenu($this->session);
        } else {
            $usuario->setIdUsuario($id);
            $ar = $this->menuBo->getConvercionMenu($usuario);
        }
        foreach ($ar as $item) {
            $str .= $item;
        }
        $json = array('html' => $str);
        return $json;
    }

    private function redirect($usuarios, $exist) {
        if (!empty($usuarios)) {
            $_SESSION[PropertyKey::$session_users] = serialize($usuarios);
        }
        $_SESSION[PropertyKey::$session_exists] = $exist;
        echo(PropertyKey::$php_main_usuario);
    }

}
