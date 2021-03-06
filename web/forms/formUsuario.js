function getFormUsuario() {
    return '<form id="frmUsuario" name="frmUsuario" method="post">'
            + '<input type="hidden" id="txtIdUsuario" name="txtIdUsuario" />'
            + '<div class="col-lg-9 col-md-4 col-sm-6 col-xs-12">'
            + '<div class="table-responsive">'
            + '<fieldset>'
            + '<legend class="text-muted alert-info">'
            + '<img src="../web/images/nuevoRegistro.png">'
            + '<label class="font-size">Datos Usuario</label>'
            + '</legend>'
            + '<table class="table">'
            + '<thead>'
            + '<tr>'
            + '<th class="dt-responsive alert-info" style="text-align: center">'
            + '<label class="font-size"> <span class="req">*</span> Nombre Usuario</label>'
            + '</th>'
            + '<th class="dt-responsive alert-info" style="text-align: center">'
            + '<label class="font-size"> <span class="req">*</span> Contrase&ntilde;a</label>'
            + '</th>'
            + '<th class="dt-responsive alert-info" style="text-align: center">'
            + '<label class="font-size"> <span class="req">*</span> Nombre Completo</label>'
            + '</th>'
            + '</tr>'
            + '</thead>'
            + '<tbody>'
            + '<tr>'
            + '<td>'
            + '<input type="text" id="txtUser" name="txtUser"'
            + 'class="required form-control col-xs-1 input-sm"  '
            + 'onkeypress="mayuscula(this);" placeholder="Ingrese usuario"/>'
            + '</td>'
            + '<td>'
            + '<input type="password" id="txtPassword" name="txtPassword"'
            + 'class="required form-control col-xs-1 input-sm"  '
            + 'onkeypress="mayuscula(this);" placeholder="Ingrese contraseña"/>'
            + '</td>'
            + '<td>'
            + '<input type="text" id="txtNombre" name="txtNombre" class="required form-control col-xs-1 input-sm"  '
            + 'onkeypress="mayuscula(this);" placeholder="Ingrese nombre"/>'
            + '</td>'
            + '</tr>'
            + '</tbody>'
            + '</table>'
            + '<table class="table">'
            + '<thead>'
            + '<tr>'
            + '<th class="dt-responsive alert-info" style="text-align: center">'
            + '<label class="font-size"> <span class="req">*</span> N<sup>o</sup> M&oacute;vil</label>'
            + '</th>'
            + '<th class="dt-responsive alert-info" style="text-align: center">'
            + '<label class="font-size"> <span class="req">*</span> E-Mail</label>'
            + '</th>'
            + '</tr>'
            + '</thead>'
            + '<tbody>'
            + '<tr>'
            + '<td>'
            + '<input type="text" id="txtTelefono" name="txtTelefono" class="required form-control col-xs-1 input-sm"  '
            + 'onkeypress="mayuscula(this);" placeholder="Ingrese movil"/>'
            + '</td>'
            + '<td>'
            + '<input type="text" id="txtMail" name="txtMail" class="required form-control col-xs-1 input-sm"  '
            + 'onkeypress="mayuscula(this);" placeholder="Ingrese mail"/>'
            + '</td>'
            + '</tr>'
            + '</tbody>'
            + '</table>'
            + '</fieldset>'
            + '</div>'
            + '</div>'
            + '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">'
            + '<div class="table-responsive">'
            + '<fieldset>'
            + '<legend class="text-muted alert-info">'
            + '<label class="font-size">Tipo Cuenta / Privilegios</label>'
            + '</legend>'
            + '<table  class="table">'
            + '<tbody>'
            + '<tr>'
            + '<td class="dt-responsive form-control" style="height: 100%">'
            + '<input type="checkbox" id="chkAdmin" name="chkAdmin"'
            + 'class="checkbox-inline text-muted" checked="checked" onclick="isAdmin();" >'
            + '<label id="lblIsAdmin">Administrador</label>'
            + '<br/>'
            + '<div id="tree"></div>'
            + '</td>'
            + '</tr>'
            + '</tbody>'
            + '</table>'
            + '</fieldset>'
            + '</div>'
            + '</div>'
            + '<div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">'
            + '<div class="table-responsive">'
            + '<fieldset>'
            + '<legend class="text-muted alert-info">'
            + '<img src="../web/images/menuCliente.png" width="20px;" height="20px;">-<img src="../web/images/nuevoVehiculo.png">'
            + '<label class="font-size">Cliente Asociado al Usuario</label>'
            + '</legend>'
            + '<table class="table">'
            + '<tbody>'
            + '<tr>'
            + '<td>'
            + '<select id="cboCliente" name="cboCliente" class="required form-control col-xs-1 input-sm">'
            + '<option value="">Seleccione...</option>'
            + '</select>'
            + '</td>'
            + '</tr>'
            + '</tbody>'
            + '</table>'
            + '</fieldset>'
            + '</div>'
            + '</div>'
            + '<div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">'
            + '<div class="table-responsive">'
            + '<table class="table">'
            + '<tbody>'
            + '<tr>'
            + '<td>'
            + '<fieldset>'
            + '<legend class="text-muted alert-info">'
            + '<img src="../web/images/activoInactivo.png">'
            + '<label class="font-size">Registro Activo / Inactivo</label>'
            + '</legend>  '
            + '<input type="checkbox" id="chkActivo" name="chkActivo"'
            + 'class="checkbox-inline text-muted col-xs-1 input-sm" checked="checked" onclick="return false">S&iacute;'
            + '</fieldset> '
            + '</td>'
            + '</tr>'
            + '</tbody>'
            + '</table>'
            + '</div>'
            + '</div>'
            + '<div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">'
            + '<div style="text-align:  center;">'
            + '<button type="button" class="btn" id="btnRegistrar" name="btnRegistrar">'
            + '<img src="../web/images/guardar.png">Guardar</button>'
            + '<button type="button" class="btn" id="btnActualizar" name="btnActualizar">'
            + '<img src="../web/images/actualizar.png">Actualizar</button>'
            + '<button type="button" class="btn" id="btnEliminar" name="btnEliminar" style="display: display;">'
            + '<img src="../web/images/eliminar.png">Inhabilitar</button>'
            + '<button type="button" class="btn" id="btnActivate" name="btnActivate" style="display: none;">'
            + '<img src="../web/images/habilitar.png">Habilitar</button>'
            + '<button type = "button" class="btn" id = "btnCancel" name = "btnCancel">'
            + '<img src = "../web/images/cancel.png" > Cerrar </button>'
            + '</div>'
            + '</div>'
            + '</form>';
}