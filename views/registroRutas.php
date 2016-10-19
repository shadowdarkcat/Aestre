<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!Utils::isSessionValid($_SESSION[PropertyKey::$session_usuario])) {
    echo(PropertyKey::$php_index);
}
$controller = new georutaController();
$controller->findAll(FALSE);
$ruta = [];
if (isset($_SESSION[PropertyKey::$session_ruta_json])) {
    $ruta = json_decode($_SESSION[PropertyKey::$session_ruta_json]);
}

$exist = '';
if (isset($_SESSION[PropertyKey::$session_exists])) {
    $exist = unserialize($_SESSION[PropertyKey::$session_exists]);
    unset($_SESSION[PropertyKey::$session_exists]);
}
?>
<script>
    var rutas = [];
</script>
<div id="divRutas" style="display: none;" class="col-lg-8">
    <h4 style="text-align: center">GEORUTAS</h4>
    <div class="table">                            
        <table id="tblGeorutas" class="table table-striped table-bordered dt-responsive nowrap" data-role="datatable" cellspacing="0" width="100%" data-info="false">
            <thead>
                <tr>                                        
                    <th style="text-align: center"><label class="font-size">Nombre</label></th>
                    <th style="text-align: center"><label class="font-size">Editar</label></th>
                    <th style="text-align: center"><label class="font-size">Eliminar</label></th>
                    <th style="text-align: center"><label class="font-size">Asociar Veh&iacute;culo-Georuta</label></th>
                    <th style="text-align: center; display: none;"><label class="font-size">Ruta</label></th>
                    <th style="text-align: center; display: none;"><label class="font-size">Json Ruta</label></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                ?><script> var size = <?php echo(count($ruta)); ?>;</script>
                <?php
                foreach ($ruta as $item) {
                    setDataRuta($item);
                    echo ('<tr id="trMapIndx' . $index . '">'
                    . '<td  style="text-align: center">'
                    . '<label class="font-size">'
                    . $item->nombre
                    . '<td  style="text-align: center">'
                    . '<button type="button" class="btn"'
                    . 'onclick="showDataRuta(' . $index . ',0);">'
                    . '<img src="../web/images/modificar.png" height="23px" width="29px;"></button>'
                    . '</td>'
                    . '<td  style="text-align: center">'
                    . '<button type="button" class="btn"'
                    . 'onclick="showDataRuta(' . $index . ',1);">'
                    . '<img src="../web/images/habilitar.png" height="29px" width="23px;"></button>'
                    . '</td>'
                    . '<td  style="text-align: center">'
                    . '<button type="button" class="btn"'
                    . 'onclick="showDataRuta(' . $index . ',2);">'
                    . '<img src="../web/images/vehiculoMapa.png" height="32px" width="32px;"></button>'
                    . '</td>'
                    . '<td  style="text-align: center; display:none;">'
                    . '<label class="font-size" id="lblId">' . $item->id
                    . '</label></td>'
                    . '<td  style="text-align: center; display:none;">'
                    . '<label class="font-size" id="lblJson">' . $item->ruta
                    . '</label></td>'
                    . '</tr>');
                    $index++;
                }
                ?> 
            </tbody>
            <tfoot id="foot"></tfoot>
        </table>
    </div>
</div>
<div id="divMessageSuccessRuta" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-success">Registro Exitoso</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td><span class="text-muted text-info">La ruta fue registrada, se a&ntilde;adieron
                                <label id="lblTotalGr"></label> veh&iacute;culos
                            </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageSuccessModificarRuta" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-info"> Ruta Modificada </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> La ruta fue modificada </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearZona();"> Aceptar </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageEliminarRuta" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-warning"> Eliminar GeoRuta </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> La ruta ser&aacute; eliminada, todos los veh&iacute;culos 
                                asociados dejaran de pertenecer a la ruta<br/>Desea continuar ?</span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnDeleteGeoruta" name="btnDeleteGeoruta"> Aceptar </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageSuccessEliminarRuta" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-info"> Ruta Eliminada </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> La ruta fue eliminada </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearRuta();"> Aceptar </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageAsociarRuta" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-warning"> Asociar veh&iacute;culo - Georuta </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> Se asociaran los vehiculos seleccionados a la ruta
                                <br/>Desea continuar? </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnAceptarAsociarRuta" name="btnAceptarAsociarRuta"> Asociar </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

function setDataRuta($item) {
    $json = json_encode(array('id' => $item->id, 'nombre' => $item->nombre, 'coordenadas' => $item->ruta, 'lenght' => $item->lenght));
    ?>
    <script>
        rutas.push(
    <?php
    echo($json);
    ?>
        );
    </script>
    <?php
}

if ($exist) {
    echo('<script>$("#divExiste").modal("show");</script>');
}
  