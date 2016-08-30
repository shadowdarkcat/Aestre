<?php

/**
 *
 * @author ShadowDarkCat
 */
interface MenuDao {

    function getMenu();

    function getMenuPrivilegios($user);

    function insertMultiplesPrivilegios($user, $nuevoMenu);

    function insertPrivilegio($user, $menuItem);

    function deletePrivilegios($user);
}
