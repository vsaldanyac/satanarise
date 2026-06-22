<div id="columna_central">
<?php
require('../sources/ob_cp_newsletter.php');
$nl_cp   = new ob_cp_newsletter;
$feedback = '';

if (isset($_POST['nl_action'])) {
    $basedades->conectar();
    if (!$basedades->error_conexio) {
        if ($_POST['nl_action'] === 'save_auto') {
            $val = isset($_POST['newsletter_auto']) ? 1 : 0;
            $nl_cp->save_auto_status($basedades->bd, $val);
            $feedback = 'Configuraci&oacute;n guardada.';
        } elseif ($_POST['nl_action'] === 'send_now') {
            $result = $nl_cp->send_newsletter($basedades->bd);
            if (isset($result['error']) && $result['error'] === 'no_subscribers') {
                $feedback = 'No hay suscriptores activos.';
            } else {
                $week = (int)date('W');
                $basedades->bd->query("UPDATE comptadors SET comptador_main = $week WHERE seccio = 'newsletter_week'");
                $feedback = 'Newsletter enviado a ' . $result['sent'] . ' suscriptor(es).';
            }
        }
        $basedades->desconectar();
    } else {
        $feedback = 'Error de conexi&oacute;n a la base de datos.';
    }
}

if ($feedback !== '') {
    print '<p class="terminal">' . $feedback . '</p>';
}

$basedades->conectar();
if (!$basedades->error_conexio) {
    $nl_cp->render_send_form($basedades->bd);
    $basedades->desconectar();
} else {
    print '<p class="terminal">Error de conexi&oacute;n a la base de datos.</p>';
}
?>
</div>
