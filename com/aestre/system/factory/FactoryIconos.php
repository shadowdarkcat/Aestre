<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of FactoryIconos
 *
 * @author ShadowDarkCat
 */
class FactoryIconos {
     //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanIconos();
        } else {
            $dto = new BeanIconos();
            $dto->setIdIcono($id);
            return $dto;
        }
    }

    //</editor-fold>
}
