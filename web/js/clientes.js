var clicks = 0;
$(document).ready(function () {
    changeErrorMessage('frmCliente');
    $('#divMessageUpdate').find('#lblTittleUpdate').empty();
    $('#divMessageDelete').find('#lblTittleDelete').empty();
    $('#divActivar').find('#lblTittleActivar').empty();
    $('#divExiste').find('#lblTittleExists').empty();
    $('#divMessageUpdate').find('#lblTittleUpdate').text('Cliente');
    $('#divMessageDelete').find('#lblTittleDelete').text('Cliente');
    $('#divActivar').find('#lblTittleActivar').text('Cliente');
    $('#divExiste').find('#lblTittleExists').text('Cliente');
    $('#tblClientes').DataTable({
        language: {
            url: contextoGlobal + '/web/resources/es_ES.json'
        }
    });
    $(function () {
        $('#foot').append('<tr><td  style="text-align: center">'
                + '<button type="button" class="btn" '
                + 'onclick="showNew();">'
                + '<img src="../web/images/nuevo.png" >Nuevo</button>'
                + '</td>'
                + '</tr>'
                + '<tr id="trIndxFoot0"></tr>');
    });
    complete = function () {
        $('#txtColonia').autocomplete({
            source: availableTags
            , select: function (event, data) {
                $('#thTitleMuni').empty('');
                $('#tdMuni').empty('');
                var split = [];
                var td;
                if (data.item) {
                    split = data.item.value.split(',');
                }
                var th;
                var td;
                if (split[2] != '') {
                    th = '<label class="font-size"><span class="req">*</span> Delegaci&oacute;n</label> ';
                    td = '<td><input type="text" id="txtDelegacion" name="txtDelegacion" class="required form-control" value="'
                            + split[2] + '" readOnly="readOnly" /></td>';
                } else if (split[3] != '') {
                    th = '<label class="font-size"><span class="req">*</span> Munic&iacute;pio</label> ';
                    td = '<td><input type="text" id="txtMunicipio" name="txtMunicipio" class="required form-control" value="'
                            + split[3] + '" readOnly="readOnly" /></td>';
                }
                $('#thTitleMuni').append(th);
                $('#tdMuni').append(td);
                $('#txtCp').val(split[4]);
                $('#txtEstado').val(split[5]);
                $('#txtCiudad').val(split[6]);
                $('#txtColonia').val(split[1]);
                $('#txtIdCp').val(split[0]);
                $(this).val(split[1]);
                return false;
            }
        }).keypress(function (e, data) {
            if (e.which == 13) {
                var split = [];
                var td;
                if (data.item) {
                    split = data.item.value.split(',');
                }
                var th;
                var td;
                if (split[2] != '') {
                    th = '<label class="font-size"><span class="req">*</span> Delegaci&oacute;n</label> ';
                    td = '<td><input type="text" id="txtDelegacion" name="txtDelegacion" class="required form-control" value="'
                            + split[2] + '" readOnly="readOnly" /></td>';
                } else if (split[3] != '') {
                    th = '<label class="font-size"><span class="req">*</span> Munic&iacute;pio</label> ';
                    td = '<td><input type="text" id="txtMunicipio" name="txtMunicipio" class="required form-control" value="'
                            + split[3] + '" readOnly="readOnly" /></td>';
                }
                $('#thTitleMuni').append(th);
                $('#tdMuni').append(td);
                $('#txtCp').val(split[4]);
                $('#txtCp').val(split[4]);
                $('#txtEstado').val(split[5]);
                $('#txtCiudad').val(split[6]);
                $('#txtIdCp').val(split[0]);
                $(this).val(split[1]);
                return false;
            }
        });
    };
    btns = function () {
        $('#btnRegistrar').on('click', function () {
            $('#frmCliente').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/clienteController.php?&method=1');
            if ($('#frmCliente').validate().form()) {
                $('#frmCliente').submit();
            }
        });
        $('#btnActualizar').on('click', function () {
            if ($('#frmCliente').validate().form()) {
                $('#frmCliente').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/clienteController.php?method=2');
                $('#divMessageUpdate').modal('show');
            }
        });
        $('#btnUpdate').on('click', function () {
            $('#frmCliente').submit();
        });
        $('#btnEliminar').on('click', function () {
            $('#chkActivo').prop('checked', false);
            if ($('#frmCliente').validate().form()) {
                $('#frmCliente').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/clienteController.php?method=3');
                $('#divMessageDelete').modal('show');
            }
        });
        $('#btnDelete').on('click', function () {
            $('#frmCliente').submit();
        });
        $('#btnActivate').on('click', function () {
            $('#chkActivo').prop('checked', true);
            if ($('#frmCliente').validate().form()) {
                $('#frmCliente').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/clienteController.php?method=3');
                $('#divActivar').modal('show');
            }
        });
        $('#btnAceptarActivar').on('click', function () {
            $('#frmCliente').submit();
        });

        $('#btnCancel').on('click', function () {
            $('#divMessageCancel').modal('show');
        });
        $('#btnAceptarCerrar').on('click', function () {
            clear(size);
            $('#trIndxFoot0').empty();
        });
    };
});

