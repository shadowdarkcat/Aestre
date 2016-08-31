<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryCp
 *
 * @author ShadowDarkCat
 */
class FactoryCp {
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanCp();
        } else {
            $bean = new BeanCp();
            $bean->setIdCp($id);
            return $bean;
        }
    }

    //</editor-fold>
}
