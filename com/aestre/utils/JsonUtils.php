<?php

/**
 * Description of JsonUtils
 *
 * @author ShadowDarkCat
 */
class JsonUtils {

    //<editor-fold defaultstate="collapsed" desc="Metodos Privados">
    public static final function createJson($obj) {
        if ($obj[0] instanceof DtoCliente) {
            return self::getJsonCliente($obj);
        } else if ($obj[0] instanceof DtoVehiculo) {
            return self::getJsonVehiculo($obj);
        }
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private static final function getJsonCliente(DtoCliente $dto) {
        $json = array();
        foreach ($dto as $val) {
            $json[] = array(
                'id' => $val->getIdCliente(), 'nombre' => $val->getNombre()
                , 'paterno' => $val->getPaterno(), 'materno' => $val->getMaterno()
                , 'calle' => $val->getCalle(), 'exterior' => $val->getNoExterior()
                , 'interior' => ($val->getNoInterior() == 'NULL' ? 'S/N' : $val->getNoInterior())
                , 'idCp' => $val->getBeanCp()->getIdCp(), 'cp' => $val->getBeanCp()->getCp()
                , 'col' => $val->getBeanCp()->getCol()
                , 'dele' => (empty($val->getBeanCp()->getDelegacion()) ? 'NULL' : $val->getBeanCp()->getDelegacion())
                , 'muni' => (empty($val->getBeanCp()->getMunicipio()) ? 'NULL' : $val->getBeanCp()->getMunicipio())
                , 'estado' => $val->getBeanCp()->getEstado()
                , 'ciudad' => (empty($val->getBeanCp()->getCiudad()) ? 'NA' : $val->getBeanCp()->getCiudad())
                , 'casa' => $val->getTelefono()
                , 'otro' => (empty($val->getOtroTelefono()) ? 'NA' : $val->getOtroTelefono())
                , 'mail' => $val->getMail(), 'giro' => (empty($val->getGiro()) ? 'NA' : $val->getGiro())
            );
        }
        return $json;
    }

    private static final function getJsonVehiculo(DtoVehiculo $dto) {
        $json = array();
        foreach ($dto as $val) {
            $json[] = array(
                'id' => $val->getIdVehiculo(), 'modelo' => $val->getModelo()
                , 'marca' => $val->getMarca(), 'placa' => $val->getPlaca()
                , 'uso' => array(
                    'idUso' => $val->getBeanGiro()->getIdGiro(), 'uso' => $val->getBeanGiro()->getGiro()
                )
                , 'color' => $val->getColor(), 'veri' => $val->getVerificacion(), 'imei' => $val->getImei()
                , 'celular' => $val->getSim(), 'apagado' => $val->getApagado()
                , 'dispositivo' => array(
                    'id' => $val->getBeanDispositivo()->getIdDispositivo(), 'dispositivo' => $val->getBeanDispositivo()->getDispositivo()
                )
               // , 'idZona' => $val->getBeanZona()->getId(), 'idRuta' => $val->getBeanRuta()->getId()
                , 'icons' => array(
                    'id' => $val->getBeanIconos()->getIdIcono(), 'path' => $val->getBeanIconos()->getPathIcono()
                )
            );
        }
        return $json;
    }
    //</editor-fold>
}
