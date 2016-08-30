<?php

define('PATH', realpath($_SERVER["DOCUMENT_ROOT"] . '/Aestre/com/aestre'));
define('CONTROLLER_PATH', PATH . '/system/controller');
define('MODEL_BEAN_PATH', PATH . '/system/model/bean');
define('MODEL_DTO_PATH', PATH . '/system/model/dto');
define('MODEL_FACTORY_PATH', PATH . '/system/factory');
define('B0_PATH', PATH . '/system/model/bo');
define('BO_IMPL_PATH', PATH . '/system/model/bo/impl');
define('DA0_PATH', PATH . '/system/model/dao');
define('DAO_IMPL_PATH', PATH . '/system/model/dao/impl');
define('GENERIC_PATH', PATH . '/generics');
define('UTILS_PATH', PATH . '/utils');

function aestre_autoload($className) {
     $paths = array(
        CONTROLLER_PATH,
        MODEL_BEAN_PATH,
        MODEL_DTO_PATH,
        MODEL_FACTORY_PATH,
        B0_PATH,
        BO_IMPL_PATH,
        DA0_PATH,
        DAO_IMPL_PATH,
        GENERIC_PATH,
        UTILS_PATH
    );

    foreach ($paths as $path) {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        if (file_exists($path . DIRECTORY_SEPARATOR . $className . '.php')) {
            require_once($path . DIRECTORY_SEPARATOR . $className . '.php');
        }
    }
}
