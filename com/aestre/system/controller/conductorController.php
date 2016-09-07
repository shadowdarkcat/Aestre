<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST[PropertyKey::$view_method])) {
    $controller = new conductorController();
    $controller->conductores();
}

/**
 * Description of conductorController
 *
 * @author ShadowDarkCat
 */
class conductorController {

    private $session;
    private $method;
    private $conductorBo;

    public function __construct() {
        unset($_SESSION[PropertyKey::$session_conductores]);
        $this->conductorBo = new ConductorBoImpl();
        $this->session = $_SESSION[PropertyKey::$session_usuario];
        if (isset($_REQUEST[PropertyKey::$view_method])) {
            $this->method = $_REQUEST[PropertyKey::$view_method];
        }
        unset($_REQUEST[PropertyKey::$view_method]);        
    }

    public function conductores() {
        $conductor = FactoryConductor::newInstance(NULL);
        $colonia = FactoryColonia::newInstance(NUll);
        switch ($this->method) {
            case 0:
                $this->findAll(FALSE);
                break;
            case 1:
                $this->insert($conductor, $colonia);
                break;
            case 2:
                $this->update($conductor, $colonia);
                break;
            case 3:
                $this->delete($conductor, $colonia);
                break;
        }
    }

    public function findAll($exist) {
        $this->redirect($this->conductorBo->findAll($this->session), $exist);
    }

    private function insert(DtoConductor $dto, BeanCp $colonia) {
        $conductor = $this->getParametersFromRequest($dto, $colonia);
        $exist = $this->conductorBo->exist($this->session, $conductor);
        if (!$exist) {
            $this->conductorBo->insert($this->session, $conductor);
            $this->findAll(FALSE);
        } else {
            $this->findAll(TRUE);
        }
    }

    private function update(DtoConductor $cliente, BeanCp $colonia) {
        $this->conductorBo->update($this->session, $this->getParametersFromRequest($cliente, $colonia));
        $this->findAll(FALSE);
    }

    private function delete(DtoConductor $cliente, BeanCp $colonia) {
        $this->conductorBo->delete($this->session, $this->getParametersFromRequest($cliente, $colonia));
        $this->findAll(FALSE);
    }
    
    private function redirect($conductores, $exist) {
        if (!empty($conductores)) {
            $_SESSION[PropertyKey::$session_conductores] = serialize($conductores);
        }
        $_SESSION[PropertyKey::$session_exists] = serialize($exist);
        echo(PropertyKey::$php_main_conductor);
    }

    private function getParametersFromRequest(DtoConductor $conductor, BeanCp $colonia) {
        $conductor->setIdConductor(isset($_REQUEST[PropertyKey::$view_idConductor]) ? strtoupper($_REQUEST[PropertyKey::$view_idConductor]) : NULL );
        $conductor->setNombre(strtoupper($_REQUEST[PropertyKey::$view_nombre]));
        $conductor->setPaterno(strtoupper($_REQUEST[PropertyKey::$view_paterno]));
        $conductor->setMaterno(strtoupper($_REQUEST[PropertyKey::$view_materno]));
        $conductor->setTelefono($_REQUEST[PropertyKey::$view_telefono]);
        $conductor->setOtroTelefono(isset($_REQUEST[PropertyKey::$view_otro_telefono]) ? $_REQUEST[PropertyKey::$view_otro_telefono] : NULL);
        $conductor->setMail(strtolower($_REQUEST[PropertyKey::$view_mail]));
        $conductor->setCalle(strtoupper($_REQUEST[PropertyKey::$view_calle]));
        $conductor->setNoExterior(strtoupper($_REQUEST[PropertyKey::$view_noExt]));
        $conductor->setNoInterior(isset($_REQUEST[PropertyKey::$view_noInt]) ? strtoupper($_REQUEST[PropertyKey::$view_noInt]) : NULL);
        $conductor->setBeanCp(FactoryCp::newInstance($_REQUEST[PropertyKey::$view_idCp]));
        $conductor->setNoLicencia($_REQUEST[PropertyKey::$view_licencia]);
        $conductor->setVigencia($_REQUEST[PropertyKey::$view_vigencia]);
        $conductor->setBeanLicencia(FactoryLicencia::newInstance($_REQUEST[PropertyKey::$view_cbo_licencia]));
        $conductor->setActivo(isset($_REQUEST[PropertyKey::$view_chkActivo]) ? Utils::isIsset($_REQUEST[PropertyKey::$view_chkActivo]) : Utils::isIsset(NULL));        
        $conductor->setDtoVehiculo(FactoryVehiculo::newInstance($_REQUEST[PropertyKey::$view_cbo_vehiculo]));
        return $conductor;
    }

}
