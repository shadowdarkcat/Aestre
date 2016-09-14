<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of LoginDaoImpl
 *
 * @author ShadowDarkCat
 */
class LoginDaoImpl implements LoginDao {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $jdbc;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        new PropertyKey();
        $this->jdbc = new Jdbc();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function exist($obj) {
        $args = array($obj->getNombreUsuario(), $obj->getNombre());
        return $this->getResultSetFunction(Utils::replaceQuery(PropertyKey::$jdbc_function_exist_login, $args)) != 0;
    }

    public function findAll() {
        return $this->getResultSet(PropertyKey::$jdbc_view_usuario);
    }

    public function findById($obj) {
        $args = array($obj->getIdUsuario());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_usuario, $args));
    }

    public function validateLogin($obj) {
        $args = array($obj->getNombreUsuario(), $obj->getPwd());
        return $this->getResultSet(Utils::replaceQuery(PropertyKey::$jdbc_view_user, $args))[0];
    }

    public function insert($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_login, $this->getParameters(1, $obj)));
        return $this->getResultSetFunction(PropertyKey::$jdbc_function_last_login);
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">

    public function update($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_login, $this->getParameters(2, $obj)));
    }

    public function delete($obj) {
        SqlUtils::execute($this->jdbc, Utils::replaceQuery(PropertyKey::$jdbc_procedure_login, $this->getParameters(3, $obj)));
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getResultSet($query) {
        $index = 0;
        $object = [];
        $rs = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($rs)) {
            $object[$index] = SqlUtils::getFields(FactoryLogin::newInstance(NULL), $row);
            $index++;
        }
        SqlUtils::close($this->jdbc, $rs);
        return $object;
    }

    private function getResultSetFunction($query) {
        $object = NULL;
        $rs = $this->jdbc->query($query);
        while ($row = @mysqli_fetch_array($rs)) {
            $object = $row[0];
        }
        SqlUtils::close($this->jdbc, $rs);
        return $object;
    }

    private function getParameters($opcion, $obj) {
        return array($opcion,
            $obj->getIdUsuario(),
            $obj->getNombreUsuario(),
            $obj->getPwd(),
            $obj->getNombre(),
            $obj->getTelefono(),
            $obj->getMail(),
            $obj->getActivo(),
            $obj->getIdCliente(),
            $obj->getAdmin()
        );
    }

    //</editor-fold>
}
