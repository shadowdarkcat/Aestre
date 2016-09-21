<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);

/**
 * Description of LocalizarBoImpl
 *
 * @author ShadowDarkCat
 */
class LocalizarBoImpl implements LocalizarBo {

    //<editor-fold defaultstate="collapsed" desc="Campos de Clase">
    private $dao;
    private $clienteVehiculoBo;
    private $conductorBo;
    private $geozonaBo;
    private $georutaBo;
    private $dispositivoBo;

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Constructores">
    public function __construct() {
        $this->dao = new LocalizarDaoImpl();
        $this->clienteVehiculoBo = new ClienteVehiculoBoImpl();
        $this->conductorBo = new ConductorBoImpl();
        $this->dispositivoBo = new DispositivoBoImpl();
        $this->geozonaBo = new GeozonaBoImpl();
        $this->georutaBo = new GeorutaBoImpl();
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones P&uacute;blicas">
    public function findAllById($user, $object) {
        if (Utils::isSessionValid($user)) {
            foreach ($object->getVehiculos() as $item) {
                $localizar = $this->dao->findAllById($item->getImei());
                if (!empty($localizar)) {
                    $item->setBeanLocalizar($localizar);
                    $item->setDtoConductor($this->getConductor($item, $user));
                    if (!is_null($item->getBeanGeozona()->getId())) {
                        $item->setBeanGeozona($this->getGeozona($item->getBeanGeozona(), $user));
                    } else {
                        $item->setBeanGeozona(FactoryGeozona::newInstance(NULL));
                    }
                    if (!is_null($item->getBeanGeoruta()->getId())) {
                        $item->setBeanGeoruta($this->getGeoruta($item->getBeanGeoruta(), $user));
                    } else {
                        $item->setBeanGeoruta(FactoryGeoruta::newInstance(NULL));
                    }
                }
            }
            return $this->createJson($object);
        }
    }

    public function findByDate($user, $obj, $fi, $ff, $hi, $hf) {
        foreach ($obj->getVehiculos() as $item) {
            $localizar = $this->dao->findByDate($item->getImei(), $fi, $ff, $hi, $hf);
            if (!empty($localizar)) {
                $item->setBeanLocalizar($localizar);
                $item->setDtoConductor($this->getConductor($item, $user));
                if (!is_null($item->getBeanGeozona()->getId())) {
                    $item->setBeanGeozona($this->getGeozona($item->getBeanGeozona(), $user));
                } else {
                    $item->setBeanGeozona(new BeanGeozona());
                }
                if (!is_null($item->getBeanGeoruta()->getId())) {
                    $item->setBeanGeoruta($this->getGeoruta($item->getBeanGeoruta(), $user));
                } else {
                    $item->setBeanGeoruta(new BeanGeoruta());
                }
                if ($item->getBeanDispositivo()->getIdDispositivo() == 2) {
                    foreach ($item->getBeanLocalizar() as $val) {
                        $array = json_decode($val->getJson());
                        $evt = $this->dispositivoBo->findEventById(
                                $array->event, $item->getBeanDispositivo()->getDispositivo(), $user);
                        $val->setEvento($evt);
                        $val->setOdometro($array->odometer);
                    }
                }
            } else {
                $json[] = array();
                return NULL;
            }
        }
        return $this->createJson($obj);
    }

    //</editor-fold>
    //<editor-fold defaultstate="collapsed" desc="Funciones Privadas">
    private function getConductor(DtoVehiculo $object, DtoLogin $user) {
        $beanClienteVehiculo = FactoryClienteVehiculo::newInstance(NULL);
        $dtoConductor = FactoryConductor::newInstance(NULL);
        $beanClienteVehiculo->setIdVehiculo($object->getIdVehiculo());
        $id = $this->clienteVehiculoBo->findById($beanClienteVehiculo, $user)[0]->getIdConductor();
        if (!empty($id)) {
            $dtoConductor->setId($id);
            return $this->conductorBo->find($user, $dtoConductor)[0];
        }
    }

    private function getGeozona(BeanGeozona $object, DtoLogin $user) {
        return $this->geozonaBo->find($user, $object)[0];
    }

    private function getGeoruta(BeanGeoruta $object, DtoLogin $user) {
        return $this->georutaBo->find($user, $object)[0];
    }

    private function createJson(DtoCliente $val) {
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
            , 'conductor' => $this->getJsonConductor($val->getVehiculos())
        );
        return $json;
    }

