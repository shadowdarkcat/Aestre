<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/views/principalAdmin.php');
spl_autoload_register('aestre_autoload', FALSE);
new PropertyKey();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!Utils::isSessionValid($_SESSION[PropertyKey::$session_usuario])) {
    echo(PropertyKey::$php_index);
}

if (isset($_SESSION[PropertyKey::$session_users])) {
    $usuarios = unserialize($_SESSION[PropertyKey::$session_users]);
}
$controllerC = new clienteController();
$controllerC->findAllToUsuario();
if (isset($_SESSION[PropertyKey::$session_clientes])) {
    $clientes = unserialize($_SESSION[PropertyKey::$session_clientes]);
}

$exist = '';
if (isset($_SESSION[PropertyKey::$session_exists])) {
    $exist = unserialize($_SESSION[PropertyKey::$session_exists]);
    unset($_SESSION[PropertyKey::$session_exists]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <script type="text/javascript" src="../web/js/usuarios.js"></script>
        <script type="text/javascript" src="../web/forms/formUsuario.js"></script>
        <script>
            var usuarios = [];
        </script>
        <title>Nuevo Usuario</title>
    </head>
    <body>
        <?php
        $optionC = '<option value=""></option>';
        foreach ($clientes as $item) {
            $optionC.='<option value=' . $item->getIdCliente() . '>'
                    . $item->getNombre() . ' ' . $item->getPaterno()
                    . ' ' . $item->getMaterno() . '</option>';
        }
        ?>
        <script>
            var cboCliente = '<?php echo($optionC); ?>';
        </script>
        <br/><br/><br/><br/><br/>
        <div class="container-fluid" style="background: white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
                        <h4 style="text-align: center;" >USUARIOS</h4>
                        <div class="table">
                            <table id="tblUsuarios" class="table table-striped table-bordered dt-responsive nowrap" data-role="datatable" cellspacing="0" width="100%" data-info="false">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"><label class="font-size">Nombre</label></th>
                                        <th style="text-align: center;"><label class="font-size">No Tel&eacute;fono</label></th>
                                        <th style="text-align: center;"><label class="font-size">Nombre Usuario</label></th>
                                        <th style="text-align: center;"><label class="font-size">Activo</label></th>
                                        <th style="text-align: center;"><label class="font-size">Editar</label></th>
                                        <th style="text-align: center;"><label class="font-size">Habilitar/Inhabilitar</label></th>
                                        <th style="text-align: center; display: none;"><label class="font-size"># Usuario</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    ?><script> var size =<?php echo(count($usuarios)); ?>;</script>
                                    <?php
                                    foreach ($usuarios as $item) {
                                        setData($item);
                                        echo ('<tr id="trIndx' . $index . '">'
                                        . '<td style = "text-align: center;">'
                                        . '<label class="font-size">' . $item->getNombre() . '</label>'
                                        . '</td>'
                                        . '<td style = "text-align: center;">'
                                        . '<label class="font-size">' . $item->getTelefono() . '</label>'
                                        . '</td>'
                                        . '<td style="text-align: center;">'
                                        . '<label class="font-size">' . $item->getNombreUsuario() . '</label>'
                                        . '</td>'
                                        . '<td  style="text-align: center;">'
                                        . '<label class="font-size">' . (($item->getActivo() == TRUE) ? 'Sí' : 'NO')
                                        . '</label></td>'
                                        . '<td  style="text-align: center;">'
                                        . '<button type="button" class="btn" '
                                        . 'onclick="showData(' . $index . ',0);">'
                                        . '<img src="../web/images/modificar.png" height="23px" width="29px;"></button>'
                                        . '</td>'
                                        . '<td  style="text-align: center;">'
                                        . '<button type="button" class="btn"'
                                        . 'onclick="showData(' . $index . ',1);">'
                                        . '<img src="../web/images/habilitar.png" height="29px" width="23px;"></button>'
                                        . '</td>'
                                        . '<td style="text-align: center; display:none;">'
                                        . '<label class="font-size" id="lblId">' . $item->getIdUsuario() . '</label>'
                                        . '</td>'
                                        . '</tr>');
                                        $index++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot id="foot"></tfoot>
                            </table>
                        </div>
                    </div>                    
                </div>
            </div>
    </body>
</html>
<?php

function setData(DtoLogin $item) {
    ?>
    <script>
        usuarios.push(
    <?php
    echo('\'' . $item->getIdUsuario() . ',' . $item->getNombreUsuario()
    . ',' . $item->getNombre() . ',' . $item->getTelefono()
    . ',' . $item->getMail() . ',' . $item->getIdCliente()
    . ',' . $item->getAdmin() . ',' . $item->getActivo() . '\'');
    ?>);
    </script>
    <?php
}

if ($exist) {
    echo('<script>$("#divExiste").modal("show");</script>');
}
?>