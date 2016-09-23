var clicks = 0;
var color;
var path = [];

$(document).ready(function () {
    $('#listVehiculos').animate({height: 'toggle'});
    $('#lblTittleListV').text("Mostrar Lista Vehiculos");

    $(function () {
        $('#foot').append('<tr><td  style="text-align: center">'
                + '<button type="button" class="btn" '
                + 'onclick="showNew();">'
                + '<img src="../web/images/nuevo.png" >Nuevo</button>'
                + '</td>'
                + '</tr>'
                + '<tr id="trIndxFoot0"></tr>');
    });

    $('#tblVehiculosMap').DataTable({
        "pagingType": "simple",
        "ordering": false,
        'displayLength': 2,
        language: {
            url: contextoGlobal + '/web/resources/es_ES.json'
        }
    });
    $('#tblGeozonas').DataTable({
        "pagingType": "simple",
        language: {
            url: contextoGlobal + '/web/resources/es_ES.json'
        }
    });

    $('#btnListVehiculos').on('click', function () {
        $('#listVehiculos').animate({height: 'toggle'});
        if (clicks % 2) {
            $('#lblTittleListV').text("Mostrar Lista Vehiculos");
        } else {
            $('#lblTittleListV').text("Ocultar Lista Vehiculos");
        }
        clicks += 1;
    });

    dtp = function () {
        $('#dtpDesde').datepicker({
            beforeShow: function () {
                $(".ui-datepicker").css('font-size', 12)
            }
            , maxDate: '+0d'
        });
        $('#dtpHasta').datepicker({
            beforeShow: function () {
                $(".ui-datepicker").css('font-size', 12)
            }
            , maxDate: '+0d'
        });
    }

    $('#btnGeoZona').on('click', function () {
        window.clearInterval(inter);
        $('#divMap').empty();
        $('#divMap').append($('#divZonas').html());
        onloadAllMini();
    });

    other = function () {
        changeErrorMessage('frmGeoZona');
        $('#colorPicker').on('change', function () {
            color = '#' + $('#colorPicker').val();
            crearZona();
        });
        
        $('#btnRegistrar').on('click', function () {
            $('#frmGeoZona').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/geozonaController.php?&method=1');
            if ($('#frmGeoZona').validate().form()) {
                $('#frmGeoZona').submit();
            }
        });
        $('#btnActualizar').on('click', function () {
            if ($('#frmGeoZona').validate().form()) {
                $('#frmGeoZona').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/geozonaController.php?method=2');
                $('#divMessageUpdate').modal('show');
            }
        });
        $('#btnUpdate').on('click', function () {
            $('#frmGeoZona').submit();
        });
        $('#btnEliminar').on('click', function () {
            $('#chkActivo').prop('checked', false);
            if ($('#frmGeoZona').validate().form()) {
                $('#frmGeoZona').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/geozonaController.php?method=3');
                $('#divMessageDelete').modal('show');
            }
        });
        $('#btnDelete').on('click', function () {
            $('#frmGeoZona').submit();
        });
        $('#btnActivate').on('click', function () {
            $('#chkActivo').prop('checked', true);
            if ($('#frmGeoZona').validate().form()) {
                $('#frmGeoZona').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/geozonaController.php?method=3');
                $('#divActivar').modal('show');
            }
        });
        $('#btnAceptarActivar').on('click', function () {
            $('#frmGeoZona').submit();
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

function showRuta(index, imei) {
    clear(size);
    var tbl = '<fieldset><legend class="text-muted alert-info">Ruta Recorrida</legend>'
            + '<input type="hidden" id="txtImei" name="txtImei" value="' + imei + '" />'
            + '<table>'
            + '<tr> '
            + '<th style="vertical-align: middle; font-size: 12px;"><span class="req"> * </span>Desde:</th>'
            + '<td><input type="text" id="dtpDesde" style="font-size: 12px;" size="10" class="required form-control col-xs-1 input-sm"'
            + 'placeholder ="Fecha Inicial" readonly="readOnly">'
            + '<label id="errorDesde" class="form-control alert-danger font-size" style="display: none;">Campo Requerido</label>'
            + '<select id="cboHrInicial" name="cboHrInicial" class="form-control col-xs-1 input-sm"></select>'
            + '</td>'
            + '</tr>'
            + '<tr>'
            + '<th style="vertical-align: middle; font-size: 12px;">Hasta:</th>                                            '
            + '<td><input type="text" id="dtpHasta" style="font-size: 12px;" size="10" class="required form-control col-xs-1 input-sm"'
            + 'placeholder ="Fecha Final" readonly="readOnly">'
            + '<select id="cboHrFinal" name="cboHrFinal" class="form-control col-xs-1 input-sm"></select>'
            + '</td>'
            + '</tr>'
            + '<tr><td colspan="2">'
            + '<button type="button" class="btn" id="btnRuta" name="btnRuta" onClick="getHistorial();">'
            + '<img src="../web/images/ruta.png">Generar Ruta</button>'
            + '<button type = "button" class="btn" id = "btnCancel" name = "btnCancel" onClick="cerrar();">'
            + '<img src = "../web/images/cancel.png" > Cerrar </button>'
            + '</td></tr>'
            + '</table></fieldset>'
            ;
    $('#trIndx' + index).before(
            '<tr id="trIntIndx' + index + '"><td colspan="6">' + tbl + '</td></tr>');
    cboTime();
    dtp();
}

function cerrar() {
    clear(size);
    $('#rdbHistorial').prop('checked', false);
    intervals();
}

function clear(size) {
    for (var indx = 0; indx < size; indx++) {
        $('#trIntIndx' + indx).remove();
    }
}

function cboTime() {
    var option = '';
    for (var i = 1; i < 25; i++) {
        if (i == 24) {
            option += '<option value ="00:00:00">' + i + ':00</option>';
        } else {
            option += '<option value ="' + i + ':00:00">' + i + ':00</option>';
        }
    }
    $('#cboHrInicial').append('<option value ="">Hora Inicial</option>' + option);
    $('#cboHrFinal').append('<option value ="">Hora Final</option>' + option);
}

function showNew() {
    clear(size);
    $('#trIndxFoot0').append('<td colspan="5">' + getFormGeozona() + '</td></tr>');
    $('#txtNombre').focus();
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    geoMap();
    other();
}