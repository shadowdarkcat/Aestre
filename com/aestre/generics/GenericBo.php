<?php

/**
 *
 * @author ShadowDarkCat
 */
interface GenericBo {

    function findAll($user);

    function findById($user, $obj);

    function insert($user, $obj);

    function update($user, $obj);

    function delete($user, $obj);
}
