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
</html>