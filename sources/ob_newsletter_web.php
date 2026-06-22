<?php
class ob_newsletter_web
{
    public function subscribe($bd, $email)
    {
        if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
            return 'invalid';
        }
        $email_esc = $bd->real_escape_string(trim($email));
        $result = $bd->query("SELECT id, active FROM newsletter_subscribers WHERE email = '$email_esc'");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ((int)$row['active'] === 0) {
                $id    = (int)$row['id'];
                $now   = date('Y-m-d H:i:s');
                $token = bin2hex(random_bytes(32));
                $ok = $bd->query("UPDATE newsletter_subscribers SET active = 1, subscribed_at = '$now', unsubscribed_at = NULL, unsubscribe_token = '$token' WHERE id = $id");
                return $ok ? 'ok' : 'error';
            }
            return 'duplicate';
        }
        $token = bin2hex(random_bytes(32));
        $now = date('Y-m-d H:i:s');
        $ok = $bd->query("INSERT INTO newsletter_subscribers (email, active, subscribed_at, unsubscribe_token) VALUES ('$email_esc', 1, '$now', '$token')");
        return $ok ? 'ok' : 'error';
    }

    public function unsubscribe_by_token($bd, $token)
    {
        if ($token === '') {
            return 'not_found';
        }
        $token_esc = $bd->real_escape_string($token);
        $result = $bd->query("SELECT id, active FROM newsletter_subscribers WHERE unsubscribe_token = '$token_esc'");
        if (!$result || $result->num_rows == 0) {
            return 'not_found';
        }
        $row = $result->fetch_assoc();
        if ($row['active'] == 0) {
            return 'already_inactive';
        }
        $id = (int)$row['id'];
        $now = date('Y-m-d H:i:s');
        $ok = $bd->query("UPDATE newsletter_subscribers SET active = 0, unsubscribed_at = '$now' WHERE id = $id");
        return $ok ? 'ok' : 'error';
    }

    public function render_subscribe_form($status = '')
    {
        $message = '';
        switch ($status) {
            case 'ok':
                $message = '<p style="color:#5a5;font-size:12px;margin:0 0 8px 0;">&#161;Suscrito correctamente! <br />Podr&aacute;s deshacerlo desde cualquier newsletter. Cuando puedas, revisa tambi&eacute;n tu bandeja de spam; a veces los correos se cuelan all&iacute;.</p>';
                break;
            case 'duplicate':
                $message = '<p style="color:#cc2200;font-size:12px;margin:0 0 8px 0;">Este email ya está suscrito.</p>';
                break;
            case 'invalid':
                $message = '<p style="color:#cc2200;font-size:12px;margin:0 0 8px 0;">El email no es válido.</p>';
                break;
            case 'error':
                $message = '<p style="color:#cc2200;font-size:12px;margin:0 0 8px 0;">Error al suscribir. Inténtalo de nuevo.</p>';
                break;
        }
        print '<div id="newsletter-sub" style="background:#0d0d0d;border:1px solid #600;padding:16px 20px;margin:20px 0;font-family:Arial,Helvetica,sans-serif;">';
        print '<p style="color:#ffffff;font-size:13px;font-weight:bold;margin:0 0 6px 0;letter-spacing:1px;text-transform:uppercase;">Newsletter</p>';
        print '<p style="color:#999999;font-size:12px;margin:0 0 10px 0;">Recibe lo mejor de la semana en tu email.</p>';
        print $message;
        print '<form action="index.php#newsletter-sub" method="post" style="margin:0;">';
        print '<input type="hidden" name="nl_action" value="subscribe" />';
        print '<input type="text" name="nl_email" placeholder="Tu email" maxlength="255" style="width:170px;padding:5px 8px;background:#1a1a1a;border:1px solid #600;color:#ccc;font-size:12px;" />';
        print '&nbsp;<input type="submit" value="Suscribirse" style="padding:5px 10px;background:#600;color:#fff;border:none;cursor:pointer;font-size:12px;" />';
        print '</form>';
        print '</div>';
    }
}
?>
