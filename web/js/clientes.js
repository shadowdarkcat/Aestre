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

    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    var table = $('#tblClientes').DataTable({
        language: {
            url: contextoGlobal + '/web/resources/es_ES.json'
        }
    });

    $('#tblClientes tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            showData();
        }
    });
    $(function () {
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
    });

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


});
function showData() {
    $('#txtIdCliente').val($('.selected').find('#lblId').text());
    $('#txtNombre').val($('.selected').find('#lblNombre').text());
    $('#txtPaterno').val($('.selected').find('#lblPaterno').text());
    $('#txtMaterno').val($('.selected').find('#lblMaterno').text());
    if ($('.selected').find('#lblActivo').text() == 'Sí') {
        $('#chkActivo').prop('checked', true);
        $('#btnActivate').hide();
        $('#btnEliminar').show();        
    } else {
        $('#chkActivo').prop('checked', false);
        $('#btnActivate').show();
        $('#btnEliminar').hide();
    }
    $('#txtCalle').val($('.selected').find('#lblCalle').text());
    $('#txtNoExterior').val($('.selected').find('#lblNoExt').text());
    $('#txtNoInterior').val(($('.selected').find('#lblNoInt').text() == 'NULL') ? 'S/N' : $('.selected').find('#lblNoInt').text());
    for (var index = 0; index < availableTags.length; index++) {
        var split = [];
        split = availableTags[index].split(',');
        if (split[0] == $('.selected').find('#lblIdCp').text()) {
            $('#thTitleMuni').empty('');
            $('#tdMuni').empty('');
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
            $('#txtColonia').val(split[1]);
            break;
        }
        $('#txtTelefono').val($('.selected').find('#lblTelefono').text());
        $('#txtOtroTelefono').val(($('.selected').find('#lblOtroTelefono').text() == 'NULL') ? 'S/N' : $('.selected').find('#lblOtroTelefono').text());
        $('#txtMail').val($('.selected').find('#lblMail').text());
        $('#cboGiro').val($('.selected').find('#lblIdGiro').text());
        $('#btnRegistrar').prop('disabled', true);
        $('#btnActualizar').prop('disabled', false);
        $('#btnEliminar').prop('disabled', false);
    }
}