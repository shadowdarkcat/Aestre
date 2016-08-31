$(document).ready(function () {
    changeErrorMessage('frmCliente');
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
        }
    });
    $(function () {
        $('#txtColonia').autocomplete({
            source: availableTags
            , select: function (event, data) {
                $('#delegacionMunicipio').empty('');
                var split = [];
                var td;
                if (data.item) {
                    split = data.item.value.split(',');
                }
                if (split[2] != '') {
                    td = '<td class="dt-responsive form-control"><label class="text-muted"><span class="req">*</span>Delegaci&oacute;n:</span></td>'
                            + '<td><input type="text" id="txtDelegacion" name="txtDelegacion" class="required form-control" value="'
                            + split[2] + '" readOnly="readOnly" /></td>';
                } else if (split[3] != '') {
                    td = '<td class="dt-responsive form-control"><label class="text-muted"><span class="req">*</span>Municipio:</span></td>'
                            + '<td><input type="text" id="txtMunicipio" name="txtMunicipio" class="required form-control" value="'
                            + split[3] + '" readOnly="readOnly" /></td>';
                }
                $('#txtCp').val(split[4]);
                $('#txtEstado').val(split[5]);
                $('#txtCiudad').val(split[6]);
                $('#delegacionMunicipio').append(td);
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
                if (split[2] != '') {
                    td = '<td><span class="text-muted" >*Delegaci&oacute;n :</span></td>'
                            + '<td><input type="text" id="txtDelegacion" name="txtDelegacion" class="required form-control" value="'
                            + split[2] + '" readOnly="readOnly" /></td>';
                } else if (split[3] != '') {
                    td = '<td><span class="text-muted" >*Municipio :</span></td>'
                            + '<td><input type="text" id="txtMunicipio" name="txtMunicipio" class="required form-control" value="'
                            + split[3] + '" readOnly="readOnly" /></td>';
                }
                $('#txtCp').val(split[4]);
                $('#txtEstado').val(split[5]);
                $('#txtCiudad').val(split[6]);
                $('#delegacionMunicipio').append(td);
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
});

