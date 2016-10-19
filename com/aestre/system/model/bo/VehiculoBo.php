<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 *
 * @author ShadowDarkCat
 */
interface VehiculoBo extends GenericBo {

    function exist($user, $obj);

    function findAllById($user, $obj);

    function find($user, $obj);

    function updateRuta($user, $obj);

    function updateZona($user, $obj);
}
