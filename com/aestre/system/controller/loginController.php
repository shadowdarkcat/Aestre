<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new loginController();
    $controller->login();
}

/**
 * Description of loginController
 *
 * @author ShadowDarkCat
 */
class loginController {

    private $method;

    public function __construct() {

        $this->loginBo = new LoginBoImpl();
        if (Utils::isIsset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);
    }

    public function login() {
        $obj = FactoryLogin::newInstance(NULL);
        $menu = new MenuBoImpl();
        switch ($this->method) {
            case 0:
                $this->doLogin($obj, $menu);
                break;
        }
    }

    private function doLogin(DtoLogin $obj, $menu) {
        $user = $_REQUEST[PropertyKey::$view_user];
        $pwd = $_REQUEST[PropertyKey::$view_password];
        if (isset($user) && isset($pwd)) {
            $obj->setNombreUsuario(strtoupper($user));
            $obj->setPwd(strtoupper($pwd));
            $validate = $this->loginBo->validateLogin(NULL, $obj);
            if (!Utils::isIsset($validate)) {
                $_SESSION[PropertyKey::$session_access] = 0;
                header(PropertyKey::$php_index);
            } else if ($validate->getIdUsuario() != 0) {
                unset($_SESSION[PropertyKey::$session_access]);
                $validate->setMenu($menu->getMenuUsuario($validate));
                DtoLogin::setSession($validate);
                if ($validate->getAdmin()) {
                    header(PropertyKey::$php_main_admin);
                } else {
                    echo(PropertyKey::$php_main_user);
                }
            }
        }
        die();
    }

}
