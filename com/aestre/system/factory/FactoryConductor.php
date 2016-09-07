<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryConductor
 *
 * @author ShadowDarkCat
 */
class FactoryConductor {
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new DtoConductor();
        } else {
            $dto = new DtoConductor();
            $dto->setIdConductor($id);
            return $dto;
        }
    }

    //</editor-fold>
}
