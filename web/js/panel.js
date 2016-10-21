var clicks = 0;
var color;
var path = [];
var globalIndexDelete = '';
var listVehiculos = [];

$(document).ready(function () {
    $('#listVehiculos').animate({height: 'toggle'});
    $('#lblTittleListV').text("Mostrar Lista Vehiculos");

    colonia = function () {
        $('#txtColonia').autocomplete({
            source: availableTags
            , select: function (event, data) {
                var split = [];
                if (data.item) {
                    split = data.item.value.split(",");
                }
                search(split[1]);
                $('#errorGeocoder').hide();
                return false;
            }
        }).keypress(function (e, data) {
            if (e.which == 13) {
                var split = [];
                if (data.item) {
                    split = data.item.value.split(",");
                }
                search(split[1]);
                $('#errorGeocoder').hide();
                return false;
            }
        });
    };

    $(function () {
        $('#divZonas').find('#foot').append('<tr><td  style="text-align: center">'
                + '<button type="button" class="btn" '
                + 'onclick="showNew();">'
                + '<img src="../web/images/nuevo.png" >Nuevo</button>'
                + '</td>'
                + '<td  style="text-align: center">'
                + '<button type="button" class="btn" '
                + 'onclick="onloadAll();">'
                + '<img src="../web/images/cancel.png" >Cerrar</button>'
                + '</td>'
                + '</tr>'
                + '<tr id="trIndxFoot0"></tr>');
        $('#divRutas').find('#foot').append('<tr><td  style="text-align: center">'
                + '<button type="button" class="btn" '
                + 'onclick="showNewRuta();">'
                + '<img src="../web/images/nuevo.png" >Nuevo</button>'
                + '</td>'
                + '<td  style="text-align: center">'
                + '<button type="button" class="btn" '
                + 'onclick="onloadAll();">'
                + '<img src="../web/images/cancel.png" >Cerrar</button>'
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

    $('#tblGeorutas').DataTable({
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
    };

    $('#btnGeoZona').on('click', function () {
        window.clearInterval(inter);
        $('#divMap').empty();
        $('#divMap').append($('#divZonas').html());
        onloadAllMini();
    });

    $('#btnGeoRuta').on('click', function () {
        window.clearInterval(inter);
        $('#divMap').empty();
        $('#divMap').append($('#divRutas').html());
        onloadAllMini();
    });

    otherZone = function () {
        changeErrorMessage('frmGeoZona');
        $('#colorPicker').on('change', function () {
            color = '#' + $('#colorPicker').val();
            crearZona();
        });

        $('#btnRegistrar').on('click', function () {
            if ($('#frmGeoZona').validate().form()) {
                enviarGz(1);
            }
        });

        $('#btnActualizar').on('click', function () {
            $('#lblTittleUpdate').text('Modificar Geozona');
            if ($('#frmGeoZona').validate().form()) {
                $('#divMessageUpdate').modal('show');
            }
        });
        $('#btnUpdate').on('click', function () {
            enviarGz(2);
        });

        $('#btnCancel').on('click', function () {
            $('#divMessageCancel').modal('show');
        });
        $('#btnAceptarCerrar').on('click', function () {
            clearPanel();
            ;
            $('#trIndxFoot0').empty();
        });

        $('#btnEliminar').on('click', function () {
            $('#divMessageEliminarZona').modal('show');
        });

        $('#btnDeleteGeozona').on('click', function () {
            enviarGz(3);
            $('#trMapIndx' + globalIndexDelete);
        });

        $('#btnAsociar').on('click', function () {
            $('#lblTittleUpdate').text('Modificar Geozona');
            if ($('#frmGeoZona').validate().form()) {
                $('#divMessageAsociar').modal('show');
            }
        });
        $('#btnAceptarAsociar').on('click', function () {
            $('#divMessageAsociar').modal('hide');
            enviarGz(5);
        });

        $('#btnCancel').on('click', function () {
            $('#divMessageCancel').modal('show');
        });
        $('#btnAceptarCerrar').on('click', function () {
            clearPanel();
            ;
            $('#trIndxFoot0').empty();
        });

        $('#cboVehiculos').multiselect();
    };

    otherRute = function () {
        changeErrorMessage('frmGeoRuta');
        $('#colorPicker').on('change', function () {
            color = '#' + $('#colorPicker').val();
            setColor(color);
        });

        $('#btnRegistrarRuta').on('click', function () {
            if ($('#frmGeoRuta').validate().form()) {
                enviarRuta(1);
            }
        });

        $('#btnActualizarRuta').on('click', function () {
            $('#lblTittleUpdate').text('Modificar Georuta');
            if ($('#frmGeoRuta').validate().form()) {
                $('#divMessageUpdate').modal('show');
            }
        });
        $('#btnUpdate').on('click', function () {
            enviarRuta(2);
        });

        $('#btnEliminarRuta').on('click', function () {
            $('#divMessageEliminarRuta').modal('show');
        });

        $('#btnDeleteGeoruta').on('click', function () {
            enviarRuta(3);
            $('#trMapIndx' + globalIndexDelete);
        });

        $('#btnAsociarRuta').on('click', function () {
            $('#lblTittleUpdate').text('Modificar Georuta');
            if ($('#frmGeoRuta').validate().form()) {
                $('#divMessageAsociarRuta').modal('show');
            }
        });
        $('#btnAceptarAsociarRuta').on('click', function () {
            $('#divMessageAsociarRuta').modal('hide');
            enviarRuta(5);
        });

        $('#btnCancelRuta').on('click', function () {
            $('#divMessageCancel').modal('show');
        });
        $('#btnAceptarCerrar').on('click', function () {
            clearPanel();
            ;
            $('#trIndxFoot0').empty();
        });
        $('#cboVehiculos').multiselect();
    };
});

function showRuta(index, imei) {
    clearPanel();
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

function showReporte(index) {
    clearPanel();
    var str = JSON.stringify(lstVehiculo[index]);
    var res = str.split('"').join("'");
    var tbl = '<fieldset><legend class="text-muted alert-info">Reporte</legend>'
            //+ '<form id="frmJson" name="frmJson" method="post" action="http://199.89.55.7:8084/Reporteador/controller/reporteadorController" target="_blank">'
            + '<form id="frmJson" name="frmJson" method="post" action="http://localhost:8084/Reporteador/controller/reporteadorController" target="_blank">'
            + '<table>'
            + '<tr> '
            + '<th style="vertical-align: middle; font-size: 12px;"><span class="req"> * </span>Desde:</th>'
            + '<td><input type="text" id="dtpDesde" name="dtpDesde" style="font-size: 12px;" size="10" class="required form-control col-xs-1 input-sm"'
            + 'placeholder ="Fecha Inicial" readonly="readOnly">'
            + '<label id="errorDesde" class="form-control alert-danger font-size" style="display: none;">Campo Requerido</label>'
            + '<select id="cboHrInicial" name="cboHrInicial" class="form-control col-xs-1 input-sm"></select>'
            + '</td>'
            + '</tr>'
            + '<tr>'
            + '<th style="vertical-align: middle; font-size: 12px;">Hasta:</th>                                            '
            + '<td><input type="text" id="dtpHasta" name="dtpHasta" style="font-size: 12px;" size="10" class="form-control col-xs-1 input-sm"'
            + 'placeholder ="Fecha Final" readonly="readOnly">'
            + '<select id="cboHrFinal" name="cboHrFinal" class="form-control col-xs-1 input-sm"></select>'
            + '</td>'
            + '</tr>'
            + '<tr>'
            + '<td><input type="radio" id="rdbReporte" name="rdbReporte" value="pdf"><label class="font-size" style="vertical-align: middle;">PDF</label>'
            + '<input type="radio" id="rdbReporte" name="rdbReporte" value="xls"><label class="font-size" style="vertical-align: middle;">Excel</label>'
            + '<input type="radio" id="rdbReporte" name="rdbReporte" value="html"><label class="font-size" style="vertical-align: middle;">Html</label>'
            + '<br/><label id="lblErrorRadio" class="font-size alert-danger" style="display:none;">Campo obligatorio.</label>'
            + '</td></tr>'
            + '<tr><td colspan="2">'
            + '<button type="button" class="btn" id="btnRuta" name="btnRuta" onClick="getReporte();">'
            + '<img src="../web/images/reporte.png">Generar Reporte</button>'
            + '<button type = "button" class="btn" id = "btnCancel" name = "btnCancel" onClick="cerrar();">'
            + '<img src = "../web/images/cancel.png" > Cerrar </button>'
            + '<input type="hidden" id="txtJson" name="txtJson" value="' + res + '"/>'
            + '<input type="hidden" id="txtNombreReporte" name="txtNombreReporte" value="' + lstVehiculo[index].modelo + ' ' + lstVehiculo[index].placa + '"/>'
            + '</td></tr>'
            + '</table></fieldset>'
            ;
    $('#trIndx' + index).before(
            '<tr id="trIntIndx' + index + '"><td colspan="6">' + tbl + '</td></tr>');
    cboTime();
    dtp();
}

function cerrar() {
    clearPanel();
    $('#rdbHistorial').prop('checked', false);
    intervals();
}

function clearPanel() {

    for (var indx = 0; indx < totalSize; indx++) {

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
    clearPanel();
    ;
    $('#trIndxFoot0').append('<td colspan="5">' + getFormGeozona() + '</td></tr>');
    addColor();
    $('#btnAsociar').prop('disabled', 'disabled');
    $('#txtNombre').focus();
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    $('#cboVehiculos').multiselect();
    geoMap();
    otherZone();
}

function showNewRuta() {
    clearPanel();
    ;
    $('#trIndxFoot0').append('<td colspan="5">' + getFormGeoruta() + '</td></tr>');
    addColor();
    colonia();
    $('#btnAsociarRuta').prop('disabled', 'disabled');
    $('#txtNombre').focus();
    $('#btnActualizarRuta').prop('disabled', true);
    $('#btnEliminarRuta').prop('disabled', true);
    $('#cboVehiculos').multiselect();
    ruteMap();
    otherRute();
}

function showDataZona(index, action) {
    globalIndexDelete = index;
    clearPanel();
    ;
    $('#lblT').empty();
    $('#trIndxFoot0').empty();
    if (action == 0) {
        $('#trMapIndx' + index).before('<tr id="trIntMapIndx' + index + '"><td colspan="5">' + getFormGeozonaUpdate() + '</td></tr>');
        $('#lblT').text('Mapa Creaci&oacute;n Geozona');
        $('#btnRegistrar').prop('disabled', 'disabled');
        $('#btnEliminar').prop('disabled', 'disabled');
        $('#btnAsociar').prop('disabled', 'disabled');
        $('#cboVehiculos').multiselect('disable');
        addColor();
        lastMap(index);
    } else if (action == 1) {
        $('#trMapIndx' + index).before('<tr id="trIntMapIndx' + index + '"><td colspan="5">' + getFormGeozona() + '</td></tr>');
        $('#lblT').text('Mapa Eliminar Geozona');
        deleteMap(index);
        addColor();
        $('#txtZona').prop('disabled', 'disabled');
        $('#colorPicker').prop('disabled', 'disabled');
        $('#btnRegistrar').prop('disabled', 'disabled');
        $('#btnActualizar').prop('disabled', 'disabled');
        $('#btnAsociar').prop('disabled', 'disabled');
        $('#cboVehiculos').multiselect('disable');
    } else {
        $('#trMapIndx' + index).before('<tr id="trIntMapIndx' + index + '"><td colspan="5">' + getFormGeozona() + '</td></tr>');
        $('#lblT').text('Asociar vehículos - Geozona');
        asociarMap(index);
        addColor();
        $('#txtZona').prop('disabled', 'disabled');
        $('#colorPicker').prop('disabled', 'disabled');
        $('#btnRegistrar').prop('disabled', 'disabled');
        $('#btnActualizar').prop('disabled', 'disabled');
        $('#btnEliminar').prop('disabled', 'disabled');
    }
}

function showDataRuta(index, action) {
    globalIndexDelete = index;
    clearPanel();
    ;
    $('#lblT').empty();
    $('#trIndxFoot0').empty();
    if (action == 0) {
        $('#trMapIndx' + index).before('<tr id="trIntMapIndx' + index + '"><td colspan="5">' + getFormGeorutaUpdate() + '</td></tr>');
        $('#lblT').text('Mapa Creaci&oacute;n Georuta');
        addColor();
        colonia();
        lastMapRuta(index);
        $('#btnRegistrarRuta').prop('disabled', 'disabled');
        $('#btnEliminarRuta').prop('disabled', 'disabled');
        $('#btnAsociarRuta').prop('disabled', 'disabled');
    } else if (action == 1) {
        $('#trMapIndx' + index).before('<tr id="trIntMapIndx' + index + '"><td colspan="5">' + getFormGeoruta() + '</td></tr>');
        $('#lblT').text('Mapa Eliminar Georuta');
        deleteMapRuta(index);
        addColor();
        $('#txtColonia').prop('disabled', 'disabled');
        $('#txtRuta').prop('disabled', 'disabled');
        $('#colorPicker').prop('disabled', 'disabled');
        $('#btnRegistrarRuta').prop('disabled', 'disabled');
        $('#btnActualizarRuta').prop('disabled', 'disabled');
        $('#btnAsociarRuta').prop('disabled', 'disabled');
        $('#cboVehiculos').multiselect('disable');
    } else {
        $('#trMapIndx' + index).before('<tr id="trIntMapIndx' + index + '"><td colspan="5">' + getFormGeoruta() + '</td></tr>');
        $('#lblT').text('Asociar vehículos - Georuta');
        asociarMapRuta(index);
        addColor();
        $('#txtColonia').prop('disabled', 'disabled');
        $('#txtRuta').prop('disabled', 'disabled');
        $('#colorPicker').prop('disabled', 'disabled');
        $('#btnRegistrarRuta').prop('disabled', 'disabled');
        $('#btnActualizarRuta').prop('disabled', 'disabled');
        $('#btnEliminarRuta').prop('disabled', 'disabled');
    }
    otherRute();
}

function listVehiculo() {
    var data = {'method': 0};
    $.getJSON(contextoGlobal + '/com/aestre/system/controller/vehiculoController.php'
            , data, function (response) {
                $.each(response, function (index, item) {
                    listVehiculos.push('<option value = "' + item.id + '">' + item.modelo + ' ' + item.placa + '</option>');
                });
            }
    );
}

function getReporte() {
    changeErrorMessage('frmJson');
    if ($('#frmJson').validate().form() && $("input[name='rdbReporte']").is(':checked')) {
        $('#lblErrorRadio').hide();
        $('#frmJson').submit();
    } else {
        if ($("input[name='rdbReporte']").is(':checked')) {
            $('#lblErrorRadio').hide();
        } else {
            $('#lblErrorRadio').show();
        }
    }
}