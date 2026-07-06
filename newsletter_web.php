<?php
require('sources/ob_bbdd.php');
require('sources/ob_newsletter.php');
require('sources/ob_cp_newsletter.php');

$basedades = new ob_bbdd;
$nl_cp     = new ob_cp_newsletter;

$basedades->conectar();
if (!$basedades->error_conexio) {
    $news         = $nl_cp->get_newsletter_news($basedades->bd);
    $all_cronicas = $nl_cp->get_all_week_cronicas($basedades->bd);
    $cronicas     = array_values(array_filter($all_cronicas, function($c) { return (int)$c['newsletter'] === 1; }));
    $reviews      = $nl_cp->get_week_reviews($basedades->bd);
    $concerts     = $nl_cp->get_week_concerts($basedades->bd);
    $interviews   = $nl_cp->get_week_interviews($basedades->bd);
    $metal_report = $nl_cp->get_week_metal_report($basedades->bd);
    $basedades->desconectar();
    echo $nl_cp->build_email_html($news, $cronicas, $reviews, $concerts, $interviews, $metal_report, '');
}
?>
