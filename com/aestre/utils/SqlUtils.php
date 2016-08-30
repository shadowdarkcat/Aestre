<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of SqlUtils
 *
 * @author ShadowDarkCat
 */
class SqlUtils {

    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public static final function getFields($obj, $row) {
        if ($obj instanceof DtoLogin) {
            return self::getLogin($obj, $row);
        } else if ($obj instanceof BeanMenu) {
            return self::getMenu($obj, $row);
       /* } else if ($obj instanceof BeanColonia) {
            return self::getColonia($obj, $row);
        } else if ($obj instanceof BeanDispositivo) {
            return self::getDispositivo($obj, $row);
        }else if($obj instanceof BeanZona){
            return self::getZona($obj, $row);*/
        }
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private static function getLogin(DtoLogin $dto, $row) {
        $dto->setIdUsuario($row[0]);
        $dto->setNombreUsuario($row[1]);
        $dto->setPwd($row[2]);
        $dto->setNombre($row[3]);
        $dto->setTelefono($row[4]);
        $dto->setMail($row[5]);
        $dto->setActivo($row[6]);
        $dto->setIdCliente($row[7]);
        $dto->setAdmin($row[8]);
        return $dto;
    }

    private static final function getMenu(BeanMenu $bean, $row) {
        $bean->setId($row[0]);
        $bean->setLeyenda($row[2]);
        $bean->setLink($row[3]);
        $bean->setImage($row[4]);
        $bean->setToolTip($row[5]);
        $bean->setTarget($row[6]);
        return $bean;
    }

   /* private static final function getColonia(BeanColonia $bean, $row) {
        $bean->setIdCp($row[0]);
        $bean->setCp($row[1]);
        $bean->setCol(utf8_encode($row[2]));
        $bean->setDelegacion(utf8_encode($row[3]));
        $bean->setMunicipio(utf8_encode($row[4]));
        $bean->setEstado(utf8_encode($row[5]));
        $bean->setCiudad(utf8_encode($row[6]));
        return $bean;
    }

    private static final function getDispositivo(BeanDispositivo $bean, $row) {
        $bean->setId($row[0]);
        $bean->setDispositivo($row[1]);
        return $bean;
    }
    
    private static final function getZona(BeanDispositivo $bean, $row) {
        $bean->setId($row[0]);
        $bean->setNombre($row[1]);
        $bean->setJson($row[2]);
        return $bean;
    }*/
    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Metodos P&uacute;blicos">
    public static final function execute(Jdbc $connection, $query) {
        $connection->execute($query);
        $connection->closeConnection();
    }

    public static final function close(Jdbc $connection, $rs) {
        $connection->closeFetchArray($rs);
        $connection->closeConnection();
    }

    //</editor-fold>
}
