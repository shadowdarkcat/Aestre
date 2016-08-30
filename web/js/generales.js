/**
 * M&eacute;todo que convierte el texto a may&uacute;sculas
 * @param InputTypeText campo
 */
function mayuscula(campo) {
    $(campo).keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
}

/**
 * M&eacute;todo que convierte el texto a min&uacute;sculas
 * @param InputTypeText campo
 */
function minuscula(campo) {
    $(campo).keyup(function () {
        $(this).val($(this).val().toLowerCase());
    });
}

/**
 * M&eacute;todo que verifica que el texto sea solo d&iacute;gitos
 * @param InputTypeText campo
 */
$('.solo-numero').keyup(function () {
    this.value = (this.value + '').replace(/[^0-9]/g, '');
});

/**
 * M&eacute;todo que verifica que el texto sea solo letras
 * @param InputTypeText campo
 */
$(".letras").keypress(function (key) {
    console.log(key.charCode);
    if ((key.charCode < 97 || key.charCode > 122)//letras mayusculas
            && (key.charCode < 65 || key.charCode > 90)) { //letras minusculas
        return false;
    }
});

/**
 * M&eacute;todo que permite visualizar los autocomplete dentro de la vista modal
 */
function initCol() {
    var autoSuggestion = document.getElementsByClassName('ui-autocomplete');
    if (autoSuggestion.length > 0) {
        autoSuggestion[0].style.zIndex = 1100;
    }
}

/**
 * M&eacute;todo que cambia el estilo de los mensajes de error de validaciones
 * @param Text frm
 */
function changeErrorMessage(frm) {
    $('#' + frm).validate({
        highlight: function (element) {
            $(element).parent().addClass('alert-danger');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('alert-danger');
        }
    });
}

/**
 * Funci&oacute;n que convierte a array el valor de un checkbox
 * @param boolean chk
 * @returns array
 */
function getVisible(chk) {
    if (chk != undefined) {
        return chk.split(",");
    }
}

/**
 * Traduce el status del geocodign a espa&ntilde;ol
 * @param {type} status
 * @returns text
 */
function getStatus(status) {
    if (status == 'INVALID_REQUEST') {
        return 'Dirección invalida';
    } else if (status == 'ZERO_RESULTS') {
        return 'No se encontraron resultados';
    } else if (status == '') {
        return 'Se excedio el límite de consultas';
    } else if (status == 'REQUEST_DENIED') {
        return 'Solicitud rechazada';
    } else if (status == 'UNKNOWN_ERROR') {
        return 'Ocurrio un error al realizar la búsqueda';
    }
}

function defaultRadio(name) {
    $('input:radio[name="' + name + '"]').each(function () {
        this.checked = false;
    });
}