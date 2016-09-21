<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of LocalizarDaoImpl
 *
 * @author ShadowDarkCat
 */
class LocalizarDaoImpl implements LocalizarDao {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $jdbc;
    private $res;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        new PropertyKey();
        $this->jdbc = new Jdbc();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAllById($obj) {
        $date = date("Y-m-d");
        $args = array($obj, $date);
        $query = Utils::replaceQuery(PropertyKey::$jdbc_view_localizar_imei_date, $args);
        $resultSet = $this->getResultSet($query);
        if (empty($resultSet)) {
            $args = array($obj);
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_localizar_imei, $args);
            $resultSet = $this->getResultSet($query);
        }
        $this->jdbc->closeFetchArray($this->res);
        $this->jdbc->closeConnection();
        return $resultSet;
    }

    public function findByDate($obj, $fi, $ff, $hi, $hf) {
        $date = date("Y-m-d");
        return $this->selectDateQuery($obj, $date, $fi, $ff, $hi, $hf);
    }

    private function selectDateQuery($obj, $date, $fi, $ff, $hi, $hf) {
        $args = NULL;
        if ((!empty($fi)) && (empty($ff)) && (empty($hi)) && (empty($hf))) {
            $args = array($obj, $fi, $date);
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_localizar_fecha_ini, $args);
            $resultSet = $this->getResultSet($query);
        } else if ((!empty($fi)) && (!empty($ff)) && (empty($hi)) && (empty($hf))) {
            $args = array($obj, DateTime::createFromFormat('d/m/Y',$fi)->format('Y/m/d'), DateTime::createFromFormat('d/m/Y',$ff)->format('Y/m/d'));
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_localizar_fecha_ini_fin, $args);
            $resultSet = $this->getResultSet($query);
        } else if ((!empty($fi)) && (!empty($ff)) && (!empty($hi)) && (empty($hf))) {
            $args = array($obj, date_format($fi, 'Y/m/d'), $hi, date_format($ff, 'Y/m/d'));
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_localizar_hora_ini, $args);
            $resultSet = $this->getResultSet($query);
        } else if ((!empty($fi)) && (!empty($ff)) && (!empty($hi)) && (!empty($hf))) {
            $args = array($obj, date_format($fi, 'Y/m/d'), $hi, date_format($ff, 'Y/m/d'), $hf);
            $query = Utils::replaceQuery(PropertyKey::$jdbc_view_localizar_hora_ini_fin, $args);
            $resultSet = $this->getResultSet($query);
        }
        $this->jdbc->closeFetchArray($this->res);
        $this->jdbc->closeConnection();
        return $resultSet;
    }

    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getResultSet($query) {
        $index = 0;
        $obj = [];
        $this->res = $this->jdbc->query($query);
        while (@$row = mysqli_fetch_array($this->res)) {
            $obj[$index] = SqlUtils::getFields(FactoryLocalizar::newInstance(NULL), $row);
            $index++;
        }
        return $obj;
    }

    //</editor-fold>
}
