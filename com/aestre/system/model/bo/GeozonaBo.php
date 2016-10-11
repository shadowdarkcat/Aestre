<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 *
 * @author ShadowDarkCat
 */
interface GeozonaBo extends GenericBo{
 
    function verifyExists($user, $obj);
    function find($user, $obj);
    
}
