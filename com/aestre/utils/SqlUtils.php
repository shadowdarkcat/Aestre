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
        } else if ($obj instanceof BeanCp) {
            return self::getColonia($obj, $row);
        } else if ($obj instanceof BeanDispositivo) {
            return self::getDispositivo($obj, $row);
            /*  }else if($obj instanceof BeanZona){
              return self::getZona($obj, $row); */
        } else if ($obj instanceof DtoCliente) {
            return self::getCliente($obj, $row);
        } else if ($obj instanceof BeanGiro) {
            return self::getGiro($obj, $row);
        } else if ($obj instanceof BeanIconos) {
            return self::getIconos($obj, $row);
        } else if ($obj instanceof DtoVehiculo) {
            return self::getVehiculos($obj, $row);
        }else if($obj instanceof BeanClienteVehiculo){
            return self::getClienteVehiculo($obj,$row);
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

    private static final function getColonia(BeanCp $bean, $row) {
        $bean->setIdCp($row[0]);
        $bean->setCp($row[1]);
        $bean->setCol($row[2]);
        $bean->setDelegacion($row[3]);
        $bean->setMunicipio($row[4]);
        $bean->setEstado($row[5]);
        $bean->setCiudad($row[6]);
        return $bean;
    }

    private static final function getDispositivo(BeanDispositivo $bean, $row) {
        $bean->setIdDispositivo($row[0]);
        $bean->setDispositivo($row[1]);
        return $bean;
    }

    /*  private static final function getZona(BeanDispositivo $bean, $row) {
      $bean->setId($row[0]);
      $bean->setNombre($row[1]);
      $bean->setJson($row[2]);
      return $bean;
      } */

    private static final function getCliente(DtoCliente $dto, $row) {
        $dto->setIdCliente($row[0]);
        $dto->setNombre($row[1]);
        $dto->setPaterno($row[2]);
        $dto->setMaterno($row[3]);
        $dto->setCalle($row[4]);
        $dto->setBeanCp(FactoryColonia::newInstance($row[5]));
        $dto->setNoExterior($row[6]);
        $dto->setNoInterior($row[7]);
        $dto->setTelefono($row[8]);
        $dto->setOtroTelefono($row[9]);
        $dto->setMail($row[10]);
        $dto->setGiro($row[11]);
        $dto->setActivo($row[12]);
        $dto->setRefresh($row[13]);
        return $dto;
    }

    private static final function getGiro(BeanGiro $bean, $row) {
        $bean->setIdGiro($row[0]);
        $bean->setGiro($row[1]);
        return $bean;
    }

    private static final function getIconos(BeanIconos $bean, $row) {
        $bean->setIdIcono($row[0]);
        $bean->setPathIcono($row[1]);
        return $bean;
    }

    private static final function getVehiculos(DtoVehiculo $dto, $row) {
        $dto->setIdVehiculo($row[0]);
        $dto->setModelo($row[1]);
        $dto->setMarca($row[2]);
        $dto->setPlaca($row[3]);
        $dto->setColor($row[4]);
        $dto->setBeanGiro(FactoryGiro::newInstance($row[5]));
        $dto->setImei($row[6]);
        $dto->setSim($row[7]);
        $dto->setActivo($row[8]);
        $dto->setApagado($row[9]);
        $dto->setBeanDispositivo(FactoryDispositivo::newInstance($row[10]));
        $dto->setBeanZona(NULL);//FactoryZona::newInstance($row[11]));
        $dto->setBeanRuta(NULL); //FactoryRuta::newInstance($row[12]));
        $dto->setBeanIconos(FactoryIconos::newInstance($row[13]));
        $dto->setVerificacion($row[14]);
        return $dto;
    }
    
    private static final function getClienteVehiculo(BeanClienteVehiculo $bean, $row) {
        $bean->setId($row[0]);
        $bean->setIdCliente($row[1]);
        $bean->setIdVehiculo($row[2]);
        $bean->setIdConductor($row[3]);
        $bean->setExitZone($row[4]);
        $bean->setEnterZone($row[5]);
        $bean->setExitRuta($row[6]);
        $bean->setEnterRuta($row[7]);
        return $bean;
    }
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