function showNew() {
    clear(size);
    $('#trIndxFoot0').append('<td colspan="5">' + getFormCliente() + '</td></tr>');    
    $('#txtNombre').focus();    
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    complete();
    btns();
}
function showData(index, action) {
    var data = clientes[index].split(',');
    clear(size);
    $('#trIndxFoot0').empty();
    $('#trIndx' + index).before('<tr id="trIntIndx' + index + '"><td colspan="5">' + getFormCliente() + '</td></tr>');
    if (data[18] == true) {
        if (action == 0) {
            enabled();
            $('#frmCliente').find('#btnActualizar').prop('disabled', false);
            $('#frmCliente').find('#btnEliminar').prop('disabled', true);
        } else {
            disabled();
            $('#frmCliente').find('#btnEliminar').prop('disabled', false);
            $('#frmCliente').find('#btnActualizar').prop('disabled', true);
        }
    } else {
        disabled();
        $('#btnActualizar').prop('disabled', true);
        $('#btnEliminar').prop('disabled', true);
        $('#chkActivo').prop('checked', false);
    }
    $('#txtNombre').focus();
    $('#txtIdCliente').val(data[0]);
    $('#txtNombre').val(data[1]);
    $('#txtPaterno').val(data[2]);
    $('#txtMaterno').val(data[3]);
    $('#txtCalle').val(data[4]);
    $('#txtNoExterior').val(data[5]);
    $('#txtNoInterior').val((data[6] == 'NULL') ? 'S/N' : data[6]);
    $('#txtIdCp').val(data[7]);
    $('#txtColonia').val(data[8]);
    $('#txtCp').val(data[9]);
    $('#thTitleMuni').empty('');
    $('#tdMuni').empty('');
    var th;
    var td;
    if (data[10] != '') {
        th = '<label class="font-size"><span class="req">*</span> Delegaci&oacute;n</label> ';
        td = '<td><input type="text" id="txtDelegacion" name="txtDelegacion" class="required form-control" value="'
                + data[10] + '" readOnly="readOnly" /></td>';
    } else if (data[11] != '') {
        th = '<label class="font-size"><span class="req">*</span> Munic&iacute;pio</label> ';
        td = '<td><input type="text" id="txtMunicipio" name="txtMunicipio" class="required form-control" value="'
                + data[11] + '" readOnly="readOnly" /></td>';
    }
    $('#thTitleMuni').append(th);
    $('#tdMuni').append(td);
    $('#txtEstado').val(data[12]);
    $('#txtCiudad').val(data[13]);
    $('#txtTelefono').val(data[14]);
    $('#txtOtroTelefono').val((data[15] == 'NULL') ? 'S/N' : data[15]);
    $('#txtMail').val(data[16]);
    $('#txtGiro').val(data[17]);
    if (data[18] == true) {
        $('#chkActivo').prop('checked', true);
        $('#btnActivate').hide();
        $('#btnEliminar').show();
    } else {
        $('#chkActivo').prop('checked', false);
        $('#btnActivate').show();
        $('#btnEliminar').hide();
    }
    $('#btnRegistrar').prop('disabled', true);
    complete();
    btns();
}

function enabled() {
    $('#txtNombre').prop('readonly', false);
    $('#txtPaterno').prop('readonly', false);
    $('#txtMaterno').prop('readonly', false);
    $('#txtCalle').prop('readonly', false);
    $('#txtNoExterior').prop('readonly', false);
    $('#txtNoInterior').prop('readonly', false);
    $('#txtColonia').prop('readonly', false);
    $('#txtCp').prop('readonly', false);
    $('#txtTelefono').prop('readonly', false);
    $('#txtOtroTelefono').prop('readonly', false);
    $('#txtMail').prop('readonly', false);
    $('#txtGiro').prop('readonly', false);
}
function disabled() {
    $('#txtNombre').prop('readonly', true);
    $('#txtPaterno').prop('readonly', true);
    $('#txtMaterno').prop('readonly', true);
    $('#txtCalle').prop('readonly', true);
    $('#txtNoExterior').prop('readonly', true);
    $('#txtNoInterior').prop('readonly', true);
    $('#txtColonia').prop('readonly', true);
    $('#txtCp').prop('readonly', true);
    $('#txtTelefono').prop('readonly', true);
    $('#txtOtroTelefono').prop('readonly', true);
    $('#txtMail').prop('readonly', true);
    $('#txtGiro').prop('readonly', true);
}

function clear(size) {
    for (var indx = 0; indx < size; indx++) {
        $('#trIntIndx' + indx).remove();
    }
}

