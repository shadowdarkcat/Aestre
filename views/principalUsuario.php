<!DOCTYPE html>
<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION[PropertyKey::$session_usuario]) ? $_SESSION[PropertyKey::$session_usuario] : NULL;
if (!Utils::isSessionValid($login)) {
    echo(PropertyKey::$php_index);
    $_SESSION[PropertyKey::$session_access] = 0;
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <?php require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/web/decorator/scripts/scripts.php'); ?>       
        <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCykQj4Z0ABWY8PN7y3IIy0x6lhpq27wrA&libraries=adsense&language=es" type="text/javascript"></script>
        <script type="text/javascript" src="/Aestre/web/js/panel.js"></script>
        <script type="text/javascript" src="/Aestre/web/js/map.js"></script>        
        <script type="text/javascript" src="../web/forms/formGeozona.js"></script>
        <script>
            google.maps.event.addDomListener(window, 'load', init());
            google.maps.event.addDomListener(window, "resize", resizingMapGral());
            function init() {
                onloadAll();
            }
        </script>
        <title>Men&uacute; Principal</title>
    </head>
    <body  style="background: white;">
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
                    <img  src="/Aestre/web/images/logoAestre.ico"/>
                    <ul class="nav navbar-nav">                        
                        <li>
                            <a href="../com/aestre/system/controller/loginController.php?method=3">
                                <img src="/Aestre/web/images/menuSalir.png">
                                CERRAR SESI&Oacute;N
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br/><br/><br/><br/><br/>        
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <button id="btnUpdateMap" class="active btn-primary form-control">
                            <label class="font-size">Actualizar Mapa General</label></button><br/>
                        <button id="btnListVehiculos" class="active btn-primary form-control">
                            <label id="lblTittleListV" class="font-size"></label></button><br/>
                        <?php
                        require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/panelIzquierdo.php');
                        ?>
                        <?php echo($login->getMenu()); ?>
                        <br/><br/>
                        <div id="divMiniMap"></div>
                    </div>                   
                    <div class="col-lg-8 ">
                        <div id="divMap"></div>
                    </div>
                </div>
            </div>
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
    <div id="divActivar" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title label-warning">Habilitar <label id="lblTittleActivar"></label></h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td class="dt-responsive form-control">
                                <p><label class="text-muted text-center text-info">¿ Desea habilitar el registro ?</label></p>
                            </td>
                        </tr>
                    </table>
                    <div class="modal-footer">
                        <div class="modal-footer">
                            <button type="button" class="btn  btn-primary " id="btnAceptarActivar" name="btnAceptarActivar">Aceptar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelarActivar" name="btnCancelarActivar">Cancelar</button>                        
                        </div>
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
                    <h4 class="modal-title label-warning"><label id="lblTittleExists"></label> Existente</h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td class="dt-responsive form-control">
                                <p><label class="text-muted text-center text-info">El registro ya existe</label></p>
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
    <div id="divMessageCancel" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title label-warning">Advertencia</h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td class="dt-responsive form-control">
                                <p><label class="text-muted text-center text-info">
                                        Se perderan los datos nos guardados al cerrar. Desea continuar?</label></p>
                            </td>
                        </tr>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAceptarCerrar" name="btnAceptarCerrar">Aceptar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancelar" name="btnCancelar">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>
<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/registroZonas.php');
