<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 *
 * @author ShadowDarkCat
 */
interface MenuBo {

    function getMenu(DtoLogin $user);

    function getMenuUsuario(DtoLogin $obj);

    function getMenuPrivilegios(DtoLogin $user);

    function getConvercionMenu(DtoLogin $user);

    function insertMultiplesPrivilegios(DtoLogin $user, BeanMenu $nuevoMenu, DtoLogin $obj);

    function insertPrivilegio(DtoLogin $user, DtoLogin $obj, BeanMenu $menuItem);

    function deletePrivilegios(DtoLogin $user, DtoLogin $obj);
}
