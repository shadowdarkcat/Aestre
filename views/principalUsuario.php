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
                        <?php echo($login->getMenu()); ?>
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
                        <?php require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/panelIzquierdo.php'); ?>                        
                    </div>
                    <div class="col-lg-8 ">
                        <div id="divMap"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>