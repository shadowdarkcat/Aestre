<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
/**
 * Description of DispositivoDao
 *
 * @author ShadowDarkCat
 */
interface DispositivoDao extends GenericDao{
    //put your code here
}
