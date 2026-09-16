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

    $html = $nl_cp->build_email_html($news, $cronicas, $reviews, $concerts, $interviews, $metal_report, '');

    $og_tags = '<meta property="og:type" content="website" />' .
        '<meta property="og:site_name" content="Satan Arise" />' .
        '<meta property="og:url" content="https://www.satanarise.com/newsletter_web.php" />' .
        '<meta property="og:title" content="Newsletter - Satan Arise" />' .
        '<meta property="og:description" content="La newsletter semanal de Satan Arise: noticias, cronicas, reviews, conciertos y entrevistas de metal." />' .
        '<meta property="og:image" content="https://www.satanarise.com/logos/SatanAriseLogoXV.jpg" />' .
        '<meta name="twitter:card" content="summary_large_image" />' .
        '<title>Newsletter - Satan Arise</title>';

    $html = str_replace('<meta charset="UTF-8"/></head>', '<meta charset="UTF-8"/>' . $og_tags . '</head>', $html);

    echo $html;
}
?>
