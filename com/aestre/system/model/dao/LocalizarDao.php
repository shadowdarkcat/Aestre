<?php

/**
 * Description of LocalizarDao
 *
 * @author ShadowDarkCat
 */
interface LocalizarDao {

    function findAllById($obj);

    function findByDate($obj, $fi, $ff, $hi, $hf);
}
