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
$vehiculos = [];
if (isset($_SESSION[PropertyKey::$session_vehiculos])) {
    $vehiculos = unserialize($_SESSION[PropertyKey::$session_vehiculos]);
}
$controller = new giroController();
$controller->giros();
if (isset($_SESSION[PropertyKey::$session_giro])) {
    $giro = unserialize($_SESSION[PropertyKey::$session_giro]);
    unset($_SESSION[PropertyKey::$session_giro]);
}
$controllerD = new dispositivoController();
$controllerD->dispositivos();
if (isset($_SESSION[PropertyKey::$session_dispositivos])) {
    $dispositivo = unserialize($_SESSION[PropertyKey::$session_dispositivos]);
    unset($_SESSION[PropertyKey::$session_dispositivos]);
}
$controllerI = new iconosController();
$controllerI->iconos();
if (isset($_SESSION[PropertyKey::$session_iconos])) {
    $iconos = unserialize($_SESSION[PropertyKey::$session_iconos]);
    unset($_SESSION[PropertyKey::$session_iconos]);
}
if (isset($_SESSION[PropertyKey::$session_clientes])) {
    $clientes = unserialize($_SESSION[PropertyKey::$session_clientes]);
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <script type="text/javascript" src="../web/js/vehiculos.js"></script>
        <script type="text/javascript" src="../web/forms/formVehiculo.js"></script>
        <script>
            var vehiculos = [];
            var size = 0;
        </script>
        <title>Nuevo Vehiculo</title>
    </head>
    <br/><br/><br/><br/><br/>
    <body>
        <?php
        $optionC = '<option value=""></option>';
        foreach ($clientes as $item) {
            $optionC.='<option value=' . $item->getIdCliente() . '>'
                    . $item->getNombre() . ' ' . $item->getPaterno()
                    . ' ' . $item->getMaterno() . '</option>';
        }
        $optionD = '<option value=""></option>';
        foreach ($dispositivo as $item) {
            $optionD.='<option value=' . $item->getIdDispositivo() . '>' . $item->getDispositivo() . '</option>';
        }
        $optionG = '<option value=""></option>';
        foreach ($giro as $item) {
            $optionG.='<option value=' . $item->getIdGiro() . '>' . $item->getGiro() . '</option>';
        }
        $icons = '';
        $index = 0;
        $default = NULL;
        foreach ($iconos as $item) {
            if ($index == 0) {
                $icons.=('<div class = "item active">'
                        . '<center><img src = "' . $item->getPathIcono() . '" >'
                        . '<button type = "button" class = "btn  btn-primary " id = "btnSeleccion" name = "btnSeleccion"'
                        . 'onclick = "icon(' . $item->getIdIcono() . ');" >Seleccionar</button>'
                        . '</center></div>');
                $index++;
            } else {
                if ($item->getIdIcono() != 100000) {
                    $icons.=('<div class = "item">'
                            . '<center><img src = "' . $item->getPathIcono() . '" >'
                            . '<button type = "button" class = "btn  btn-primary " id = "btnSeleccion" name = "btnSeleccion"'
                            . 'onclick = "icon(' . $item->getIdIcono() . ');" >Seleccionar</button>'
                            . '</center></div>');
                } else {
                    $default = $item->getIdIcono();
                }
            }
        }
        ?>

        <script>
            var cboCliente = '<?php echo($optionC); ?>';
            var cboGps = '<?php echo($optionD); ?>';
            var cboGiro = '<?php echo($optionG); ?>';
            var icons = '<?php echo($icons); ?>';
            var def = '<?php echo($default); ?>';
        </script>
        <br/><br/><br/>
        <div class="container-fluid" style="background: white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                        <h4 style="text-align: center;" >VEH&Iacute;CULOS</h4>
                        <div class="table">
                            <table id="tblVehiculos" class="table table-striped table-bordered dt-responsive nowrap display">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"><label class="font-size">Cliente</label></th>
                                        <th style="text-align: center;"><label class="font-size">Modelo</label></th>
                                        <th style="text-align: center;"><label class="font-size">Marca</label></th>
                                        <th style="text-align: center;"><label class="font-size">Placa</label></th>                                        
                                        <th style="text-align: center;"><label class="font-size">Activo</label></th>
                                        <th style="text-align: center;"><label class="font-size">Editar</label></th>
                                        <th style="text-align: center;"><label class="font-size">Habilitar/Inhabilitar</label></th>
                                        <th style="text-align: center; display: none;"><label class="font-size"># Vehiculo</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($vehiculos->getClientes() as $item) {
                                        ?><script> size += parseInt(<?php echo(count($item->getVehiculos())); ?>);</script>
                                        <?php
                                        foreach ($item->getVehiculos() as $items) {
                                            setData($item, $items);
                                            echo ('<tr id="trIndx' . $index . '">'
                                            . '<td class="font-size" style="text-align: center;" coldspan="7">'
                                            . $item->getNombre() . ' ' . $item->getPaterno() . ' ' . $item->getMaterno()
                                            . '</td>'
                                            . '<td class="font-size" style="text-align: center;">'
                                            . $items->getModelo()
                                            . '</td>'
                                            . '<td class="font-size" style="text-align: center;">'
                                            . $items->getMarca()
                                            . '</td>'
                                            . '<td class="font-size" style="text-align: center;">'
                                            . $items->getPlaca()
                                            . '</td>'
                                            . '<td  style="text-align: center;">'
                                            . '<label class="font-size">'
                                            . (($items->getActivo() == TRUE) ? 'Sí' : 'NO')
                                            . '</label>'
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
                                            . '<td style="text-align: center; display:none;">'
                                            . '<label class="font-size" id="lblId">'
                                            . $items->getIdVehiculo()
                                            . '</label>'
                                            . '</td>'
                                            . '</tr>');
                                            $index++;
                                        }
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

function setData(DtoCliente $item, DtoVehiculo $items) {
    ?>
    <script>
        vehiculos.push(
    <?php
    echo('\'' . $item->getIdCliente() . ',' . $items->getIdVehiculo()
    . ',' . $items->getImei() . ',' . $items->getSim()
    . ',' . $items->getBeanDispositivo()->getIdDispositivo() . ',' . $items->getModelo()
    . ',' . $items->getMarca() . ',' . $items->getPlaca()
    . ',' . $items->getColor() . ',' . $items->getVerificacion()
    . ',' . $items->getBeanGiro()->getIdGiro() . ',' . $items->getBeanIconos()->getIdIcono()
    . ',' . $items->getActivo() . '\'');
    ?>
        );
    </script>
    <?php
}

if ($exist) {
    echo('<script>$("#divExiste").modal("show");</script>');
}
?>