<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 *
 * @author ShadowDarkCat
 */
interface ClienteBo extends GenericBo {

    function exist($user, $obj);

    function findByIdFromCv($user, $obj);
}
