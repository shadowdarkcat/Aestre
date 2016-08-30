<?php 
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/principalAdmin.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new giroController();
$controller->giros();
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
        <script type="text/javascript" src="../web/js/clientes.js"></script>
        <title>Nuevo Cliente</title>
    </head>
    <body>
        <br/><br/><br/><br/>
        <div class="container">
            <form id="frmCliente" name="frmCliente" 
                  method="post" action="/Aestre/com/aestre/system/controller//clienteController.php?id=0&method=1">
                <table id="tblRegistroCliente" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/nuevoRegistro.png">
                                        <label class="font-size">Datos Cliente / Forma Contacto</label>
                                    </legend>

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
                                            <td class="dt-responsive">
                                                <input type="text" id="txtNombre" name="txtNombre" class="required form-control"  
                                                       onkeypress="mayuscula(this);" placeholder="Ingrese el nombre"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtPaterno" name="txtPaterno" class="required form-control" 
                                                       onkeypress="minuscula(this);" placeholder="Ingrese el apellido paterno"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtMaterno" name="txtMaterno" class="required form-control" 
                                                       onkeypress="mayuscula(this);" placeholder="Ingrese el apellido materno"/>
                                            </td>
                                        </tr>
                                    </tbody>                    

                                    <thead>
                                        <tr>
                                            <th class="dt-responsive alert-info" style="text-align: center">
                                                <label class="font-size"> <span class="req">*</span> N<sup>o</sup> Local</label>
                                            </th>
                                            <th class="dt-responsive alert-info" style="text-align: center">
                                                <label class="font-size"> <span class="req">*</span> N<sup>o</sup> M&oacute;vil</label>
                                            </th>
                                            <th class="dt-responsive alert-info" style="text-align: center">
                                                <label class="font-size"> <span class="req">*</span>  E-Mail</label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtTelefono" name="txtTelefono" class="required form-control"  
                                                       onkeypress="mayuscula(this);" placeholder="Ingrese el n&uacute;mero tel&eacute;fono"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtOtroTelefono" name="txtOtroTelefono" class="required form-control" 
                                                       onkeypress="minuscula(this);" placeholder="Ingrese el n&uacute;mero celular"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtMail" name="txtMail" class="required form-control" 
                                                       onkeypress="mayuscula(this);" placeholder="Ingrese el correo electr&oacute;nico"/>
                                            </td>
                                        </tr>
                                    </tbody>  
                            </table>
                        </td>
                        <td>
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/nuevaAgenda.png"> 
                                        <label class="font-size">Direcci&oacute;n</label>
                                    </legend>
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
                                            <th class="dt-responsive alert-info" style="text-align: center">
                                                <label class="font-size"><span class="req">*</span> Colonia </label>
                                            </th>                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtCalle" name="txtCalle" class="required form-control"  
                                                       onkeypress="mayuscula(this);" placeholder="Ingrese la calle"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtNoExterior" name="txtNoExterior" class="required form-control" 
                                                       onkeypress="minuscula(this);" placeholder="Ingrese el n&uacute;mero exterior"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtNoInterior" name="txtNoInterior" class="required form-control" 
                                                       onkeypress="minuscula(this);" placeholder="Ingrese el n&uacute;mero interior"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtColonia" name="txtColonia" class="required form-control" 
                                                       onkeypress="mayuscula(this);" placeholder="Ingrese la colonia"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th class="dt-responsive alert-info" style="text-align: center">
                                                <label class="font-size"><span class="req">*</span> Cp</label>
                                            </th>

                                            <th class="dt-responsive alert-info" style="text-align: center">
                                                <label class="font-size"><span class="req">*</span> Estado</label>
                                            </th>
                                            <th class="dt-responsive alert-info" style="text-align: center">
                                                <label class="font-size"><span class="req">*</span> Ciudad</label>
                                            </th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtCp" name="txtCp" class="required form-control"  
                                                       onkeypress="mayuscula(this);" placeholder="C&oacute;digo Postal" disabled="disabled"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtEstado" name="txtEstado" class="required form-control" 
                                                       onkeypress="minuscula(this);" placeholder="Estado" disabled="disabled"/>
                                            </td>
                                            <td class="dt-responsive">
                                                <input type="text" id="txtCiudad" name="txtCiudad" class="required form-control" 
                                                       onkeypress="minuscula(this);" placeholder="Ciudad" disabled="disabled"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </fieldset>
                            </table>
                        </td>
                    </tr>
                    <tr>                        
                        <td>
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/giro.png">
                                        <label class="font-size">Giro</label>
                                    </legend>
                                    <tbody>
                                        <tr>
                                            <td class="dt-responsive">
                                                <div class="form-group">
                                                    <select id="cboGiro" name="cboGiro" class="form-control required">
                                                        <option value=" "></option>
                                                        <?php
                                                        foreach ($giro as $item){
                                                            echo ('<option value='.$item->getIdGiro().'>'.$item->getGiro().'</option>');
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>                    
                                </fieldset>
                            </table>
                        </td>
                        <td>
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <fieldset>
                                    <legend class="text-muted alert-info">
                                        <img src="../web/images/activoInactivo.png">
                                        <label class="font-size">Registro Activo / Inactivo</label>
                                    </legend>                                    
                                    <tbody>
                                        <tr>
                                            <td class="dt-responsive">
                                                <input type="checkbox" id="chkActivo" name="chkActivo"
                                                       class="checkbox-inline text-muted" checked="checked" onclick="return false">S&iacute;
                                            </td>
                                        </tr>
                                    </tbody>                    
                                </fieldset>
                            </table>
                        </td>
                    </tr>
                    <tbody>
                            <tr>
                                <td class="dt-responsive" style="text-align: center">
                                    <button type="button" class="btn" id="btnRegistrar" name="btnRegistrar">
                                        <img src="../web/images/guardar.png">Guardar</button>
                                </td>
                                <td class="dt-responsive" style="text-align: center">
                                    <button type="button" class="btn" id="btnActualizar" name="btnActualizar">
                                        <img src="../web/images/actualizar.png">Actualizar</button>
                                </td>
                                <td class="dt-responsive" style="text-align: center">
                                    <button type="button" class="btn" id="btnEliminar" name="btnEliminar">
                                        <img src="../web/images/eliminar.png">Eliminar</button>
                                </td>                                
                            </tr>
                        </tbody>
                </table>
            </form>
            <div style="background: white;">
                <table id="tblClientes" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: center"><label class="font-size">Cliente</label></th>
                            <th style="text-align: center"><label class="font-size">Nombre Completo</label></th>
                            <th style="text-align: center"><label class="font-size">Activo</label></th>
                        </tr>
                    </thead>
                    <tbody>
                       <!-- <tr>
                            <td class="dt-responsive" style="text-align: center">
                                <label class="font-size" id="lblId">1</label>
                            </td>
                            <td class="dt-responsive" style="text-align: center"><label id="lblMail" class="font-size">gtrxrver2007@gmail.com</label></td>
                            <td class="dt-responsive" style="text-align: center"><label id="lblNom1" class="font-size">gabriel</label>
                                <input type="hidden" id="idColeg" name="idColeg" value="1"/>
                            </td>
                        </tr>!-->
                    </tbody>                    
                </table>
            </div>
        </div>
    </body>
</html>
