<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryZona
 *
 * @author ShadowDarkCat
 */
class FactoryZona {
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanGeozona();
        } else {
            $dto = new BeanGeozona();
            $dto->setId($id);
            return $dto;
        }
    }

    //</editor-fold>
}
