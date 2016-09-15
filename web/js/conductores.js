$(document).ready(function () {
    $('#divMessageUpdate').find('#lblTittleUpdate').empty();
    $('#divMessageDelete').find('#lblTittleDelete').empty();
    $('#divActivar').find('#lblTittleActivar').empty();
    $('#divExiste').find('#lblTittleExists').empty();
    $('#divMessageUpdate').find('#lblTittleUpdate').text('Conductor');
    $('#divMessageDelete').find('#lblTittleDelete').text('Conductor');
    $('#divActivar').find('#lblTittleActivar').text('Conductor');
    $('#divExiste').find('#lblTittleExists').text('Conductor');

    $('#tblConductores').DataTable({
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
        changeErrorMessage('frmConductor');
        $('#btnRegistrar').on('click', function () {
            $('#frmConductor').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/conductorController.php?&method=1');
            if ($('#frmConductor').validate().form()) {
                $('#frmConductor').submit();
            }
        });
        $('#btnActualizar').on('click', function () {
            if ($('#frmConductor').validate().form()) {
                $('#frmConductor').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/conductorController.php?method=2');
                $('#divMessageUpdate').modal('show');
            }
        });
        $('#btnUpdate').on('click', function () {
            $('#frmConductor').submit();
        });
        $('#btnEliminar').on('click', function () {
            $('#chkActivo').prop('checked', false);
            if ($('#frmConductor').validate().form()) {
                $('#frmConductor').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/conductorController.php?method=3');
                $('#divMessageDelete').modal('show');
            }
        });
        $('#btnDelete').on('click', function () {
            $('#frmConductor').submit();
        });
        $('#btnActivate').on('click', function () {
            $('#chkActivo').prop('checked', true);
            if ($('#frmConductor').validate().form()) {
                $('#frmConductor').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/conductorController.php?method=3');
                $('#divActivar').modal('show');
            }
        });
        $('#btnAceptarActivar').on('click', function () {
            $('#frmConductor').submit();
        });
        $('#btnCancel').on('click', function () {
            $('#divMessageCancel').modal('show');
        });
        $('#btnAceptarCerrar').on('click', function () {
            clear(size);
            $('#trIndxFoot0').empty();
        });
    }
});

function showNew() {
    clear(size);
    $('#trIndxFoot0').append('<td colspan="5">' + getFormConductor() + '</td></tr>');
    $('#txtNombre').focus();
    $('#cboLicencia').append(cboLicencia);
    $('#cboVehiculo').append(cboVehiculo);
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    complete();
    btns();
}
function showData(index, action) {
    var data = conductores[index].split(',');
    clear(size);
    $('#trIndxFoot0').empty();
    $('#trIndx' + index).before('<tr id="trIntIndx' + index + '"><td colspan="5">' + getFormConductor() + '</td></tr>');
    $('#cboLicencia').append(cboLicencia);
    $('#cboVehiculo').append(cboVehiculo);
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    if (data[21] == true) {
        if (action == 0) {
            enabled();
            $('#frmConductor').find('#btnActualizar').prop('disabled', false);
            $('#frmConductor').find('#btnEliminar').prop('disabled', true);
        } else {
            disabled();
            $('#frmConductor').find('#btnEliminar').prop('disabled', false);
            $('#frmConductor').find('#btnActualizar').prop('disabled', true);
        }
    } else {
        disabled();
        $('#btnActualizar').prop('disabled', true);
        $('#btnEliminar').prop('disabled', true);
        $('#chkActivo').prop('checked', false);
    }
    $('#txtIdConductor').val(data[0]);
    $('#txtNombre').val(data[1]);
    $('#txtPaterno').val(data[2]);
    $('#txtMaterno').val(data[3]);
    $('#txtTelefono').val(data[4]);
    $('#txtOtroTelefono').val((data[5] == 'NULL') ? 'S/N' : data[5]);
    $('#txtMail').val(data[6]);
    $('#txtCalle').val(data[7]);
    $('#txtNoExterior').val(data[8]);
    $('#txtNoInterior').val((data[9] == 'NULL') ? 'S/N' : data[9]);
    $('#txtIdCp').val(data[10]);
    $('#txtColonia').val(data[11]);
    $('#txtCp').val(data[12]);
    $('#thTitleMuni').empty('');
    $('#tdMuni').empty('');
    var th;
    var td;
    if (data[13] != '') {
        th = '<label class="font-size"><span class="req">*</span> Delegaci&oacute;n</label> ';
        td = '<td><input type="text" id="txtDelegacion" name="txtDelegacion" class="required form-control" value="'
                + data[13] + '" readOnly="readOnly" /></td>';
    } else if (data[14] != '') {
        th = '<label class="font-size"><span class="req">*</span> Munic&iacute;pio</label> ';
        td = '<td><input type="text" id="txtMunicipio" name="txtMunicipio" class="required form-control" value="'
                + data[14] + '" readOnly="readOnly" /></td>';
    }
    $('#thTitleMuni').append(th);
    $('#tdMuni').append(td);
    $('#txtEstado').val(data[15]);
    $('#txtCiudad').val(data[16]);
    $('#txtNoLicencia').val(data[17]);
    $('#txtVigencia').val(data[18]);
    $('#cboLicencia').val(data[19]);
    $('#cboVehiculo').val(data[20]);
    if (data[21] == true) {
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
    $('#txtTelefono').prop('readonly', false);
    $('#txtOtroTelefono').prop('readonly', false);
    $('#txtMail').prop('readonly', false);
    $('#txtCalle').prop('readonly', false);
    $('#txtNoExterior').prop('readonly', false);
    $('#txtNoInterior').prop('readonly', false);
    $('#txtIdCp').prop('readonly', false);
    $('#txtColonia').prop('readonly', false);
    $('#txtCp').prop('readonly', false);
    $('#txtEstado').prop('readonly', false);
    $('#txtCiudad').prop('readonly', false);
    $('#txtNoLicencia').prop('readonly', false);
    $('#txtVigencia').prop('readonly', false);
}
function disabled() {
    $('#txtNombre').prop('readonly', true);
    $('#txtPaterno').prop('readonly', true);
    $('#txtMaterno').prop('readonly', true);
    $('#txtTelefono').prop('readonly', true);
    $('#txtOtroTelefono').prop('readonly', true);
    $('#txtMail').prop('readonly', true);
    $('#txtCalle').prop('readonly', true);
    $('#txtNoExterior').prop('readonly', true);
    $('#txtNoInterior').prop('readonly', true);
    $('#txtIdCp').prop('readonly', true);
    $('#txtColonia').prop('readonly', true);
    $('#txtCp').prop('readonly', true);
    $('#txtEstado').prop('readonly', true);
    $('#txtCiudad').prop('readonly', true);
    $('#txtNoLicencia').prop('readonly', true);
    $('#txtVigencia').prop('readonly', true);
}

function clear(size) {
    for (var indx = 0; indx < size; indx++) {
        $('#trIntIndx' + indx).remove();
    }
}