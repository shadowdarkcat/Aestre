<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of MenuBoImpl
 *
 * @author ShadowDarkCat
 */
class MenuBoImpl implements MenuBo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $menuDao;
    private $index;
    private $str;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->index = 0;
        $this->menuDao = new MenuDaoImpl();
        $this->str = array();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function getMenu(DtoLogin $user) {
        return $this->menuDao->getMenu($user);
    }

    public function getMenuUsuario(DtoLogin $obj) {
        $buffer = NULL;
        if (!empty($obj->getIdUsuario())) {
            $menu = $this->menuDao->getMenuPrivilegios($obj);
            foreach ($menu as $item => $val) {
                if (isset($val)) {
                    if (empty($val->getLink())) {
                        $buffer.="\n\t<li class='dropdown'><a href='#' target='"
                                . $val->getTarget() . "' class='dropdown-toggle' data-toggle='dropdown'>\n"
                                . "<img src='" . $val->getImage() . "'>" . $val->getLeyenda()
                                . "\n<b class='caret'></b></a>\n<ul class='dropdown-menu' role='menu'>\n";
                        $buffer .= $this->getMenuString($val);
                    } else {
                        $buffer.="\n\t<li><a href='" . $val->getLink() . "' target='"
                                . $val->getTarget() . "'>"
                                . "\n<img src='" . $val->getImage() . "'>"
                                . $val->getLeyenda()
                                . "</a></li>\n";
                    }
                    if (empty($val->getLink())) {
                        $buffer .= "</ul></li>";
                    }
                }
            }
        }
        return $buffer;
    }

    public function getMenuPrivilegios(DtoLogin $user) {
        return $this->menuDao->getMenuPrivilegios($user);
    }

    public function getConvercionMenu(DtoLogin $user) {
        return $this->primerRecorridoMenu($this->getMenu($user), $this->getMenuPrivilegios($user));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insertMultiplesPrivilegios(DtoLogin $user, BeanMenu $nuevoMenu, DtoLogin $obj) {
        if (Utils::isSessionValid($user)) {
            $this->menuDao->insertMultiplesPrivilegios($obj, $nuevoMenu);
        }
    }

    public function insertPrivilegio(DtoLogin $user, DtoLogin $obj, BeanMenu $menuItem) {
        if (Utils::isSessionValid($user)) {
            $this->menuDao->insertPrivilegio($obj, $menuItem);
        }
    }

    public function deletePrivilegios(DtoLogin $user, DtoLogin $obj) {
        if (Utils::isSessionValid($user)) {
            $this->menuDao->deletePrivilegios($obj);
        }
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private final function getMenuString($itemA) {
        $buffer = NULL;
        $childItems = $itemA->getChildItems();
        foreach ($childItems as $item) {
            if (isset($item)) {
                if (empty($item->getLink())) {
                    $buffer.="\n\t<li class='dropdown-submenu'><a tabindex='0' data-toggle='dropdown'>" . $item->getLeyenda()
                            . "</a>\n<ul class='dropdown-menu'>\n";
                } else {
                    $buffer.="\n\t<li><a id='link" . $this->index . "' href='" . $item->getLink() . "' target='"
                            . $item->getTarget() . "'>"
                            . "\n<img src='" . $item->getImage() . "' style='align: left;'>"
                            . $item->getLeyenda()
                            . "</a></li>\n";
                    $this->index++;
                }
                $buffer.=$this->getMenuString($item);
            }
        }
        return $buffer;
    }

    private final function primerRecorridoMenu($menu, $menuDeUsuario) {
        array_push($this->str, '<div style="display: display;"><ul id="nodoPrincipal">');
        $this->recorridoMenu($menu, $menuDeUsuario);
        array_push($this->str, '</ul>' . '</div>');
        return $this->str;
    }

    private final function recorridoMenu($menu, $menuDeUsuario) {
        if ($menu != null && !empty($menu)) {
            foreach ($menu as $menuHijo) {
                if (isset($menuHijo)) {
                    if ($menuHijo->getLeyenda() != NULL && !empty($menuHijo->getLeyenda())) {
                        array_push($this->str, '<li class="collapsed"><input type="checkbox" id="chkMenu[]" name="chkMenu[]" '
                                . 'class="checkbox-inline text-muted" checked="'
                                . ($this->existeNodo($menuHijo, $menuDeUsuario) ? 'checked' : '')
                                . '" value="' . $menuHijo->getId()
                                . '" ><label class="font-size" title="' . $menuHijo->getToolTip() . '">' . $menuHijo->getLeyenda()
                                . '</label>');
                        if ($menuHijo->getChildItems() != null && !empty($menuHijo->getChildItems())) {
                            array_push($this->str, '<ul>');
                            $this->recorridoMenu($menuHijo->getChildItems(), $menuDeUsuario);
                            array_push($this->str, '</ul>');
                        }
                        array_push($this->str, '</li>');
                    }
                }
            }
        }
    }

    private final function existeNodo($nodo, $menuDeUsuario) {
        if (@strpos($menuDeUsuario, $nodo)) {
            return true;
        } else {
            $bandera = false;
            foreach ($menuDeUsuario as $menuItem) {
                if (isset($menuItem)) {
                    if ($menuItem->getChildItems() != null && !empty($menuItem->getChildItems())) {
                        if ($bandera) {
                            return true;
                        } else {
                            $bandera = $this->existeNodo($nodo, $menuItem->getChildItems());
                        }
                    }
                }
            }
            return $bandera;
        }
    }

    //</editor-fold>
}
