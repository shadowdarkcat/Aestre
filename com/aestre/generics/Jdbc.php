<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();

/**
 * Clase encargada de la comunicaci&oacute;n con la base de datos
 *
 * @author ShadowDarkCat
 */
class Jdbc {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $connection;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores de Clase">
    /**
     * Constructor por omisi&oacute;n que realizara una nueva instancia de conexi&oacute;n a la base de datos
     */
    private function getConnection() {
        $this->connection = new mysqli(
                PropertyKey::$jdbc_server
                , PropertyKey::$jdbc_user
                , PropertyKey::$jdbc_password
                , PropertyKey::$jdbc_data_base
                , PropertyKey::$jdbc_port
        );
        $this->connection->set_charset(PropertyKey::$jdbc_charset);
        return $this->connection;
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    /**
     * Funci&oacute;n que devuelve las filas obtenidas de una consulta del tipo select
     * @param $query String Contiene la sentencia sql a ejecutar
     * @return $row ResultSet Devuelve un resultSet con las filas de la consulta
     */
    public function query($query) {
        return mysqli_query($this->getConnection(), $query);
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    /**
     * M&eacute;todo que ejecuta una instrucci&oacute;n en la base de datos
     * @param $query String Contiene las sentencias del tipo insert, update o delete a ejecutar
     */
    public function execute($query) {
        mysqli_query($this->getConnection(), $query);
    }

    /**
     * M&eacute;todo que cierra la conexi&oacute;n con la base de datos
     */
    public function closeConnection() {
        mysqli_close($this->connection);
    }

    /**
     * M&eacute;todo que libera los recursos utilizados por el resultSet de una consulta del tipo select
     */
    public function closeFetchArray($resultSet) {
        mysqli_free_result($resultSet);
    }

    //</editor-fold>
}
