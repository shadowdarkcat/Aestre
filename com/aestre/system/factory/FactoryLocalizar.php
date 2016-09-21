<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryCliente
 *
 * @author ShadowDarkCat
 */
class FactoryLocalizar {
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanLocalizar();
        } else {
            $bean = new BeanLocalizar();
            $bean->setId($id);
            return $bean;
        }
    }

    //</editor-fold>
}
