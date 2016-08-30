<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Description of DtoLogin
 *
 * @author ShadowDarkCat
 */
class DtoLogin {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    public static $session;
    private $idUsuario;
    private $nombreUsuario;
    private $pwd;
    private $nombre;
    private $telefono;
    private $mail;
    private $activo;
    private $idCliente;
    private $menu;
    private $admin;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Accesores">
    public static function getSession() {
        return self::$session;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function setMenu($menu) {
        $this->menu = $menu;
    }

    public static function setSession($login) {
        self::$session = $_SESSION[PropertyKey::$session_usuario] = $login;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getIdCliente() {
        return $this->idCliente;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    //</editor-fold>
}
