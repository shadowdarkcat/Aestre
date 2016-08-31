<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of MenuDaoImpl
 *
 * @author ShadowDarkCat
 */
class MenuDaoImpl implements MenuDao {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $jdbc;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        new PropertyKey();
        $this->jdbc = new Jdbc();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function getMenu() {
        $menu = array();
        $query = Utils::replaceQueryMenu(PropertyKey::$jdbc_view_menu, array(0));
        $rs = $this->jdbc->query($query);
        while ($row = mysqli_fetch_array($rs)) {
            $menu[] = SqlUtils::getFields(FactoryMenu::newInstance(NULL), $row);
        }
        SqlUtils::close($this->jdbc, $rs);
        foreach ($menu as $cont => $item) {
            if ($item->getId() !== NULL) {
                $item->setChildItems($this->getChildItems($item));
            }
        }
        return $menu;
    }

    public function getMenuPrivilegios($user) {
        $privilegiosIds = array();
        $menu = array();
        $query = utils::replaceQuery(PropertyKey::$jdbc_view_privilegio, array($user->getIdUsuario()));
        $rs = $this->jdbc->query($query);
        while ($row = mysqli_fetch_array($rs)) {
            $ids = array();
            $ids[0] = $row[0];
            $ids[1] = $row[1];
            $privilegiosIds[] = $ids;
        }
        SqlUtils::close($this->jdbc, $rs);
        $menu = $this->getMenu($user);
        $menu = $this->filtrarMenuUsuarios($menu, $privilegiosIds);
        return $menu;
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public function insertMultiplesPrivilegios($user, $nuevoMenu) {
        $this->deletePrivilegios($user);
        foreach ($nuevoMenu as $menuItem) {
            $this->insertPrivilegio($user, $menuItem);
        }
    }

    public function insertPrivilegio($user, $menuItem) {
        $args = array(1, $menuItem->getId(), $user->getId());
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_privilegios, $args));
    }

    public function deletePrivilegios($user) {
        $args = array(2, FactoryMenu::newInstance(NULL), $user->getId());
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_privilegios, $args));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private final function getChildItems($item) {
        if ($item->getId() !== NULL) {
            $menu = array();
            $rs = $this->jdbc->query(Utils::replaceQueryMenu(PropertyKey::$jdbc_view_menu, array($item->getId())));
            while ($row = mysqli_fetch_array($rs)) {
                $menu[] = SqlUtils::getFields(FactoryMenu::newInstance(NULL), $row);
            }
            SqlUtils::close($this->jdbc, $rs);
            foreach ($menu as $cont => $items) {
                $items->setParentItem($item);
                $items->setChildItems($this->getChildItems($items));
            }
            return $menu;
        }
    }

    private final function filtrarMenuUsuarios($menu, $privilegiosIds) {
        if (empty($menu[0]->getId())) {
            unset($menu[0]);
            $menu = array_values($menu);
        }
        $index = 1;
        foreach ($menu as &$item) {
            $bandera = true;
            foreach ($privilegiosIds as $recorridoId) {
                if ($recorridoId[0] == $item->getId() && $bandera) {
                    $bandera = false;
                }
            }
            if ($bandera) {
                unset($menu[$index]);
                $item = @array_values($menu[$index]);
            } else {
                if ($item->getChildItems() != null && $item->getChildItems() > 0) {
                    $item->setChildItems($this->filtrarMenuUsuarios($item->getChildItems(), $privilegiosIds));
                }
            }
            $index++;
        }
        return $menu;
    }

    //</editor-fold>
}
