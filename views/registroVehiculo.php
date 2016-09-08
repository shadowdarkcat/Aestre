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
$vehiculos=[];
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
        <script>
            var vehiculos = [];
        </script>
        <title>Nuevo Vehiculo</title>
    </head>
    <body>
        <br/><br/><br/>
        <div class="container-fluid" style="background: white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                        <div class="table">
                            <table id="tblVehiculos" class="table table-striped table-bordered dt-responsive nowrap display">
                                <thead>
                                    <tr>
                                        <th style="text-align: center"><label class="font-size">Cliente</label></th>                                        
                                        <th style="text-align: center"><label class="font-size">Modelo</label></th>                                            
                                        <th style="text-align: center"><label class="font-size">Marca</label></th>
                                        <th style="text-align: center"><label class="font-size">Placa</label></th>
                                        <th style="text-align: center"><label class="font-size"># Vehiculo</label></th>
                                        <th style="text-align: center"><label class="font-size">Activo</label></th>
                                        <th style="text-align: center"><label class="font-size">Editar</label></th>
                                        <th style="text-align: center"><label class="font-size">Habilitar/Inhabilitar</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($vehiculos->getClientes() as $item) {
                                        foreach ($item->getVehiculos() as $items) {
                                            setData($item, $items);
                                            echo('<tr>'
                                            . '<td class="font-size" style="text-align: center" coldspan="7">'
                                            . $item->getNombre() . ' ' . $item->getPaterno() . ' ' . $item->getMaterno()
                                            . '</td>'
                                            . '<td class="font-size" style="text-align: center">'
                                            . $items->getModelo()
                                            . '</td>'
                                            . '<td class="font-size" style="text-align: center">'
                                            . $items->getMarca()
                                            . '</td>'
                                            . '<td class="font-size" style="text-align: center">'
                                            . $items->getPlaca()
                                            . '</td>'
                                            . '<td style="text-align: center">'
                                            . '<label class="font-size" id="lblId">'
                                            . $items->getIdVehiculo()
                                            . '</label>'
                                            . '</td>'
                                            . '<td  style="text-align: center">'
                                            . '<label class="font-size">'
                                            . (($items->getActivo() == TRUE) ? 'Sí' : 'NO')
                                            . '</label>'
                                            . '<td  style="text-align: center">'
                                            . '<button type="button" class="btn" '
                                            . 'onclick="showData(' . $index . ',0);">'
                                            . '<img src="../web/images/modificar.png" height="23px" width="29px;"></button>'
                                            . '</td>'
                                            . '<td  style="text-align: center">'
                                            . '<button type="button" class="btn"'
                                            . 'onclick="showData(' . $index . ',1);">'
                                            . '<img src="../web/images/habilitar.png" height="29px" width="23px;"></button>'
                                            . '</td></tr>');
                                            $index++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <form id="frmVehiculo" name="frmVehiculo" method="post">
                        <input type="hidden" id="txtIdVehiculo" name="txtIdVehiculo" />
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <div class="table-responsive">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/menuCliente.png" width="22px" height="22px">
                                        <label class="font-size">Datos Cliente</label>                        
                                    </legend>
                                    <table class="table table-striped table-bordered dt-responsive nowrap display">
                                        <thead>
                                            <tr>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class=" font-size">Cliente</label></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select id="cboCliente" name="cboCliente" class="required form-control col-xs-1 input-sm">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($clientes as $item) {
                                                            echo('<option value=' . $item->getIdCliente() . '>'
                                                            . $item->getNombre() . ' ' . $item->getPaterno()
                                                            . ' ' . $item->getMaterno());
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <div class="table-responsive">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/nuevoGps.png">
                                        <label class="font-size">Datos Gps</label>
                                    </legend>
                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> IMEI</label>
                                                </th>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> N<sup>o</sup> Sim</label>
                                                </th>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Dispositivo Gps</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <td>
                                            <input type="text" id="txtImei" name="txtImei" class="required form-control col-xs-1 input-sm" onkeypress="mayuscula(this);"/>
                                        </td>
                                        <td>
                                            <input type="text" id="txtTelefono" name="txtTelefono" class="required form-control col-xs-1 input-sm" onkeypress="mayuscula(this);"/>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select id="cboGps" name="cboGps" class="required form-control col-xs-1 input-sm">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($dispositivo as $item) {
                                                        echo('<option value="' . $item->getIdDispositivo() . '">' . $item->getDispositivo() . '</option>');
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <div class="table-responsive">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/nuevoVehiculo.png">
                                        <label class="font-size">Datos Veh&iacute;culo</label>
                                    </legend>
                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead>                                    
                                            <tr>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Modelo </label>
                                                </th>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Marca</label>
                                                </th>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Placa</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>                                                    
                                                <td>
                                                    <input type="text" id="txtModelo" name="txtModelo" class="required form-control col-xs-1 input-sm" onkeypress="mayuscula(this);"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtMarca" name="txtMarca" class="required form-control col-xs-1 input-sm" onkeypress="mayuscula(this);"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtPlaca" name="txtPlaca" class="required form-control col-xs-1 input-sm" onkeypress="mayuscula(this);"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size">Color</label>
                                                </th>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size">
                                                        <span class="req">*</span> &Uacute;ltima Verificaci&oacute;n
                                                    </label>
                                                </th>
                                                <th class="alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Tpo Uso</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtColor" name="txtColor" class="form-control col-xs-1 input-sm" onkeypress="mayuscula(this);" />
                                                </td>
                                                <td>
                                                    <input type="text" id="dtpVerificacion" name="dtpVerificacion" class="required form-control col-xs-1 input-sm" onkeypress="mayuscula(this);"/>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select id="cboGiro" name="cboGiro" class="required form-control col-xs-1 input-sm">
                                                            <option value=""></option>
                                                            <?php
                                                            foreach ($giro as $item) {
                                                                echo ('<option value=' . $item->getIdGiro() . '>' . $item->getGiro() . '</option>');
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th colspan="3" class="alert-info" style="text-align: center">
                                                    <label class="font-size">Icono Veh&iacute;culo</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="dt-responsive">
                                                    <input type="checkbox" id="chkIcon" name="chkIcon" class="form-control col-xs-1 input-sm" onclick="show();">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="dt-responsive" colspan="3">
                                                    <div id="divIcons" style="display: none;">
                                                        <div id="carousel" class="carousel slide" data-ride="carousel">
                                                            <div id="divContenido" class="carousel-inner" role="listbox">
                                                                <?php
                                                                $index = 0;
                                                                $default = NULL;
                                                                foreach ($iconos as $item) {
                                                                    if ($index == 0) {
                                                                        echo('<div class = "item active">'
                                                                        . '<center><img src = "' . $item->getPathIcono() . '" >'
                                                                        . '<button type = "button" class = "btn  btn-primary " id = "btnSeleccion" name = "btnSeleccion"'
                                                                        . 'onclick = "icon(' . $item->getIdIcono() . ');" >Seleccionar</button>'
                                                                        . '</center></div>');
                                                                        $index++;
                                                                    } else {
                                                                        if ($item->getIdIcono() != 100000) {
                                                                            echo('<div class = "item">'
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
                                                            </div>
                                                            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                                                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                                <span class="sr-only">Anterior</span>
                                                            </a>
                                                            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                                                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                                <span class="sr-only">Siguiente</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="txtIdImage" name="txtIdImage" value="<?php echo($default); ?> " />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <div class="table-responsive">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/activoInactivo.png">
                                        <label class="font-size">Registro Activo / Inactivo</label>
                                    </legend>   
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="chkActivo" name="chkActivo"
                                                           class="checkbox-inline text-muted col-xs-1 input-sm" checked="checked" onclick="return false">
                                                    <label id="lblActivo" class="font-size">S&iacute;</label>
                                                </td>
                                            </tr>
                                        </tbody>                                                    
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                            <div style="text-align:  center;">
                                <button type="button" class="btn" id="btnRegistrar" name="btnRegistrar">
                                    <img src="../web/images/guardar.png">Guardar</button>
                                <button type="button" class="btn" id="btnActualizar" name="btnActualizar">
                                    <img src="../web/images/actualizar.png">Actualizar</button>
                                <button type="button" class="btn" id="btnEliminar" name="btnEliminar" style="display: display;">
                                    <img src="../web/images/eliminar.png">Inhabilitar</button>
                                <button type="button" class="btn" id="btnActivate" name="btnActivate" style="display: none;">
                                    <img src="../web/images/habilitar.png">Habilitar</button>
                            </div>
                        </div>
                    </form>
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