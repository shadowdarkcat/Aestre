<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) . '/Aestre/com/aestre/AutoLoad.php');
spl_autoload_register('aestre_autoload', FALSE);
if (session_status() === PHP_SESSION_NONE) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
$controller = new coloniaController();
$controller->colonias();
if (isset($_SESSION[PropertyKey::$session_colonias])) {
    $colonias = json_decode($_SESSION[PropertyKey::$session_colonias]);
    unset($_SESSION[PropertyKey::$session_colonias]);
}

?>
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
<link type="text/css" href="/Aestre/web/css/bootstrap-multiselect.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery-ui.theme.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.dataTables.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.dataTables.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/dataTables.responsive.nightly.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.timepicker.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.tree.min.css" rel="stylesheet" />
<link type="text/css" href="/Aestre/web/css/jquery.tree.css" rel="stylesheet" />
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
<script type="text/javascript" src="/Aestre/web/jquery/jquery/markerclusterer_compiled.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/additional-methods.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/bootstrap-submenu.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/bootstrap-submenu.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/ie-emulation-modes-warning.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/bootstrap/dropdown.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery.tree.min.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jquery.tree.js"></script>
<script type="text/javascript" src="/Aestre/web/jquery/jquery/jscolor.min.js"></script>
<script type="text/javascript" src="/Aestre/web/resources/es-MX.js"></script>
<script type="text/javascript" src="/Aestre/web/js/generales.js"></script>

<script>
    var contextoGlobal = '/Aestre';
    var availableTags = [];
<?php foreach ($colonias as $item) { ?>
        availableTags.push(
    <?php
    echo('\'' . $item->idCp . ',' . strtoupper($item->col) . ',' . strtoupper($item->dele)
    . ',' . strtoupper($item->muni) . ',' . $item->cp . ',' . strtoupper($item->estado)
    . ',' . strtoupper($item->ciudad) . '\'');
    ?>);
    <?php
}
?>
</script>
