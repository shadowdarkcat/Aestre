$(document).ready(function () {
    $('#cboCliente').prop('disabled', true);
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
    $('#tblUsuarios').DataTable({
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
    btns = function () {
        changeErrorMessage('frmUsuario');
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
            $('#txtPassword').prop('disabled', true);
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
            $('#txtPassword').prop('disabled', true);
            if ($('#frmUsuario').validate().form()) {
                $('#frmUsuario').get(0).setAttribute('action', contextoGlobal + '/com/aestre/system/controller/usuarioController.php?method=3');
                $('#divActivar').modal('show');
            }
        });
        $('#btnAceptarActivar').on('click', function () {
            $('#frmUsuario').submit();
        });
        $("input.checkbox15").on('click', function () {
            return false;
        });
        $('#btnCancel').on('click', function () {
            $('#divMessageCancel').modal('show');
        });
        $('#btnAceptarCerrar').on('click', function () {
            clear(size);
            $('#trIndxFoot0').empty();
        });
    }

    getTree = function (id) {
        var data = {'method': 6, 'txtIdUsuario': id};
        $.getJSON(contextoGlobal + '/com/aestre/system/controller/usuarioController.php'
                , data, function (response) {
                    $('#tree').append(response.html);
                    $('#tree').tree();
                    btns();
                    checkTree();
                });
    };
});


function showNew() {
    clear(size);
    $('#trIndxFoot0').append('<td colspan="7">' + getFormUsuario() + '</td></tr>');
    $('#txtNombre').focus();
    $('#cboCliente').append(cboCliente);
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
    getTree('');
    btns();
}

function showData(index, action) {
    var data = usuarios[index].split(',');
    clear(size);
    $('#trIndxFoot0').empty();
    $('#trIndx' + index).before('<tr id="trIntIndx' + index + '"><td colspan="7">' + getFormUsuario() + '</td></tr>');
    $('#cboCliente').append(cboCliente);
    $('#btnActualizar').prop('disabled', true);
    $('#btnEliminar').prop('disabled', true);
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
        $('#cboCliente').prop('disabled', true);
        $('#chkAdmin').prop('checked', true);
        $('#lblIsAdmin').text('Adminsitrador');
        $('#chkAdmin').val('');
    } else {
        $('#cboCliente').prop('disabled', false);
        $('#cboCliente').val(data[5]);
        $('#chkAdmin').prop('checked', false);
        $('#chkAdmin').prop('checked', false);
        $('#lblIsAdmin').text('Usuario');
        $('#chkAdmin').val('');
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
    getTree('');
    btns();
}

function enabled() {
    $('#txtUser').prop('readonly', false);
    $('#txtNombre').prop('readonly', false);
    $('#txtTelefono').prop('readonly', false);
    $('#txtMail').prop('readonly', false);
    $('#cboCliente').prop('readonly', false);
}

function disabled() {
    $('#txtUser').prop('readonly', true);
    $('#txtNombre').prop('readonly', true);
    $('#txtTelefono').prop('readonly', true);
    $('#txtMail').prop('readonly', true);
    $('#cboCliente').prop('readonly', true);
}

function isAdmin() {
    if ($('#chkAdmin').is(':checked')) {
        $('#cboCliente').prop('disabled', true);
        $('#lblIsAdmin').text('Administrador');
        $('#chkAdmin').val(1);
        checkTree();
    } else {
        $('#cboCliente').prop('disabled', false);
        $('#lblIsAdmin').text('Usuario');
        $('#chkAdmin').val('');
        uncheckTree();
    }
}

function checkTree() {
    $('#tree').tree('uncheckAll');
    $("input.checkbox0").prop("disabled", false);
    $("input.checkbox1").prop("disabled", false);
    $("input.checkbox2").prop("disabled", false);
    $("input.checkbox3").prop("disabled", false);
    $('#tree').tree('check', $('#node0'));
    $('#tree').tree('check', $('#node1'));
    $('#tree').tree('check', $('#node2'));
    $('#tree').tree('check', $('#node3'));
    $('#tree').tree('check', $('#node15'));
    $('#tree').tree('collapse', $('#node4'));
    $('#tree').tree('collapse', $('#node7'));
    $('#tree').tree('collapse', $('#node10'));
    $('#tree').tree('collapse', $('#node15'));
    $("input.checkbox4").prop("disabled", true);
    $("input.checkbox7").prop("disabled", true);
    $("input.checkbox10").prop("disabled", true);
    if (!$('#chkAdmin').is(':checked')) {
        $('#cboCliente').prop('disabled', false);
        $('#lblIsAdmin').text('Usuario');
        $('#chkAdmin').val('');
        uncheckTree();
    }
}

function uncheckTree() {
    $('#tree').tree('uncheckAll');
    $("input.checkbox4").prop("disabled", false);
    $("input.checkbox7").prop("disabled", false);
    $("input.checkbox10").prop("disabled", false);
    $('#tree').tree('check', $('#node4'));
    $('#tree').tree('check', $('#node7'));
    $('#tree').tree('check', $('#node10'));
    $('#tree').tree('check', $('#node15'));
    $('#tree').tree('expand', $('#node4'));
    $('#tree').tree('expand', $('#node7'));
    $('#tree').tree('expand', $('#node10'));
    $('#tree').tree('expand', $('#node15'));
    $("input.checkbox0").prop("disabled", true);
    $("input.checkbox1").prop("disabled", true);
    $("input.checkbox2").prop("disabled", true);
    $("input.checkbox3").prop("disabled", true);
}

function clear(size) {
    for (var indx = 0; indx < size; indx++) {
        $('#trIntIndx' + indx).remove();
    }
}