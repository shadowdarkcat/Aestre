<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Clase que asigna los valores de las key de los archivos ini, para usar en el sistema
 *
 * @author ShadowDarkCat
 */
class PropertyKey {

    //<editor-fold defaultstate="collapsed" desc=Campos de Clase">
    private $propertyBean;
    public static $jdbc_server;
    public static $jdbc_data_base;
    public static $jdbc_user;
    public static $jdbc_password;
    public static $jdbc_port;
    public static $jdbc_charset;
    public static $jdbc_view_user;
    public static $jdbc_view_menu;
    public static $jdbc_view_privilegio;
    public static $jdbc_procedure_privilegios;
    public static $jdbc_view_colonia;
    public static $jdbc_view_colonia_id;
    public static $jdbc_view_dispositivo;
    public static $jdbc_view_dispositivo_id;
    public static $session_access;
    public static $session_usuario;
    public static $view_user;
    public static $view_password;
    public static $view_method;
    public static $php_index;
    public static $php_main_admin;
    public static $php_main_user;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores Privados">
    public function __construct() {
        $this->propertyBean = new BeanProperty();
        self::$jdbc_server = $this->getPropertyBd('jdbc.server');
        self::$jdbc_data_base = $this->getPropertyBd('jdbc.dataBase');
        self::$jdbc_user = $this->getPropertyBd('jdbc.user');
        self::$jdbc_password = $this->getPropertyBd('jdbc.password');
        self::$jdbc_port = $this->getPropertyBd('jdbc.port');
        self::$jdbc_charset = $this->getPropertyBd('jdbc.charSet');
        self::$jdbc_view_user = $this->getPropertyBd('jdbc.view.login');
        self::$jdbc_view_menu = $this->getPropertyBd('jdbc.view.menu');
        self::$jdbc_view_privilegio = $this->getPropertyBd('jdbc.view.menu.privilegio');
        self::$jdbc_view_colonia = $this->getPropertyBd('jdbc.view.colonia');
        self::$jdbc_view_colonia_id = $this->getPropertyBd('jdbc.view.colonia.id');
        self::$jdbc_view_dispositivo = $this->getPropertyBd('jdbc.view.dispositivo');
        self::$jdbc_view_dispositivo_id = $this->getPropertyBd('jdbc.view.dispositivo.id');
        self::$jdbc_procedure_privilegios = $this->getPropertyBd('jdbc.procedure.menu.privilegio');

        self::$session_access = $this->getPropertySystem('session.acces');
        self::$session_usuario = $this->getPropertySystem('session.usuario');

        self::$php_index = $this->getPropertySystem('php.index');
        self::$php_main_admin = $this->getPropertySystem('php.main.admin');
        self::$php_main_user = $this->getPropertySystem('php.main.user');

        self::$view_user = $this->getPropertySystem('view.user');
        self::$view_password = $this->getPropertySystem('view.password');
        self::$view_method = $this->getPropertySystem('view.method');
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private final function getPropertyBd($key) {
        return $this->propertyBean->getJdbc_property()[$key];
    }

    private final function getPropertySystem($key) {
        return $this->propertyBean->getSystem_property()[$key];
    }

    //</editor-fold>
}
