<?php

/**
 * Clase encargada de leer los archivos ini del sistema
 *
 * @author ShadowDarkCat
 */
class PropertyRead {

    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    /**
     * Funci&oacute;n que devuelve el archivo ini indicando la ruta
     * @param text $path
     * @return array
     */
    public static final function readProperty($path) {
        return parse_ini_file($path);
    }

    //</editor-fold>
}
