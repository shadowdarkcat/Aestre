$(document).ready(function () {
    changeErrorMessage('frmUsuario');
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
function showData(index, action) {}