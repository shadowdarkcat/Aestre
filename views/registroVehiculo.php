<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/principalAdmin.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$controller = new giroController();
$controller->giros();
if (isset($_SESSION[PropertyKey::$session_clientes])) {
    $clientes = unserialize($_SESSION[PropertyKey::$session_clientes]);
}
if (isset($_SESSION[PropertyKey::$session_giro])) {
    $giro = unserialize($_SESSION[PropertyKey::$session_giro]);
    unset($_SESSION[PropertyKey::$session_giro]);
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nuevo Vehiculo</title>
    </head>
    <body>
        <br/><br/><br/><br/>
        <div class="container-fluid" style="background: white;">
            <form id="frmVehiculo" name="frmVehiculo" method="post">
                <input type="hidden" id="txtIdVehiculo" name="txtIdVehiculo" />
                <div class="table-responsive">
                    <table id="tblRegistroVehiculo" class="table">
                        <tr>
                            <td>
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/menuCliente.png" width="22px" height="22px">
                                        <label class="font-size">Datos Cliente</label>                        
                                    </legend>
                                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="alert-info" style="text-align: center">Cliente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select id="cboCliente" name="cboCliente" class="required form-control">
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
                            </td>
                            <td>
                                <div class="container">
                                    <fieldset>
                                        <legend class="text-muted alert-info">
                                            <img src="../web/images/nuevoVehiculo.png">
                                            <label class="font-size">Datos Veh&iacute;culo</label>
                                        </legend>
                                        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
                                                        <input type="text" id="txtModelo" name="txtModelo" class="required form-control col-xs-2 input-sm" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="txtMarca" name="txtMarca" class="required form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="txtPlaca" name="txtPlaca" class="required form-control" />
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
                                                        <input type="text" id="txtColor" name="txtColor" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="dtpVerificacion" name="dtpVerificacion" class="required form-control"/>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select id="cboUso" name="cboUso" class="required form-control">
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
                                                    <td class="dt-responsive" colspan="3">

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="container">
                                    <fieldset>
                                        <legend class="text-muted alert-info">
                                            <img src="../web/images/nuevoGps.png">
                                            <label class="font-size">Datos Gps</label>
                                        </legend>
                                        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
                                                <input type="text" id="txtIme" name="txtImei" class="required form-control"/>
                                            </td>
                                            <td>
                                                <input type="text" id="txtTelefono" name="txtTelefono" class="required form-control"/>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select id="cboGps" name="cboGps" class="required form-control">
                                                        <option value=""></option>
                                                        <?php
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>                
            </form>
        </div>
    </body>
</html>
