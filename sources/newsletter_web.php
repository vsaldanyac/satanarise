<?php
require('sources/ob_bbdd.php');
require('sources/ob_newsletter.php');
require('sources/ob_cp_newsletter.php');

$basedades = new ob_bbdd;
$nl_cp     = new ob_cp_newsletter;

$basedades->conectar();
if (!$basedades->error_conexio) {
    $news         = $nl_cp->get_newsletter_news($basedades->bd);
    $reviews      = $nl_cp->get_week_reviews($basedades->bd);
    $concerts     = $nl_cp->get_week_concerts($basedades->bd);
    $interviews   = $nl_cp->get_week_interviews($basedades->bd);
    $metal_report = $nl_cp->get_week_metal_report($basedades->bd);
    $basedades->desconectar();
    echo $nl_cp->build_email_html($news, $reviews, $concerts, $interviews, $metal_report, '');
}
?>
