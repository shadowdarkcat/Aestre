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
            case 1:
                $this->insert($usuario);
                break;
            case 2:
                $this->update($usuario);
                break;
            case 3:
                $this->delete($usuario);
                break;
            case 6:
                echo(json_encode($this->getMenu($usuario)));
                break;
        }
    }

    private function findAll($exist) {
        $this->redirect($this->loginBo->findAll($this->session), $exist);
    }

    private function insert(DtoLogin $usuario) {
        $usuario = $this->getParametersFromRequest($usuario);
        $exist = $this->loginBo->exist($this->session, $usuario);
        if (!$exist) {
            $object = FactoryLogin::newInstance(NULL);
            $idInsert = $this->loginBo->insert($this->session, $usuario);
            $object->setIdUsuario($idInsert);
            $this->menuBo->insertMultiplesPrivilegios($this->session, $this->getPropiedadesDelMenu(), $object);
        }
        $this->findAll($exist);
    }

    private function update(DtoLogin $usuario) {
        $this->loginBo->update($this->session, $this->getParametersFromRequest($usuario));
        $this->menuBo->insertMultiplesPrivilegios($this->session, $this->getPropiedadesDelMenu(), $usuario);
        $this->findAll(FALSE);
    }

    private function delete(DtoLogin $usuario) {
        $this->loginBo->delete($this->session, $this->getParametersFromRequest($usuario));
        $this->findAll(FALSE);
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
        $_SESSION[PropertyKey::$session_exists] = serialize($exist);
        echo(PropertyKey::$php_main_usuario);
    }

    private function getParametersFromRequest(DtoLogin $usuario) {
        $usuario->setIdUsuario(isset($_REQUEST[PropertyKey::$view_usuario_id]) ? strtoupper($_REQUEST[PropertyKey::$view_usuario_id]) : NULL );
        $usuario->setNombreUsuario(strtoupper($_REQUEST[PropertyKey::$view_user]));
        $usuario->setPwd(isset($_REQUEST[PropertyKey::$view_password]) ? strtoupper($_REQUEST[PropertyKey::$view_password]) : NULL);
        $usuario->setNombre(strtoupper($_REQUEST[PropertyKey::$view_nombre]));
        $usuario->setTelefono(strtoupper($_REQUEST[PropertyKey::$view_telefono]));
        $usuario->setMail(strtolower($_REQUEST[PropertyKey::$view_mail]));
        $usuario->setActivo(isset($_REQUEST[PropertyKey::$view_chkActivo]) ? Utils::isIsset($_REQUEST[PropertyKey::$view_chkActivo]) : Utils::isChecked(NULL));
        $usuario->setAdmin(isset($_REQUEST[PropertyKey::$view_chkAdmin]) ? Utils::isIsset($_REQUEST[PropertyKey::$view_chkAdmin]) : Utils::isChecked(NULL));
        $usuario->setIdCliente(isset($_REQUEST[PropertyKey::$view_cbo_clientes]) ? strtoupper($_REQUEST[PropertyKey::$view_cbo_clientes]) : NULL );
        return $usuario;
    }

    private function getPropiedadesDelMenu() {
        $valores = isset($_REQUEST[PropertyKey::$view_chk_menu]) ? $_REQUEST[PropertyKey::$view_chk_menu] : NULL;
        $menu = array();
        if (!empty($valores)) {
            foreach ($valores as $item) {
                $menuItem = FactoryMenu::newInstance(NULL);
                $menuItem->setId($item);
                $menu[] = $menuItem;
            }
        }
        return $menu;
    }

}
