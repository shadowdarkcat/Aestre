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

if (isset($_SESSION[PropertyKey::$session_users])) {
    $usuarios = unserialize($_SESSION[PropertyKey::$session_users]);
}
$controllerC = new clienteController();
$controllerC->findAllToUsuario();
if (isset($_SESSION[PropertyKey::$session_clientes])) {
    $clientes = unserialize($_SESSION[PropertyKey::$session_clientes]);
}

$exist = '';
if (isset($_SESSION[PropertyKey::$session_exists])) {
    $exist = unserialize($_SESSION[PropertyKey::$session_exists]);
    unset($_SESSION[PropertyKey::$session_exists]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <script type="text/javascript" src="../web/js/usuarios.js"></script>
        <script>
            var usuarios = [];
        </script>
        <title>Nuevo Usuario</title>
    </head>
    <body>
        <br/><br/><br/>
        <div class="container-fluid" style="background: white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                        <div class="table">
                            <table id="tblUsuarios" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center"><label class="font-size"># Usuario</label></th>
                                        <th style="text-align: center"><label class="font-size">Nombre</label></th>
                                        <th style="text-align: center"><label class="font-size">No Tel&eacute;fono</label></th>
                                        <th style="text-align: center"><label class="font-size">Nombre Usuario</label></th>
                                        <th style="text-align: center"><label class="font-size">Activo</label></th>
                                        <th style="text-align: center"><label class="font-size">Editar</label></th>
                                        <th style="text-align: center"><label class="font-size">Habilitar/Inhabilitar</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($usuarios as $item) {
                                        setData($item);
                                        echo('<tr>'
                                        . '<td style="text-align: center">'
                                        . '<label class="font-size" id="lblId">' . $item->getIdUsuario() . '</label>'
                                        . '</td>'
                                        . '<td style = "text-align: center">'
                                        . '<label class="font-size">' . $item->getNombre() . '</label>'
                                        . '</td>'
                                        . '<td style = "text-align: center">'
                                        . '<label class="font-size">' . $item->getTelefono() . '</label>'
                                        . '</td>'
                                        . '<td style="text-align: center">'
                                        . '<label class="font-size">' . $item->getNombreUsuario() . '</label>'
                                        . '</td>'
                                        . '<td  style="text-align: center">'
                                        . '<label class="font-size">' . (($item->getActivo() == TRUE) ? 'Sí' : 'NO')
                                        . '</label></td>'
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
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form id="frmUsuario" name="frmUsuario" method="post">
                        <input type="hidden" id="txtIdUsuario" name="txtIdUsuario" />
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <div class="table-responsive">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/nuevoRegistro.png">
                                        <label class="font-size">Datos Usuario</label>
                                    </legend>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="dt-responsive alert-info" style="text-align: center">                                                
                                                    <label class="font-size"> <span class="req">*</span> Nombre Usuario</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">                                                
                                                    <label class="font-size"> <span class="req">*</span> Contrase&ntilde;a</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">                                                
                                                    <label class="font-size"> <span class="req">*</span> Nombre Completo</label>
                                                </th>                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtUser" name="txtUser"
                                                           class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese usuario"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtPassword" name="txtPassword"
                                                           class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese contraseña"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtNombre" name="txtNombre" class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese nombre"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="dt-responsive alert-info" style="text-align: center">                                                
                                                    <label class="font-size"> <span class="req">*</span> N<sup>o</sup> M&oacute;vil</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span> E-Mail</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtTelefono" name="txtTelefono" class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese movil"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtMail" name="txtMail" class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese mail"/>
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
                                        <label class="font-size">Tipo Cuenta / Privilegios</label>
                                    </legend>
                                    <table  class="table">
                                        <tbody>
                                            <tr>
                                                <td class="dt-responsive form-control" style="height: 100%">
                                                    <input type="checkbox" id="chkAdmin" name="chkAdmin"
                                                           class="checkbox-inline text-muted" checked="checked" onclick="isAdmin();" >
                                                    <label id="lblIsAdmin">Administrador</label>
                                                    <br/>
                                                    <div id="tree"></div>
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
                                        <img src="../web/images/menuCliente.png" width="20px;" height="20px;">-<img src="../web/images/nuevoVehiculo.png">
                                        <label class="font-size">Cliente Asociado al Usuario</label>
                                    </legend>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select id="cboCliente" name="cboCliente" class="required form-control col-xs-1 input-sm">>
                                                        <option value="">Seleccione...</option>
                                                        <?php
                                                        foreach ($clientes as $item) {
                                                            echo('<option value="' . $item->getIdCliente() . '">' . $item->getNombre() . ' '
                                                            . $item->getPaterno() . ' ' . $item->getMaterno() . '</option>');
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
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <fieldset>                                        
                                                    <legend class="text-muted alert-info">
                                                        <img src="../web/images/activoInactivo.png">
                                                        <label class="font-size">Registro Activo / Inactivo</label>
                                                    </legend>  
                                                    <input type="checkbox" id="chkActivo" name="chkActivo"
                                                           class="checkbox-inline text-muted col-xs-1 input-sm" checked="checked" onclick="return false">S&iacute;
                                                </fieldset>                                             
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    </body>
</html>
<?php

function setData(DtoLogin $item) {
    ?>
    <script>
        usuarios.push(
    <?php
    echo('\'' . $item->getIdUsuario() . ',' . $item->getNombreUsuario()
    . ',' . $item->getNombre() . ',' . $item->getTelefono()
    . ',' . $item->getMail() . ',' . $item->getIdCliente()
    . ',' . $item->getAdmin() . ',' . $item->getActivo() . '\'');
    ?>);
    </script>
    <?php
}

if ($exist) {
    echo('<script>$("#divExiste").modal("show");</script>');
}
?>