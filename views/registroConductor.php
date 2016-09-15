<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/principalAdmin.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!Utils::isSessionValid($_SESSION[PropertyKey::$session_usuario])) {
    echo(PropertyKey::$php_index);
}
$exist = '';
$conductores = [];
if (isset($_SESSION[PropertyKey::$session_conductores])) {
    $conductores = unserialize($_SESSION[PropertyKey::$session_conductores]);
}
$controllerL = new licenciaController();
$controllerL->licencias();
if (isset($_SESSION[PropertyKey::$session_licencias])) {
    $licencias = unserialize($_SESSION[PropertyKey::$session_licencias]);
}
$controllerV = new vehiculoController();
$controllerV->findAllToConductor();
if (isset($_SESSION[PropertyKey::$session_vehiculos])) {
    $vehiculos = unserialize($_SESSION[PropertyKey::$session_vehiculos]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <script type="text/javascript" src="../web/js/conductores.js"></script>
        <script type="text/javascript" src="../web/forms/formConductor.js"></script>
        <script>
            var conductores = [];
        </script>
        <title>Nuevo Conductor</title>
    </head>
    <body>
        <?php
        $optionL = '<option value=""></option>';
        foreach ($licencias as $item) {
            $optionL.='<option value=' . $item->getIdLicencia() . '>' . $item->getLicencia() . '</option>';
        }
        $optionV = '<option value=""></option>';
        foreach ($vehiculos->getClientes() as $item) {
            foreach ($item->getVehiculos() as $items) {
                $optionV.='<option value="' . $items->getIdVehiculo() . '">' . $items->getModelo() . ' '
                        . $items->getPlaca() . '</option>';
            }
        }
        ?>
        <script>
            var cboLicencia = '<?php echo($optionL); ?>';
            var cboVehiculo = '<?php echo($optionV); ?>';
        </script>
        <br/><br/><br/><br/><br/>
        <div class="container-fluid" style="background: white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                        <h4 style="text-align: center;" >CONDUCTORES</h4>
                        <div class="table">
                            <table id="tblConductores" class="table table-striped table-bordered dt-responsive nowrap" data-role="datatable" cellspacing="0" width="100%" data-info="false">
                                <thead>
                                    <tr>                                        
                                        <th style="text-align: center;"><label class="font-size">Nombre Completo</label></th>
                                        <th style="text-align: center;"><label class="font-size">Veh&iacute;culo</label></th>
                                        <th style="text-align: center;"><label class="font-size">Activo</label></th>
                                        <th style="text-align: center;"><label class="font-size">Editar</label></th>
                                        <th style="text-align: center;"><label class="font-size">Habilitar/Inhabilitar</label></th>
                                        <th style="text-align: center; display: none;"><label class="font-size"># Conductor</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    ?><script> var size =<?php echo(count($conductores)); ?>;</script>
                                    <?php
                                    foreach ($conductores as $item) {
                                        setData($item);
                                        echo ('<tr id="trIndx' . $index . '">'
                                        . '<td style="text-align: center;">'
                                        . $item->getNombre() . ' ' . $item->getPaterno() . ' ' . $item->getMaterno()
                                        . '</td>'
                                        . '<td style="text-align: center;">'
                                        . $item->getDtoVehiculo()->getMarca() . ' ' . $item->getDtoVehiculo()->getModelo() . ' ' . $item->getDtoVehiculo()->getPlaca()
                                        . '</td>'
                                        . '<td  style="text-align: center;">'
                                        . '<label class="font-size">'
                                        . (($item->getActivo() == TRUE) ? 'Sí' : 'NO')
                                        . '</label></td>'
                                        . '<td  style="text-align: center;">'
                                        . '<button type="button" class="btn" '
                                        . 'onclick="showData(' . $index . ',0);">'
                                        . '<img src="../web/images/modificar.png" height="23px" width="29px;"></button>'
                                        . '</td>'
                                        . '<td  style="text-align: center;">'
                                        . '<button type="button" class="btn"'
                                        . 'onclick="showData(' . $index . ',1);">'
                                        . '<img src="../web/images/habilitar.png" height="29px" width="23px;"></button>'
                                        . '</td>'
                                        . '<td style="text-align: center; display: none;">'
                                        . $item->getIdConductor()
                                        . '</td>'
                                        . '</tr>');
                                    }
                                    ?>
                                </tbody>
                                <tfoot id="foot"></tfoot>
                            </table>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </body>
</html>
<?php

function setData(DtoConductor $item) {
    ?>
    <script>
        conductores.push(
    <?php
    echo('\'' . $item->getIdConductor() . ',' . $item->getNombre()
    . ',' . $item->getPaterno() . ',' . $item->getMaterno()
    . ',' . $item->getTelefono() . ',' . $item->getOtroTelefono() . ',' . $item->getMail()
    . ',' . $item->getCalle() . ',' . $item->getNoExterior()
    . ',' . $item->getNoInterior() . ',' . $item->getBeanCp()->getIdCp()
    . ',' . $item->getBeanCp()->getCol() . ',' . $item->getBeanCp()->getCp()
    . ',' . $item->getBeanCp()->getDelegacion() . ',' . $item->getBeanCp()->getMunicipio()
    . ',' . $item->getBeanCp()->getEstado() . ',' . $item->getBeanCp()->getCiudad()
    . ',' . $item->getNoLicencia() . ',' . $item->getVigencia()
    . ',' . $item->getBeanLicencia()->getIdLicencia()
    . ',' . $item->getDtoVehiculo()->getIdVehiculo()
    . ',' . $item->getActivo() . '\'');
    ?>);
    </script>
    <?php
}

if ($exist) {
    echo('<script>$("#divExiste").modal("show");</script>');
}
?>