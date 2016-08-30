<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <link type="text/css" href="web/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="web/css/signin.css" rel="stylesheet">
        <link type="text/css" href="web/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link type="text/css" href="web/css/style.css" rel="stylesheet">
        <script type="text/javascript" src="web/jquery/boostrap/ie-emulation-modes-warning.js"></script>
        <title>Acceso Sistema</title>        
    </head>
    <div class="container">
        <div class="container">
            <form id="frmLogin" name="frmLogin" class="form-signin" method="post" action="com/aestre/system/controller/loginController.php?method=0" >
                <center><h2 class="form-signin-heading">Acceso Sistema</h2></center>
                <label for="txtUser" class="sr-only">Nombre Usuario :</label>
                <input type="text" id="txtUser" name="txtUser" class="form-control" placeholder="Nombre Usuario " required = "required" autofocus="autofocus"/>
                <label for="txtPassword" class="sr-only">Contrase&ntilde;a :</label>
                <input type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="Password" required="required"/>                                
                <button class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>                
                <br/>
                <?php
                if (isset($_SESSION['access'])) {
                    ?>
                    <center>
                        <label class="alert-danger">Credenciales inv&aacute;lidas &oacute; Usuario Inactivo
                        </label>
                    </center>
                <?php } ?>
            </form>
        </div>
    </div>    
    <script src="web/jquery/boostrap/ie10-viewport-bug-workaround.js"></script>
</html>
