<?php

/**
 * Description of JsonUtils
 *
 * @author ShadowDarkCat
 */
class JsonUtils {

    //<editor-fold defaultstate="collapsed" desc="Metodos Privados">
    public static final function createJson($obj) {
        if (!Utils::isReallyEmptyOrNull($obj)) {
            if ($obj[0] instanceof DtoCliente) {
                return self::getJsonCliente($obj);
            } else if ($obj[0] instanceof DtoVehiculo) {
                return self::getJsonVehiculo($obj);
            } else if ($obj[0] instanceof DtoConductor) {
                return self::getJsonConductor($obj);
            } else if ($obj[0] instanceof BeanGeozona) {
                return self::getJsonZona($obj);
            } else if ($obj[0] instanceof BeanGeoruta) {
                return self::getJsonRuta($obj);
            }
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

    private static final function getJsonConductor(DtoVehiculo $dto) {
        $json = array();
        foreach ($obj as $val) {
            $json[] = array(
                'id' => $val->getId(), 'nombre' => $val->getNombre()
                , 'paterno' => $val->getPaterno(), 'materno' => $val->getMaterno()
                , 'tel' => $val->getTelefono()
                , 'otroTel' => $val->getOtroTelefono()
                , 'mail' => $val->getMail()
                , 'calle' => $val->getCalle(), 'exterior' => $val->getNoExterior()
                , 'interior' => ($val->getNoInterior() == 'NULL' ? 'S/N' : $val->getNoInterior())
                , 'cp' => $this->getColoniaJson($val)
                , 'noLicencia' => $val->getNoLicencia(), 'vigencia' => $val->getVigencia()
                , 'beanLicencia' => $this->getLicencia($val)
                , 'activo' => $val->getActivo()
                , 'dtoVehiculo' => $this->getVehiculoJson($val)
            );
        }
        return $json;
    }

    private final function getVehiculoJson($val) {
        return array(
            'id' => $val->getDtoVehiculo()->getId(), 'modelo' => $val->getDtoVehiculo()->getModelo()
            , 'marca' => $val->getDtoVehiculo()->getMarca(), 'placa' => $val->getDtoVehiculo()->getPlaca()
            , 'uso' => array(
                'idUso' => $val->getDtoVehiculo()->getBeanUso()->getId(), 'uso' => $val->getDtoVehiculo()->getBeanUso()->getUso()
            )
            , 'color' => $val->getDtoVehiculo()->getColor(), 'veri' => $val->getDtoVehiculo()->getVerificacion(), 'imei' => $val->getDtoVehiculo()->getImei()
            , 'celular' => $val->getDtoVehiculo()->getCelular(), 'apagado' => $val->getDtoVehiculo()->getApagado()
            , 'dispositivo' => array(
                'id' => $val->getDtoVehiculo()->getBeanDispositivo()->getId(), 'dispositivo' => $val->getDtoVehiculo()->getBeanDispositivo()->getDispositivo()
            )
            , 'idZona' => $val->getDtoVehiculo()->getIdZona(), 'idRuta' => $val->getDtoVehiculo()->getIdRuta()
            , 'icons' => array(
                'id' => $val->getDtoVehiculo()->getBeanIcon()->getId(), 'path' => $val->getDtoVehiculo()->getBeanIcon()->getPath()
            )
        );
    }

    private final function getColoniaJson($val) {
        return array(
            'id' => $val->getId()
            , 'idCp' => $val->getBeanCp()->getIdCp(), 'cp' => $val->getBeanCp()->getCp()
            , 'col' => $val->getBeanCp()->getCol()
            , 'dele' => (empty($val->getBeanCp()->getDelegacion()) ? 'NULL' : $val->getBeanCp()->getDelegacion())
            , 'muni' => (empty($val->getBeanCp()->getMunicipio()) ? 'NULL' : $val->getBeanCp()->getMunicipio())
            , 'estado' => $val->getBeanCp()->getEstado()
            , 'ciudad' => (empty($val->getBeanCp()->getCiudad()) ? 'NA' : $val->getBeanCp()->getCiudad())
        );
    }

    private final function getLicencia($val) {
        return array(
            'id' => $val->getBeanLicencia()->getIdLicencia()
            , 'tipo' => $val->getBeanLicencia()->getLicencia()
        );
    }

    private static final function getJsonZona(BeanGeozona $obj) {
        foreach ($obj as $item) {
            $json[] = array(
                'id' => $item->getId(), 'nombre' => $item->getNombre()
                , 'zona' => $item->getJson()
            );
        }
        return $json;
    }

    private static final function getJsonRuta($obj) {
        foreach ($obj as $item) {
            $json[] = array(
                'id' => $item->getId(), 'nombre' => $item->getNombre(), 'ruta' => $item->getJson()
                , 'lenght' => $item->getLenght()
            );
        }
        return $json;
    }

}
