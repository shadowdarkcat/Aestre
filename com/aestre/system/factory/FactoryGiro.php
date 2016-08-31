<?php
/**
 * Description of FactoryGiro
 *
 * @author ShadowDarkCat
 */
class FactoryGiro {
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function newInstance($id) {
        if (Utils::isReallyEmptyOrNull($id)) {
            return new BeanGiro();
        } else {
            $dto = new BeanGiro();
            $dto->setIdGiro($id);
            return $dto;
        }
    }

    //</editor-fold>
}
