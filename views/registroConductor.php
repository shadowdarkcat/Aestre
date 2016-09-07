<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/principalAdmin.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($login)) {
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
        <script>
            var conductores = [];
        </script>
        <title>Nuevo Conductor</title>
    </head>
    <body>
        <br/><br/><br/>
        <div class="container-fluid" style="background: white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                        <div class="table">
                            <table id="tblConductores" class="table table-striped table-bordered dt-responsive nowrap display">
                                <thead>
                                    <tr>
                                        <th style="text-align: center"><label class="font-size"># Conductor</label></th>
                                        <th style="text-align: center"><label class="font-size">Nombre Completo</label></th>
                                        <th style="text-align: center"><label class="font-size">Veh&iacute;culo</label></th>
                                        <th style="text-align: center"><label class="font-size">Activo</label></th>
                                        <th style="text-align: center"><label class="font-size">Editar</label></th>
                                        <th style="text-align: center"><label class="font-size">Habilitar/Inhabilitar</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($conductores as $item) {
                                        setData($item);
                                        echo('<tr>' .
                                        '<td style="text-align: center">'
                                        . $item->getIdConductor()
                                        . '</td>'
                                        . '<td style="text-align: center">'
                                        . $item->getNombre() . ' ' . $item->getPaterno() . ' ' . $item->getMaterno()
                                        . '</td>'
                                        . '<td style="text-align: center">'
                                        . $item->getDtoVehiculo()->getMarca() . ' ' . $item->getDtoVehiculo()->getModelo() . ' ' . $item->getDtoVehiculo()->getPlaca()
                                        . '</td>'
                                        . '<td  style="text-align: center">'
                                        . '<label class="font-size">'
                                        . (($item->getActivo() == TRUE) ? 'Sí' : 'NO')
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
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <form id="frmConductor" name="frmConductor" method="post">
                        <input type="hidden" id="txtIdConductor" name="txtIdConductor" />
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                            <div class="table-responsive">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/nuevoRegistro.png">
                                        <label class="font-size">Datos Conductor</label>
                                    </legend>       
                                    <table id="tblRegistroCliente" class="table">
                                        <thead>
                                            <tr>
                                                <th class="dt-responsive alert-info" style="text-align: center">                                                
                                                    <label class="font-size"> <span class="req">*</span> Nombre(s)</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Apellido Paterno</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span> Apellido Materno</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtNombre" name="txtNombre" class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese el nombre"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtPaterno" name="txtPaterno" class="required form-control col-xs-1 input-sm" 
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese el apellido paterno"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtMaterno" name="txtMaterno" class="required form-control col-xs-1 input-sm" 
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese el apellido materno"/>
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
                                        <img src="../web/images/formaContacto.png">
                                        <label class="font-size">Forma Contacto</label>
                                    </legend>                
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span> N<sup>o</sup> Local</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> N<sup>o</sup> M&oacute;vil</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span>  E-Mail</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtTelefono" name="txtTelefono" class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese el n&uacute;mero tel&eacute;fono"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtOtroTelefono" name="txtOtroTelefono" class="form-control col-xs-1 input-sm" 
                                                           onkeypress="minuscula(this);" placeholder="Ingrese el n&uacute;mero celular"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtMail" name="txtMail" class="required form-control col-xs-1 input-sm" 
                                                           onkeypress="minuscula()(this);" placeholder="Ingrese el correo electr&oacute;nico"/>
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
                                        <img src="../web/images/nuevaAgenda.png"> 
                                        <label class="font-size">Direcci&oacute;n</label>
                                    </legend>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span> Calle </label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> N<sup>o</sup> Exterior</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> N<sup>o</sup> Interior</label>
                                                </th>                                                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtCalle" name="txtCalle" class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese la calle"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtNoExterior" name="txtNoExterior" class="required form-control col-xs-1 input-sm" 
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese el n&uacute;mero exterior"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtNoInterior" name="txtNoInterior" class="form-control col-xs-1 input-sm" 
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese el n&uacute;mero interior"/>
                                                </td>                                                    
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Colonia </label>
                                                </th>      
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"><span class="req">*</span> Cp</label>
                                                </th>
                                                <th id="thTitleMuni" class="dt-responsive alert-info" style="text-align: center"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtColonia" name="txtColonia" class="required form-control col-xs-1 input-sm" 
                                                           onkeypress="mayuscula(this);" placeholder="Ingrese la colonia"/>
                                                    <input type="hidden" id="txtIdCp" name="txtIdCp" class="digits required form-control col-xs-1 input-sm" />
                                                </td>
                                                <td>
                                                    <input type="text" id="txtCp" name="txtCp" class="required form-control col-xs-1 input-sm"  
                                                           onkeypress="mayuscula(this);" placeholder="C&oacute;digo Postal" disabled="disabled"/>
                                                </td>
                                                <td id="tdMuni" ></td>
                                            </tr>
                                        </tbody> 
                                        <thead>                                        
                                        <th class="dt-responsive alert-info" style="text-align: center">
                                            <label class="font-size"><span class="req">*</span> Estado</label>
                                        </th>
                                        <th class="dt-responsive alert-info" style="text-align: center">
                                            <label class="font-size"><span class="req">*</span> Ciudad</label>
                                        </th>  
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtEstado" name="txtEstado" class="required form-control col-xs-1 input-sm" 
                                                           onkeypress="minuscula(this);" placeholder="Estado" disabled="disabled"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtCiudad" name="txtCiudad" class="required form-control col-xs-1 input-sm" 
                                                           onkeypress="minuscula(this);" placeholder="Ciudad" disabled="disabled"/>
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
                                        <img src="../web/images/licencia.png">
                                        <label class="font-size">Datos Licencia</label>
                                    </legend>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span> N<sup>o</sup> Licencia</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span> Vigencia</label>
                                                </th>
                                                <th class="dt-responsive alert-info" style="text-align: center">
                                                    <label class="font-size"> <span class="req">*</span> Tipo Licencia</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="txtNoLicencia" name="txtNoLicencia" class="required form-control col-xs-1 input-sm" 
                                                           placeholder="Ingrese la licencia" onkeypress="mayuscula(this);"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="txtVigencia" name="txtVigencia" class="required form-control col-xs-1 input-sm" 
                                                           placeholder="Ingrese la vigencia" onkeypress="mayuscula(this);"/>
                                                </td>
                                                <td>
                                                    <select id="cboLicencia" name="cboLicencia" class="required form-control col-xs-1 input-sm">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($licencias as $item) {
                                                            echo('<option value="' . $item->getIdLicencia() . '">' . $item->getLicencia() . '</option>');
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
                                        <img src="../web/images/menuConductor.png">
                                        <label class="font-size">Ve&iacute;culo a Conducir</label>
                                    </legend>   
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select id="cboVehiculo" name="cboVehiculo" class="required form-control col-xs-1 input-sm">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($vehiculos->getClientes() as $item) {
                                                            foreach ($item->getVehiculos() as $items) {
                                                                echo('<option value="' . $items->getIdVehiculo() . '">' . $items->getModelo() . ' '
                                                                . $items->getPlaca() . '</option>');
                                                            }
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
                                        <img src="../web/images/activoInactivo.png">
                                        <label class="font-size">Registro Activo / Inactivo</label>
                                    </legend>   
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="chkActivo" name="chkActivo"
                                                           class="checkbox-inline text-muted col-xs-1 input-sm" checked="checked" onclick="return false">S&iacute;
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