    private function getJsonConductor($object) {
        $index = 0;
        foreach ($object as $val) {
            if (!empty($val->getDtoConductor())) {
                $json[] = array(
                    'id' => $val->getDtoConductor()->getId(), 'nombre' => $val->getDtoConductor()->getNombre()
                    , 'paterno' => $val->getDtoConductor()->getApellidoPaterno()
                    , 'materno' => $val->getDtoConductor()->getApellidoMaterno()
                    , 'idCp' => $val->getDtoConductor()->getBeanCp()->getIdCp(), 'cp' => $val->getDtoConductor()->getBeanCp()->getCp()
                    , 'col' => $val->getDtoConductor()->getBeanCp()->getCol()
                    , 'dele' => (empty($val->getDtoConductor()->getBeanCp()->getDelegacion()) ? 'NULL' : $val->getDtoConductor()->getBeanCp()->getDelegacion())
                    , 'muni' => (empty($val->getDtoConductor()->getBeanCp()->getMunicipio()) ? 'NULL' : $val->getDtoConductor()->getBeanCp()->getMunicipio())
                    , 'estado' => $val->getDtoConductor()->getBeanCp()->getEstado()
                    , 'ciudad' => (empty($val->getDtoConductor()->getBeanCp()->getCiudad()) ? 'NA' : $val->getDtoConductor()->getBeanCp()->getCiudad())
                    , 'cel' => $val->getDtoConductor()->getNoTelefono()
                    , 'noLicencia' => $val->getDtoConductor()->getNoLicencia()
                    , 'vigencia' => $val->getDtoConductor()->getVigencia()
                    , 'tipoLicencia' => $val->getDtoConductor()->getBeanLicencias()->getTipo()
                    , 'vehiculo' => $this->getJsonVehiculos($object[$index])
                );
            } else {
                $json[] = array('vehiculo' => $this->getJsonVehiculos($object[$index]));
            }
            $index++;
        }
        return $json;
    }

    private function getJsonVehiculos($val) {
        $json[] = array(
            'id' => $val->getIdVehiculo(), 'modelo' => $val->getModelo()
            , 'marca' => $val->getMarca(), 'placa' => $val->getPlaca()
            , 'uso' => array(
                'idUso' => $val->getBeanGiro()->getIdGiro(), 'uso' => $val->getBeanGiro()->getGiro()
            )
            , 'color' => (empty($val->getColor())) ? 'no especificado' : $val->getColor(), 'veri' => $val->getVerificacion(), 'imei' => $val->getImei()
            , 'celular' => $val->getSim(), 'apagado' => $val->getApagado()
            , 'dispositivo' => array(
                'id' => $val->getBeanDispositivo()->getIdDispositivo(), 'dispositivo' => $val->getBeanDispositivo()->getDispositivo()
            )
            , 'zona' => (empty($val->getBeanGeozona()->getId())) ? new BeanGeozona() : $this->getJsonZona($val->getBeanGeozona())
            , 'ruta' => (empty($val->getBeanGeoruta()->getId())) ? new BeanGeoruta() : $this->getJsonRuta($val->getBeanGeoruta())
            , 'icons' => array(
                'id' => $val->getBeanIconos()->getIdIcono(), 'path' => $val->getBeanIconos()->getPathIcono()
            )
            , 'localizar' => (count($val->getBeanLocalizar()) < 2) ? $this->getCoordenadas($val->getBeanLocalizar()) : $this->getMultiplyCoordenadas($val->getBeanLocalizar())
            , 'activo' => ($val->getActivo() == 1) ? 'si' : 'no'
        );
        return $json;
    }

    private function getCoordenadas($object) {
        foreach ($object as $val) {
            $speed = ($val->getSpeed() * 1.852);
            $json[] = array(
                'id' => $val->getId(), 'imei' => $val->getImei(), 'lat' => $val->getLat()
                , 'lon' => $val->getLon(), 'dt' => $val->getDateTime()
                , 'addres' => (empty($val->getAddress()) ? 'Ubicaci&oacute;n no disponible' : $val->getAddress())
                , 'speed' => $speed, 'json' => $val->getJson(), 'evento' => (empty($val->getEvento()) ? 'NA' : $val->getEvento())
                , 'odometro' => (empty($val->getOdometro()) ? 'NA' : $val->getOdometro())
            );
        }
        return $json;
    }

    private function getMultiplyCoordenadas($object) {
        foreach ($object as $val) {
            $speed = ($val->getSpeed() * 1.852);
            $json[] = array(
                'id' => $val->getId(), 'imei' => $val->getImei(), 'lat' => $val->getLat()
                , 'lon' => $val->getLon(), 'dt' => $val->getDateTime()
                , 'addres' => (empty($val->getAddress()) ? 'Ubicaci&oacute;n no disponible' : $val->getAddress())
                , 'speed' => $speed, 'json' => $val->getJson(), 'evento' => (empty($val->getEvento()) ? 'NA' : $val->getEvento())
                , 'odometro' => (empty($val->getOdometro()) ? 'NA' : $val->getOdometro())
            );
        }
        return $json;
    }

    private function getJsonZona($object) {
        $json[] = array(
            'id' => $object->getId(), 'zona' => $object->getNombre(), 'coordenadas' => $object->getJson()
        );
        return $json;
    }

    private function getJsonRuta($object) {
        $json[] = array(
            'id' => $object->getId(), 'ruta' => $object->getNombre(), 'coordenadas' => $object->getJson()
            , 'lenght' => $object->getLenght()
        );
        return $json;
    }

    //</editor-fold>
}
