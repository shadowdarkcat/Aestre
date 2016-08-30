<?php

/**
 *
 * @author ShadowDarkCat
 */
interface GenericDao {

    function findAll();

    function findById($obj);

    function insert($obj);

    function update($obj);

    function delete($obj);
}
