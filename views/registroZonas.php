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
if (isset($_SESSION['zonas'])) {
    $zona = json_decode($_SESSION['zonas']);
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
                    <th style="text-align: center"><label class="font-size">Habilitar/Inhabilitar</label></th>
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
<?php

function setData($item) {
    ?>
    <script>
        zonas.push(
    <?php
    echo('\'' . $item->id . ',' . $item->nombre . ',' . $item->zona . '\'');
    ?>
        );
    </script>
    <?php
}

if ($exist) {
    echo('<script>$("#divExiste").modal("show");</script>');
}
    