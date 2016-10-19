<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Clase que conendr&aacute; las utilerias del sistema
 *
 * @author Gabriel J Hurtado Díaz (GJHD)
 */
class Utils {

    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    /**
     * Funci&oacute;n que verifica si un texto se encuentra vacio o nulo
     * @param $str Texto
     * @return Boolean
     */
    public static final function isReallyEmptyOrNull($str) {
        return empty($str) || is_null($str);
    }

    public static final function isIsset($obj) {
        return isset($obj);
    }

    /**
     * Funci&oacute;n para verificar si se encuentra la sesi&oacute;n activa
     * @param DtoLogin $user
     * @return Boolean
     */
    public static function isSessionValid($user) {
        if (!empty($user)) {
            return true;
        }
        return false;
    }

    /**
     * Funci&oacute;n para verificar si se encuentra activo o inactivo un
     * registro
     *
     * @param $str Text
     * @return Boolean
     */
    public static function isChecked($str) {
        if (self::isReallyEmptyOrNull($str)) {
            return FALSE;
        } else {
            return settype($str, 'boolean');
        }
    }

    /**
     * Funci&oacute;n que crea el query acorde a los parametros indicados en el array
     * @param String $strQuery
     * @param Array $obj
     * @return SqlSentence
     */
    public static final function replaceQueryMenu($strQuery, $obj) {
        //$indexObj = count($obj);
        $indx = 0;
        $query = '';
        for ($index = 0; $index < strlen($strQuery); $index++) {
            if (strcmp($strQuery{$index}, '?') == 0) {
                $val = $obj[$indx];
                if (empty($val) && $val != 0) {
                    $query.='NULL';
                } else {
                    $query.=$val;
                }
                $indx++;
            } else {
                $query.=$strQuery{$index};
            }
        }
        return $query;
    }

    public static final function replaceQuery($strQuery, $obj) {
        $indx = 0;
        $query = '';
        for ($index = 0; $index < strlen($strQuery); $index++) {
            if (strcmp($strQuery{$index}, '?') == 0) {
                $val = $obj[$indx];
                if (empty($val)) {
                    $query.='NULL';
                } else {
                    $query.=$val;
                }
                $indx++;
            } else {
                $query.=$strQuery{$index};
            }
        }
        return $query;
    }

    //</editor-fold>
}
