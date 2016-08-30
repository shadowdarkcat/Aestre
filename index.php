<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="web/css/bootstrap.min.css" rel="stylesheet">
        <link href="web/css/signin.css" rel="stylesheet">
        <link href="web/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <script src="web/jquery/boostrap/ie-emulation-modes-warning.js"></script>
         <style>
            body{
                background-image: url('/Aestre/web/image/fondo.jpeg');
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }

        </style>
        <title>Acceso Sistema</title>        
    </head>
    <body>
        <div class="container">
            <form id="frmLogin" name="frmLogin" class="form-signin" method="post" action="mx.com.aestre/system/login/controller/loginController.php?method=0" >
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
        <script src="web/jquery/boostrap/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>
