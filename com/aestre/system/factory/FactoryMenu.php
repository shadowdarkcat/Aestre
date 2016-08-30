<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryMenu
 *
 * @author ShadowDarkCat
 */
class FactoryMenu {

    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanMenu();
        } else {
            $dto = new BeanMenu();
            $dto->setId($id);
            return $dto;
        }
    }

    //</editor-fold>
}
