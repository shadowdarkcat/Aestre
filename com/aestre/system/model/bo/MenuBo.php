<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 *
 * @author ShadowDarkCat
 */
interface MenuBo {

    function getMenu($user);

    function getMenuUsuario($obj);

    function getMenuPrivilegios($user);

    function getConvercionMenu($user);

    function insertMultiplesPrivilegios($user, $nuevoMenu, $obj);

    function insertPrivilegio($user, $obj, $menuItem);

    function deletePrivilegios($user, $obj);
}
