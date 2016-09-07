<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryLicencia
 *
 * @author ShadowDarkCat
 */
class FactoryLicencia {
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanLicencia();
        } else {
            $dto = new BeanLicencia();
            $dto->setIdLicencia($id);
            return $dto;
        }
    }

    //</editor-fold>
}
