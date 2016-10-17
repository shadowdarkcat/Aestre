<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 *
 * @author ShadowDarkCat
 */
interface VehiculoDao extends GenericDao {

    function exist($obj);

    function findAllById($obj);

    function updateZona($obj);
    /* function updateRuta($obj); */
}
