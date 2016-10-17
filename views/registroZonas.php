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
$controller = new geozonaController();
$controller->findAll(FALSE);
$zona = [];
if (isset($_SESSION[PropertyKey::$session_zona_json])) {
    $zona = json_decode($_SESSION[PropertyKey::$session_zona_json]);
}

/* $clientes = [];
  if (isset($_SESSION[PropertyKey::$session_clientes])) {
  $clientes = unserialize($_SESSION[PropertyKey::$session_clientes]);
  } */
$exist = '';
if (isset($_SESSION[PropertyKey::$session_exists])) {
    $exist = unserialize($_SESSION[PropertyKey::$session_exists]);
    unset($_SESSION[PropertyKey::$session_exists]);
}
?>
<script>
    var zonas = [];
</script>
<div id="divZonas" style="display: none;" class="col-lg-8">
    <h4 style="text-align: center">GEOZONAS</h4>
    <div class="table">                            
        <table id="tblGeozonas" class="table table-striped table-bordered dt-responsive nowrap" data-role="datatable" cellspacing="0" width="100%" data-info="false">
            <thead>
                <tr>                                        
                    <th style="text-align: center"><label class="font-size">Nombre</label></th>
                    <th style="text-align: center"><label class="font-size">Editar</label></th>
                    <th style="text-align: center"><label class="font-size">Eliminar</label></th>
                    <th style="text-align: center"><label class="font-size">Asociar Veh&iacute;culo-Geozona</label></th>
                    <th style="text-align: center; display: none;"><label class="font-size">Zona</label></th>
                    <th style="text-align: center; display: none;"><label class="font-size">Json Zona</label></th>
                </tr>
            </thead>
            <tbody>                                
                <?php
                $index = 0;
                ?><script> var size = <?php echo(count($zona)); ?>;</script>
                <?php
                foreach ($zona as $item) {
                    setData($item);
                    echo ('<tr id="trMapIndx' . $index . '">'
                    . '<td  style="text-align: center">'
                    . '<label class="font-size">'
                    . $item->nombre
                    . '<td  style="text-align: center">'
                    . '<button type="button" class="btn"'
                    . 'onclick="showDataZona(' . $index . ',0);">'
                    . '<img src="../web/images/modificar.png" height="23px" width="29px;"></button>'
                    . '</td>'
                    . '<td  style="text-align: center">'
                    . '<button type="button" class="btn"'
                    . 'onclick="showDataZona(' . $index . ',1);">'
                    . '<img src="../web/images/habilitar.png" height="29px" width="23px;"></button>'
                    . '</td>'
                    . '<td  style="text-align: center">'
                    . '<button type="button" class="btn"'
                    . 'onclick="showDataZona(' . $index . ',2);">'
                    . '<img src="../web/images/vehiculoMapa.png" height="32px" width="32px;"></button>'
                    . '</td>'
                    . '<td  style="text-align: center; display:none;">'
                    . '<label class="font-size" id="lblId">' . $item->id
                    . '</label></td>'
                    . '<td  style="text-align: center; display:none;">'
                    . '<label class="font-size" id="lblJson">' . $item->zona
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

<div id="divMessageSuccessZona" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-success">Registro Exitoso</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td><span class="text-muted text-info"><label id='lblText'></label>
                                <label id="lblTotal"></label> veh&iacute;culos
                            </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="clearZona();">Aceptar</button>                            
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageSuccessModificarZona" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-info"> Zona Modificada </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> La zona fue modificada </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearZona();"> Aceptar </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageEliminarZona" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-warning"> Eliminar GeoZona </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> La zona ser&aacute; eliminada, todos los veh&iacute;culos 
                                asociados dejaran de pertenecer a la zona<br/>Desea continuar ?</span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnDeleteGeozona" name="btnDeleteGeozona"> Aceptar </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageSuccessEliminarZona" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-info"> Zona Eliminada </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> La zona fue eliminada </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearZona();"> Aceptar </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="divMessageAsociar" class="modal fade" role="dialog" title="Confirmaci&oacute;n">
    <div class="modal-dialog alert-success">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title label-warning"> Asociar veh&iacute;culo - Geozona </h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td> <span class="text-muted text-info"> Se asociaran los vehiculos seleccionados a la zona
                                <br/>Desea continuar? </span></td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnAceptarAsociar" name="btnAceptarAsociar"> Asociar </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

function setData($item) {
    $json = json_encode(array('id' => $item->id, 'nombre' => $item->nombre, 'zona' => $item->zona));
    ?>
    <script>
        zonas.push(
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
    