<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryLogin
 *
 * @author ShadowDarkCat
 */
class FactoryLogin {

    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new DtoLogin();
        } else {
            $dto = new DtoLogin();
            $dto->setId($id);
            return $dto;
        }
    }

    //</editor-fold>
}
