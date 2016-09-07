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
    public static $jdbc_function_exist_cliente;
    public static $jdbc_function_exist_vehiculo;
    public static $jdbc_function_exist_conductor;
    public static $jdbc_function_last_conductor;
    public static $jdbc_procedure_privilegios;
    public static $jdbc_procedure_cliente;
    public static $jdbc_procedure_vehiculo;
    public static $jdbc_procedure_conductor;
    public static $jdbc_view_user;
    public static $jdbc_view_menu;
    public static $jdbc_view_privilegio;
    public static $jdbc_view_colonia;
    public static $jdbc_view_colonia_id;
    public static $jdbc_view_dispositivo;
    public static $jdbc_view_dispositivo_id;
    public static $jdbc_view_cliente;
    public static $jdbc_view_cliente_id;
    public static $jdbc_view_giro;
    public static $jdbc_view_giro_id;
    public static $jdbc_view_cp;
    public static $jdbc_view_cp_id;
    public static $jdbc_view_iconos;
    public static $jdbc_view_iconos_id;
    public static $jdbc_view_vehiculos;
    public static $jdbc_view_vehiculos_id;
    public static $jdbc_view_cliente_vehiculo_cliente;
    public static $jdbc_view_cliente_vehiculo_vehiculo;
    public static $jdbc_view_cliente_vehiculo_conductor;
    public static $jdbc_view_cliente_vehiculo;
    public static $jdbc_view_licencia;
    public static $jdbc_view_licencia_id;
    public static $jdbc_view_conductor;
    public static $jdbc_view_conductor_id;
    public static $session_access;
    public static $session_usuario;
    public static $session_clientes;
    public static $session_exists;
    public static $session_giro;
    public static $session_colonias;
    public static $session_dispositivos;
    public static $session_iconos;
    public static $session_vehiculos;
    public static $session_licencias;
    public static $session_conductores;
    public static $view_user;
    public static $view_password;
    public static $view_method;
    public static $view_cliente_id;
    public static $view_nombre;
    public static $view_paterno;
    public static $view_materno;
    public static $view_telefono;
    public static $view_otro_telefono;
    public static $view_mail;
    public static $view_calle;
    public static $view_noExt;
    public static $view_noInt;
    public static $view_idCp;
    public static $view_giro;
    public static $view_chkActivo;
    public static $view_cboGiro;
    public static $view_vehiculo_id;
    public static $view_cbo_clientes;
    public static $view_imei;
    public static $view_cbo_gps;
    public static $view_modelo;
    public static $view_marca;
    public static $view_placa;
    public static $view_color;
    public static $view_dtp_verificacion;
    public static $view_icono_id;
    public static $view_licencia;
    public static $view_vigencia;
    public static $view_cbo_licencia;
    public static $view_cbo_vehiculo;
    public static $view_idConductor;
    public static $php_index;
    public static $php_main_admin;
    public static $php_main_user;
    public static $php_main_cliente;
    public static $php_main_vehiculo;
    public static $php_main_conductor;

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
        self::$jdbc_view_cliente = $this->getPropertyBd('jdbc.view.cliente');
        self::$jdbc_view_cliente_id = $this->getPropertyBd('jdbc.view.cliente.id');
        self::$jdbc_view_giro = $this->getPropertyBd('jdbc.view.giro');
        self::$jdbc_view_giro_id = $this->getPropertyBd('jdbc.view.giro.id');
        self::$jdbc_view_iconos = $this->getPropertyBd('jdbc.view.iconos');
        self::$jdbc_view_iconos_id = $this->getPropertyBd('jdbc.view.iconos.id');
        self::$jdbc_view_vehiculos = $this->getPropertyBd('jdbc.view.vehiculos');
        self::$jdbc_view_vehiculos_id = $this->getPropertyBd('jdbc.view.vehiculos.id');
        self::$jdbc_view_cp = $this->getPropertyBd('jdbc.view.cp');
        self::$jdbc_view_cp_id = $this->getPropertyBd('jdbc.view.cp.id');
        self::$jdbc_view_cliente_vehiculo_cliente = $this->getPropertyBd('jdbc.view.cliente.vehiculo.idCliente');
        self::$jdbc_view_cliente_vehiculo_vehiculo = $this->getPropertyBd('jdbc.view.cliente.vehiculo.idVehiculo');
        self::$jdbc_view_cliente_vehiculo_conductor = $this->getPropertyBd('jdbc.view.cliente.vehiculo.idConductor');
        self::$jdbc_view_cliente_vehiculo = $this->getPropertyBd('jdbc.view.cliente.vehiculo');
        self::$jdbc_view_licencia = $this->getPropertyBd('jdbc.view.licencias');
        self::$jdbc_view_licencia_id = $this->getPropertyBd('jdbc.view.licencias.id');
        self::$jdbc_view_conductor = $this->getPropertyBd('jdbc.view.conductores');
        self::$jdbc_view_conductor_id = $this->getPropertyBd('jdbc.view.conductores.id');

        self::$jdbc_procedure_privilegios = $this->getPropertyBd('jdbc.procedure.menu.privilegio');

        self::$jdbc_function_exist_cliente = $this->getPropertyBd('jdbc.function.exist.cliente');
        self::$jdbc_function_exist_vehiculo = $this->getPropertyBd('jdbc.function.exist.vehiculo');
        self::$jdbc_function_exist_conductor = $this->getPropertyBd('jdbc.function.exist.conductor');
        self::$jdbc_function_last_conductor = $this->getPropertyBd('jdbc.function.last.conductor');
        self::$jdbc_procedure_cliente = $this->getPropertyBd('jdbc.procedure.cliente');
        self::$jdbc_procedure_vehiculo = $this->getPropertyBd('jdbc.procedure.vehiculo');
        self::$jdbc_procedure_conductor = $this->getPropertyBd('jdbc.procedure.conductor');

        self::$session_access = $this->getPropertySystem('session.acces');
        self::$session_usuario = $this->getPropertySystem('session.usuario');
        self::$session_clientes = $this->getPropertySystem('session.clientes');
        self::$session_exists = $this->getPropertySystem('session.exists');
        self::$session_giro = $this->getPropertySystem('session.giro');
        self::$session_colonias = $this->getPropertySystem('session.colonias');
        self::$session_dispositivos = $this->getPropertySystem('session.dispositivos');
        self::$session_iconos = $this->getPropertySystem('session.iconos');
        self::$session_vehiculos = $this->getPropertySystem('session.vehiculos');
        self::$session_licencias = $this->getPropertySystem('session.licencias');
        self::$session_conductores = $this->getPropertySystem('session.conductores');

        self::$php_index = $this->getPropertySystem('php.index');
        self::$php_main_admin = $this->getPropertySystem('php.main.admin');
        self::$php_main_user = $this->getPropertySystem('php.main.user');
        self::$php_main_cliente = $this->getPropertySystem('php.main.cliente');
        self::$php_main_vehiculo = $this->getPropertySystem('php.main.vehiculo');
        self::$php_main_conductor = $this->getPropertySystem('php.main.conductor');

        self::$view_user = $this->getPropertySystem('view.user');
        self::$view_password = $this->getPropertySystem('view.password');
        self::$view_method = $this->getPropertySystem('view.method');
        self::$view_cliente_id = $this->getPropertySystem('view.cliente.id');
        self::$view_nombre = $this->getPropertySystem('view.nombre');
        self::$view_paterno = $this->getPropertySystem('view.paterno');
        self::$view_materno = $this->getPropertySystem('view.materno');
        self::$view_telefono = $this->getPropertySystem('view.telefono');
        self::$view_otro_telefono = $this->getPropertySystem('view.otro.telefono');
        self::$view_mail = $this->getPropertySystem('view.mail');
        self::$view_calle = $this->getPropertySystem('view.calle');
        self::$view_noExt = $this->getPropertySystem('view.noExt');
        self::$view_noInt = $this->getPropertySystem('view.noInt');
        self::$view_idCp = $this->getPropertySystem('view.cp.id');
        self::$view_giro = $this->getPropertySystem('view.giro');
        self::$view_chkActivo = $this->getPropertySystem('view.chk.activo');
        self::$view_cboGiro = $this->getPropertySystem('view.cbo.giro');
        self::$view_vehiculo_id = $this->getPropertySystem('view.vehiculo.id');
        self::$view_cbo_clientes = $this->getPropertySystem('view.cbo.clientes');
        self::$view_imei = $this->getPropertySystem('view.imei');
        self::$view_cbo_gps = $this->getPropertySystem('view.cbo.gps');
        self::$view_modelo = $this->getPropertySystem('view.modelo');
        self::$view_marca = $this->getPropertySystem('view.marca');
        self::$view_placa = $this->getPropertySystem('view.placa');
        self::$view_color = $this->getPropertySystem('view.color');
        self::$view_dtp_verificacion = $this->getPropertySystem('view.dtp.verificacion');
        self::$view_icono_id = $this->getPropertySystem('view.id.icono');
        self::$view_licencia = $this->getPropertySystem('view.licencia');
        self::$view_vigencia = $this->getPropertySystem('view.vigencia');
        self::$view_cbo_licencia = $this->getPropertySystem('view.cbo.licencia');
        self::$view_cbo_vehiculo = $this->getPropertySystem('view.cbo.vehiculo');
        self::$view_idConductor = $this->getPropertySystem('view.id.conductor');
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
