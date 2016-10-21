<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$controller = new clienteVehiculoController();
$controller->findByIdCliente($login->getIdCliente());
$dto = unserialize($_SESSION[PropertyKey::$session_clientes]);
?>
<script>listVehiculo();</script>
<script>var lstVehiculo = [];
    var totalSize = 0;
</script>
<!DOCTYPE html>
<div id="listVehiculos" >
    <div class="table">
        <table id="tblVehiculosMap" class="table table-striped table-bordered dt-responsive nowrap" data-role="datatable" cellspacing="0" width="10%" data-info="false">
            <thead>
                <tr>
                    <th style="text-align: center;"><label class="font-size">Vehiculo</label></th>
                    <th style="text-align: center;"><label class="font-size">Localizar</label></th>
                    <th style="text-align: center;"><label class="font-size">Historial Ruta</label></th>
                    <th style="text-align: center;"><label class="font-size">Reportes</label></th>
                </tr>            
            </thead>
            <tbody>
                <?php
                $index = 0;
                ?><script>var size = parseInt(<?php echo(count($dto->getVehiculos())); ?>);</script>
                <?php
                foreach ($dto->getVehiculos() as $items) {
                    setDataLstVehiculo($items);
                    echo ('<tr id="trIndx' . $index . '">'
                    . '<td style="text-align: center;width: 50%;">'
                    . $items->getModelo()
                    . '<br/>'
                    . $items->getPlaca()
                    . '</td>'
                    . '<td style="text-align: center;">'
                    . '<input type="radio" id="rdb" name="rdb" onClick="localizar(' . $items->getImei() . ');">'
                    . '</td>'
                    . '<td style="text-align: center;">'
                    . '<input type="radio" id="rdb" name="rdb" onClick="showRuta(' . $index . ',' . $items->getImei() . ');">'
                    . '</td>'
                    . '<td style="text-align: center;">'
                    . '<input type="radio" id="rdb" name="rdb" onClick="showReporte(' . $index . ');">'
                    . '</td>'
                    . '</tr>');
                    $index++;
                }
                ?>
            <script>totalSize = lstVehiculo.length;</script>
            </tbody>
        </table>
    </div>
</div>
<div id="noDataHistorial" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title alert-danger">Localizar Veh&iacute;culo</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td class="dt-responsive form-control">
                            <p><span class="text-muted text-info" >No existe historial de ruta para este veh&iacute;culo</span></p>
                        </td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptar" name="btnAceptar" onclick="onloadAll();">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

function setDataLstVehiculo(DtoVehiculo $item) {
    $json = json_encode(
            array(
                'id' => $item->getBeanDispositivo()->getIdDispositivo()
                , 'imei' => $item->getImei()
                , 'marca' => $item->getMarca()
                , 'telefono' => empty($item->getDtoConductor()) ? 'SN' : $item->getDtoConductor()->getTelefono() . '/' . $item->getDtoConductor()->getOtroTelefono()
                , 'conductor' => empty($item->getDtoConductor()) ? 'NA' : $item->getDtoConductor()->getNombre() . ' ' . $item->getDtoConductor()->getPaterno() . '' . $item->getDtoConductor()->getMaterno()
                , 'tipoLicencia' => empty($item->getDtoConductor()) ? 'NA' : $item->getDtoConductor()->getBeanLicencia()->getLicencia()
                , 'noLicencia' => empty($item->getDtoConductor()) ? 'NA' : $item->getDtoConductor()->getNoLicencia()
                , 'modelo' => $item->getModelo()
                , 'dispositivo' => $item->getBeanDispositivo()->getDispositivo()
                , 'imei' => $item->getImei()
                , 'sim' => $item->getSim()
                , 'placa' => $item->getPlaca()
                , 'uso' => $item->getBeanGiro()->getGiro()
                , 'color' => ($item->getColor()=='NULL') ? 'NO ESPECIFICADO' : $item->getColor()
                , 'isActivo' => $item->getActivo()
            )
    );
    ?>
    <script>
        lstVehiculo.push(
    <?php
    echo($json);
    ?>);
    </script>
    <?php
}
