<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryGeoruta
 *
 * @author ShadowDarkCat
 */
class FactoryGeoruta {
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanGeoruta();
        } else {
            $bean = new BeanGeoruta();
            $bean->setId($id);
            return $bean;
        }
    }

    //</editor-fold>
}
