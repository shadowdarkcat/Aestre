<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
session_start();
$login = $_SESSION[PropertyKey::$session_usuario];
if (!isset($login)) {
    echo(PropertyKey::$php_index);
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/web/decorator/scripts/scripts.php'); ?>   
        <title>Men&uacute; Principal</title>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <label> <?php echo($login->getNombre()); ?> </label>
                    </a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <img  src="/Aestre/web/images/logoAestre.ico" width="60px;" height="60px"  class="required"/>
                    <ul class="nav navbar-nav">                        
                        <?php echo($login->getMenu()); ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
        </div> 
    </body>
    <div id="divMessageUpdate" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title label-warning"><label id="lblTittleUpdate"></label></h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td style="text-align: center;">
                                <p><label class="text-muted text-center text-info">El registro ser&aacute; actualizado, ¿Desea Continuar?</label></p>
                            </td>
                        </tr>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnUpdate" name="btnUpdate">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelarUpdate" name="btnCancelarUpdate">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="divMessageDelete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title label-danger"><label id="lblTittleDelete"></label></h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td style="text-align: center;">
                                <p><label class="text-muted text-center text-info">El registro ser&aacute; eliminado, ¿Desea Continuar?</label></p>
                            </td>
                        </tr>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnDelete" name="btnDelete">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelarDelete" name="btnCancelarDelete">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="divExiste" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title alert-warning">Cliente Existente</h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td class="dt-responsive form-control">
                                <p><span class="text-muted text-info">El cliente ya existe</span></p>
                            </td>
                        </tr>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptar" name="btnAceptar">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</html>