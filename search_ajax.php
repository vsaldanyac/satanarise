<?php
require_once('sources/ob_bbdd.php');

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$q  = isset($_GET['q'])  ? trim($_GET['q'])  : '';
$ln = (isset($_GET['ln']) && $_GET['ln'] === 'CAT') ? 'CAT' : 'ES';

$empty = ['noticias' => [], 'conciertos' => [], 'criticas' => [], 'cronicas' => [], 'entrevistas' => []];

if (mb_strlen($q) < 3) {
    echo json_encode(['results' => $empty]);
    exit;
}

$basedades = new ob_bbdd;
$basedades->conectar();

if ($basedades->error_conexio) {
    http_response_code(503);
    echo json_encode(['error' => 'db']);
    exit;
}

$bd   = $basedades->bd;
/* NOTE: Do NOT call set_charset('utf8') here.
   The DB columns are declared latin1 but the bytes stored are already UTF-8
   (legacy data inserted without proper charset declaration).
   Asking MySQL to convert would double-encode and produce garbage (Ã³ etc.).
   Returning the raw bytes lets json_encode treat them as valid UTF-8. */
$term = $bd->real_escape_string($q);

$results = $empty;

/* Decode HTML entities stored literally in old DB records (e.g. &quot; -> ") */
function clean(string $s): string {
    return html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/* ---- Noticias ---- */
$idioma       = ($ln === 'CAT') ? 'CAT' : 'ES';
$sec_noticias = ($ln === 'CAT') ? 'noticies' : 'noticias';
$r = $bd->query(
    "SELECT news.idNews, newscontent.Title, news.dateIn
     FROM news
     INNER JOIN newscontent ON news.idNews = newscontent.idNews
     WHERE newscontent.Idioma = '$idioma'
       AND (newscontent.Title LIKE '%$term%' OR news.descripcio LIKE '%$term%')
     ORDER BY news.dateIn DESC
     LIMIT 5"
);
if ($r && $r->num_rows > 0) {
    while ($row = $r->fetch_assoc()) {
        $title = clean($row['Title']);
        $fecha = !empty($row['dateIn']) ? date('d/m/Y', strtotime($row['dateIn'])) : '';
        $results['noticias'][] = [
            'title' => $title . ($fecha ? ' - ' . $fecha : ''),
            'url'   => 'index.php?ln=' . $ln
                       . '&sec=' . $sec_noticias
                       . '&id=' . (int) $row['idNews']
                       . '&noticia=' . urlencode($title),
        ];
    }
}

/* ---- Conciertos ---- */
$sec_conciertos = ($ln === 'CAT') ? 'concerts' : 'conciertos';
/* No DISTINCT: fetch dateConcert + localitat per row, deduplicate in PHP keeping earliest date */
$r = $bd->query(
    "SELECT concerts.idGig, concerts.Nom, concertsgrups.Grup,
            concertsdata.dateConcert, concertsdata.localitat
     FROM concerts
     INNER JOIN concertsdata  ON concerts.idGig          = concertsdata.idGig
     INNER JOIN concertsgrups ON concertsdata.idConcert  = concertsgrups.idConcert
     WHERE concertsgrups.Grup LIKE '%$term%'
        OR concerts.Nom       LIKE '%$term%'
     ORDER BY concerts.dateIn DESC, concertsdata.dateConcert ASC
     LIMIT 20"
);
if ($r && $r->num_rows > 0) {
    $seen = [];
    while ($row = $r->fetch_assoc()) {
        $id = (int) $row['idGig'];
        if (isset($seen[$id])) continue;
        $seen[$id] = true;
        $name  = clean(!empty($row['Nom']) ? $row['Nom'] : $row['Grup']);
        $fecha = !empty($row['dateConcert']) ? date('d/m/Y', strtotime($row['dateConcert'])) : '';
        $city  = clean($row['localitat']);
        $extra = implode(' - ', array_filter([$fecha, $city]));
        $results['conciertos'][] = [
            'title' => $name . ($extra ? ' - ' . $extra : ''),
            'url'   => 'index.php?ln=' . $ln
                       . '&sec=' . $sec_conciertos
                       . '&type=entrada&id=' . $id,
        ];
        if (count($results['conciertos']) === 5) break;
    }
}

/* ---- Críticas / Reviews ---- */
$sec_criticas = ($ln === 'CAT') ? 'critiques' : 'criticas';

$instruments = ['batería','guitarra','guitarras','bajo','flauta','voz','voces',
                'coros','teclados','sintetizadores','gaitas','danza'];
$formacio_clause = in_array(mb_strtolower($q), $instruments)
    ? ''
    : "OR reviews.formacio_es LIKE '%$term%'";

$r = $bd->query(
    "SELECT DISTINCT reviews.link, reviews.banda, reviews.disc, reviews.any
     FROM reviews
     WHERE (reviews.banda LIKE '%$term%' $formacio_clause)
       AND release_date <= NOW()
     ORDER BY reviews.release_date DESC
     LIMIT 5"
);
if ($r && $r->num_rows > 0) {
    while ($row = $r->fetch_assoc()) {
        $results['criticas'][] = [
            'title' => clean($row['banda']) . ' – ' . clean($row['disc']) . ' (' . $row['any'] . ')',
            'url'   => 'index.php?ln=' . $ln . '&sec=' . $sec_criticas . '&' . $row['link'],
        ];
    }
}

/* ---- Crónicas (last 12 months, search in titol) ---- */
$sec_cronicas  = ($ln === 'CAT') ? 'croniques' : 'cronicas';
$idioma_filter = ($ln === 'CAT') ? "idioma = 'CAT' OR idioma = 'BOTH'" : "idioma = 'ES' OR idioma = 'BOTH'";
$r = $bd->query(
    "SELECT cronicas.link, cronicas.titol
     FROM cronicas
     WHERE cronicas.titol LIKE '%$term%'
       AND ($idioma_filter)
       AND cronicas.data >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
     ORDER BY cronicas.data DESC
     LIMIT 5"
);
if ($r && $r->num_rows > 0) {
    while ($row = $r->fetch_assoc()) {
        $results['cronicas'][] = [
            'title' => clean($row['titol']),
            'url'   => 'index.php?ln=' . $ln . '&sec=' . $sec_cronicas . '&' . $row['link'],
        ];
    }
}

/* ---- Entrevistas ---- */
$sec_entrevistas  = ($ln === 'CAT') ? 'entrevistes'  : 'entrevistas';
$idioma_filter    = ($ln === 'CAT') ? "idioma = 'CAT' OR idioma = 'BOTH'" : "idioma = 'ES' OR idioma = 'BOTH'";
$titol_field      = ($ln === 'CAT') ? 'titol_cat' : 'titol_es';
$r = $bd->query(
    "SELECT entrevistes.link, entrevistes.banda, entrevistes.$titol_field AS titol
     FROM entrevistes
     WHERE entrevistes.banda LIKE '%$term%'
       AND ($idioma_filter)
     ORDER BY entrevistes.data DESC
     LIMIT 5"
);
if ($r && $r->num_rows > 0) {
    while ($row = $r->fetch_assoc()) {
        $titol = !empty($row['titol']) ? ' — ' . clean($row['titol']) : '';
        $results['entrevistas'][] = [
            'title' => clean($row['banda']) . $titol,
            'url'   => 'index.php?ln=' . $ln . '&sec=' . $sec_entrevistas . '&' . $row['link'],
        ];
    }
}

$basedades->desconectar();

echo json_encode(['results' => $results], JSON_UNESCAPED_UNICODE);
