<?php

/**
 *
 * @author ShadowDarkCat
 */
interface LocalizarBo {

    function findAllById($user, $object);

    function findByDate($user, $obj, $fi, $ff, $hi, $hf);
}
