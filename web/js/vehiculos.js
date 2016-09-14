$(document).ready(function () {
    $('.carousel').carousel();
    changeErrorMessage('frmVehiculo');
    $('#divMessageUpdate').find('#lblTittleUpdate').empty();
    $('#divMessageDelete').find('#lblTittleDelete').empty();
    $('#divActivar').find('#lblTittleActivar').empty();
    $('#divExiste').find('#lblTittleExists').empty();
    $('#divMessageUpdate').find('#lblTittleUpdate').text('Veh&iacute;culo');
    $('#divMessageDelete').find('#lblTittleDelete').text('Veh&iacute;culo');
    $('#divActivar').find('#lblTittleActivar').text('Veh&iacute;culo');
    $('#divExiste').find('#lblTittleExists').text('Veh&iacute;culo');
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    $('#dtpVerificacion').datepicker({
        beforeShow: function () {
            $(".ui-datepicker").css('font-size', 12)
        }
        , maxDate: '+0d'
    });

    $('#tblVehiculos').DataTable({
        responsive: true,
        'bAutoWidth': false,
        'columnDefs': [
            {className: 'never', 'visible': false, 'targets': 0}, {'sortable': false, 'targets': 1}, {'sortable': false, 'targets': 2}, {'sortable': false, 'targets': 3}, {'sortable': false, 'targets': 4}
            , {'sortable': false, 'targets': 5}, {'sortable': false, 'targets': 6}, {'sortable': false, 'targets': 7}
        ],
        'order': [[1, 'asc']],
        'displayLength': 1,
        'drawCallback': function (settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;
            api.column(0, {page: 'current'}).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                            '<tr class="group"><td class="hidden - element"></td><td class="font-size" colspan="7"><strong>'
                            + group + '</strong></td></tr>'
                            );

                    last = group;
                }
            });
        }
        , language: {
            url: contextoGlobal + '/web/resources/es_ES.json'
        }
        , 'ordering': false
        , 'info': false
    });
    $('#btnRegistrar').on('click', function () {
        $('#frmVehiculo').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/vehiculoController.php?&method=1');
        if ($('#frmVehiculo').validate().form()) {
            $('#frmVehiculo').submit();
        }
    });
    
    $('#btnActualizar').on('click', function () {
        if ($('#frmVehiculo').validate().form()) {
            $('#frmVehiculo').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/vehiculoController.php?method=2');
            $('#divMessageUpdate').modal('show');
        }
    });
    $('#btnUpdate').on('click', function () {
        $('#frmVehiculo').submit();
    });
    $('#btnEliminar').on('click', function () {
        $('#chkActivo').prop('checked', false);
        $('#lblActivo').text('No');
        if ($('#frmVehiculo').validate().form()) {
            $('#frmVehiculo').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/vehiculoController.php?method=3');
            $('#divMessageDelete').modal('show');
        }
    });
    $('#btnDelete').on('click', function () {
        $('#frmVehiculo').submit();
    });
    $('#btnActivate').on('click', function () {
        $('#chkActivo').prop('checked', true);
        $('#lblActivo').text('Sí');
        if ($('#frmVehiculo').validate().form()) {
            $('#frmVehiculo').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/vehiculoController.php?method=3');
            $('#divActivar').modal('show');
        }
    });
    $('#btnAceptarActivar').on('click', function () {
        $('#frmVehiculo').submit();
    });
});

function show() {
    if ($('#chkIcon').is(':checked')) {
        $('#frmVehiculo').find('#divIcons').show();
    } else {
        $('#carousel-example-generic').carousel('cycle');
        $('#frmVehiculo').find('#txtIdImage').val('100000');
        $('#frmVehiculo').find('#divIcons').hide();
    }
}

function icon(idIcon) {
    if ((idIcon != null) && (idIcon != undefined)) {
        $('#carousel').carousel('pause');
        $('#frmVehiculo').find('#txtIdImage').val(idIcon);
    }
}

function iconChange(idIcon) {
    if ((idIcon != null) && (idIcon != undefined)) {
        $('#carousel').carousel('pause');
        $('#frmVehiculo').find('#txtIdImage').val(idIcon);
    }
}

function showData(index, action) {
    var data = vehiculos[index].split(',');
    if (data[12] == true) {
        if (action == 0) {
            enabled();
            $('#frmVehiculo').find('#btnActualizar').prop('disabled', false);
            $('#frmVehiculo').find('#btnEliminar').prop('disabled', true);
        } else {
            disabled();
            $('#frmVehiculo').find('#btnEliminar').prop('disabled', false);
            $('#frmVehiculo').find('#btnActualizar').prop('disabled', true);
        }
    } else {
        disabled();
        $('#btnActualizar').prop('disabled', true);
        $('#btnEliminar').prop('disabled', true);
        $('#chkActivo').prop('checked', false);        
    }
    $('#cboCliente').val(data[0]);
    $('#txtIdVehiculo').val(data[1]);
    $('#txtImei').val(data[2]);
    $('#txtTelefono').val(data[3]);
    $('#cboGps').val(data[4]);
    $('#txtModelo').val(data[5]);
    $('#txtMarca').val(data[6]);
    $('#txtPlaca').val(data[7]);
    $('#txtColor').val(data[8]);
    $('#dtpVerificacion').val(data[9]);
    $('#cboGiro').val(data[10]);
    if (data[11] != 100000) {
        $('#chkIcon').prop('checked', true);
        $('#txtIdImagen').val(data[11]);
        $('#frmVehiculo').find('#divIcons').show();
    } else {
        $('#chkIcon').prop('checked', false);
        $('#txtIdImagen').val(data[11]);
        $('#frmVehiculo').find('#divIcons').hide();
    }
    if (data[12] == true) {
        $('#chkActivo').prop('checked', true);
        $('#btnActivate').hide();
        $('#btnEliminar').show();
        $('#lblActivo').text('Sí');
    } else {
        $('#chkActivo').prop('checked', false);
        $('#btnActivate').show();
        $('#btnEliminar').hide();        
        $('#lblActivo').text('No');
    }
    $('#btnRegistrar').prop('disabled', true);
}

function enabled() {
    $('#cboCliente').prop('readonly', false);
    $('#txtImei').prop('readonly', false);
    $('#txtTelefono').prop('readonly', false);
    $('#cboGps').prop('readonly', false);
    $('#txtModelo').prop('readonly', false);
    $('#txtMarca').prop('readonly', false);
    $('#txtPlaca').prop('readonly', false);
    $('#txtColor').prop('readonly', false);
    $('#dtpVerificacion').prop('readonly', false);
    $('#cboGiro').prop('readonly', false);
    $('#chkIcon').prop('readonly', false);
}
function disabled() {
    $('#cboCliente').prop('readonly', true);
    $('#txtImei').prop('readonly', true);
    $('#txtTelefono').prop('readonly', true);
    $('#cboGps').prop('readonly', true);
    $('#txtModelo').prop('readonly', true);
    $('#txtMarca').prop('readonly', true);
    $('#txtPlaca').prop('readonly', true);
    $('#txtColor').prop('readonly', true);
    $('#dtpVerificacion').prop('readonly', true);
    $('#cboGiro').prop('readonly', true);
    $('#chkIcon').prop('readonly', true);
}
