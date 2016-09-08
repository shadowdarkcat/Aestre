<?php

$controller = new usuarioController();
$controller->redirect();

/**
 * Description of usuarioController
 *
 * @author ShadowDarkCat
 */
class usuarioController {
    public function redirect(){
        echo('<script>window.location="/Aestre/views/registroUsuario.php";</script>');
    }
}
