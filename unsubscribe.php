<?php
require('sources/ob_bbdd.php');
require('sources/ob_newsletter.php');
require('sources/ob_newsletter_web.php');

$basedades = new ob_bbdd;
$nl_web    = new ob_newsletter_web;
$token     = isset($_GET['token']) ? trim($_GET['token']) : '';
$status    = '';

$basedades->conectar();
if (!$basedades->error_conexio) {
    $status = $nl_web->unsubscribe_by_token($basedades->__get('bd'), $token);
    $basedades->desconectar();
} else {
    $status = 'error';
}

switch ($status) {
    case 'ok':
        $mensaje = 'Te has dado de baja correctamente.';
        $color   = '#5a5';
        break;
    case 'already_inactive':
        $mensaje = 'Ya estabas dado de baja.';
        $color   = '#999';
        break;
    case 'error':
        $mensaje = 'Error de conexión. Inténtalo más tarde.';
        $color   = '#cc2200';
        break;
    default:
        $mensaje = 'El enlace no es válido.';
        $color   = '#cc2200';
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <title>SatanArise - Dar de baja newsletter</title>
    <style>
        body { background:#000; color:#ccc; font-family:Arial,Helvetica,sans-serif; margin:0; padding:40px 20px; text-align:center; }
        a { color:#cc2200; }
    </style>
</head>
<body>
    <p style="font-size:22px;font-weight:bold;letter-spacing:3px;color:#fff;text-transform:uppercase;">SATANARISE</p>
    <p style="font-size:15px;color:<?php print $color; ?>;"><?php print htmlspecialchars($mensaje); ?></p>
    <p><a href="index.php">Volver a la web</a></p>
</body>
</html>
