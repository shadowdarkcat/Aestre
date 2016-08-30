$(document).ready(function () {
    $('#btnActualizar').prop('disabled',true);
    $('#btnEliminar').prop('disabled',true);
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
});

