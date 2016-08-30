<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="${pageContext.request.contextPath}/js/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!--[if lt IE 9]><script src="${pageContext.request.contextPath}/js/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<link type="text/css" href="/Aestre/web/css/bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/bootstrap-submenu.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/bootstrap-submenu.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery-ui.theme.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.dataTables.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.dataTables.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/dataTables.responsive.nightly.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.timepicker.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/style.css" rel="stylesheet" />
<!--<style type="text/css">

    .navbar {background-color: transparent ;background-image: none;}
    .navbar .brand, .navbar .nav > li > a {color: black;}
    .navbar .brand, .navbar .nav > li > a:hover {color: black;}  
    .icon-bar {background-color: #1980EC !important;}
    .collapsing, .in {background-color: #f1f1f1;}
    .collapsing ul li a, .in ul li a {color: black;}
    .collapsing ul li a:hover, .in ul li a:hover {color: #269abc!important;}
</style>!-->

<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery-ui.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery.dataTables.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery.timepicker.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery.validate.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/dataTables.responsive.nightly.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/boostrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/boostrap/bootstrap-submenu.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/boostrap/bootstrap-submenu.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/boostrap/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/boostrap/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/Aestre/web/resource/es-MX.js"></script>
<script type="text/javascript" src="/Aestre/web/resource/es_ES.json"></script>
<script type="text/javascript" src="/Aestre/web/js/generales.js"></script>

<script>
    var contextoGlobal = '/Aestre';
</script>

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