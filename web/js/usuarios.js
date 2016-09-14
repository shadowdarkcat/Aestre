$(document).ready(function () {
    changeErrorMessage('frmUsuario');
    $('#cboCliente').prop('disabled',true);
    $('#divMessageUpdate').find('#lblTittleUpdate').empty();
    $('#divMessageDelete').find('#lblTittleDelete').empty();
    $('#divActivar').find('#lblTittleActivar').empty();
    $('#divExiste').find('#lblTittleExists').empty();
    $('#divMessageUpdate').find('#lblTittleUpdate').text('Usuario');
    $('#divMessageDelete').find('#lblTittleDelete').text('Usuario');
    $('#divActivar').find('#lblTittleActivar').text('Usuario');
    $('#divExiste').find('#lblTittleExists').text('Usuario');
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    getTree('');
    $('#tblUsuarios').DataTable({
        'ordering': false
        , 'info': false
        , 'displayLength': 1
        , language: {
            url: contextoGlobal + '/web/resources/es_ES.json'
        }
    });
    $('#btnRegistrar').on('click', function () {
        $('#frmUsuario').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/usuarioController.php?&method=1');
        if ($('#frmUsuario').validate().form()) {
            $('#frmUsuario').submit();
        }
    });
    $('#btnActualizar').on('click', function () {
        if ($('#frmUsuario').validate().form()) {
            $('#frmUsuario').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/usuarioController.php?method=2');
            $('#divMessageUpdate').modal('show');
        }
    });
    $('#btnUpdate').on('click', function () {
        $('#frmUsuario').submit();
    });
    $('#btnEliminar').on('click', function () {
        $('#chkActivo').prop('checked', false);
        if ($('#frmUsuario').validate().form()) {
            $('#frmUsuario').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/usuarioController.php?method=3');
            $('#divMessageDelete').modal('show');
        }
    });
    $('#btnDelete').on('click', function () {
        $('#frmUsuario').submit();
    });
    $('#btnActivate').on('click', function () {
        $('#chkActivo').prop('checked', true);
        if ($('#frmUsuario').validate().form()) {
            $('#frmUsuario').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/usuarioController.php?method=3');
            $('#divActivar').modal('show');
        }
    });
    $('#btnAceptarActivar').on('click', function () {
        $('#frmUsuario').submit();
    });
});
function getTree(id) {
    var data = {'method': 6, 'txtIdUsuario': id};
    $.getJSON(contextoGlobal + '/com/aestre/system/controller/usuarioController.php'
            , data, function (response) {
                $('#tree').append(response.html);
                $('#tree').tree({
                    onCheck: {
                        node: 'expand'
                    },
                    onUncheck: {
                        node: 'collapse'
                    }
                });
            });
}
function showData(index, action) {
    var data = usuarios[index].split(',')
    if (data[7] == true) {
        if (action == 0) {
            enabled();
            $('#frmUsuario').find('#btnActualizar').prop('disabled', false);
            $('#frmUsuario').find('#btnEliminar').prop('disabled', true);
        } else {
            disabled();
            $('#frmUsuario').find('#btnEliminar').prop('disabled', false);
            $('#frmUsuario').find('#btnActualizar').prop('disabled', true);
        }
    } else {
        disabled();
        $('#btnActualizar').prop('disabled', true);
        $('#btnEliminar').prop('disabled', true);
        $('#chkActivo').prop('checked', false);
    }
    $('#txtIdUsuario').val(data[0]);
    $('#txtUser').val(data[1]);
    $('#txtNombre').val(data[2]);
    $('#txtTelefono').val(data[3]);
    $('#txtMail').val(data[4]);
    if (data[6] == true) {
        $('#cboCliente').prop('disabled',true);
        $('#chkAdmin').prop('checked', true);
    } else {
        $('#cboCliente').prop('disabled',false);
        $('#cboCliente').val(data[5]);$('#chkAdmin').prop('checked', false);
        $('#chkAdmin').prop('checked', false);
    }
    if (data[7] == true) {
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
    $('#txtUser').prop('readonly', false);
    $('#txtNombre').prop('readonly', false);
    $('#txtTelefono').prop('readonly', false);
    $('#txtMail').prop('readonly', false);
    $('#cboCliente').prop('readonly', false);
    $('#chkAdmin').removeAttr('onclick');
}
function disabled() {
    $('#txtUser').prop('readonly', true);
    $('#txtNombre').prop('readonly', true);
    $('#txtTelefono').prop('readonly', true);
    $('#txtMail').prop('readonly', true);
    $('#cboCliente').prop('readonly', true);
    $('#chkAdmin').attr('onclick', 'return false;');
}

function isAdmin() {
    if ($("#chkAdmin").is(':checked')) {
        $('#cboCliente').prop('disabled',true);
        $("#divAltaUsuario").find('#lblIsAdmin').text('Sí');
        $("#divAltaUsuario").find('#chkAdmin').val(1);
        $('#tree').tree('checkAll');
        $('#tree').tree('expand');
    } else {
        $('#cboCliente').prop('disabled',false);
        $("#divAltaUsuario").find('#lblIsAdmin').text('No');
        $("#divAltaUsuario").find('#chkAdmin').val(0);
        $('#tree').tree('uncheckAll');
        $('#tree').tree('expand');
    }
}