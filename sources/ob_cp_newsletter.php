<?php
class ob_cp_newsletter
{
    private function email_escape($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    private function get_prev_week_range()
    {
        $monday = strtotime('monday this week midnight');
        $from = date('Y-m-d 00:00:00', $monday - 7 * 86400);
        $to   = date('Y-m-d 23:59:59', $monday - 86400);
        return [$from, $to];
    }

    public function get_newsletter_news($bd)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_esc = $bd->real_escape_string($from);
        $to_esc   = $bd->real_escape_string($to);
        $query = "SELECT news.idNews, newscontent.Title, news.dateIn,
                         (SELECT ruta FROM newsdata WHERE newsdata.idNews = news.idNews AND newsdata.tipo = 1 AND newsdata.orden = 1) AS ruta
                  FROM news
                  JOIN newscontent ON news.idNews = newscontent.idNews
                  WHERE news.newsletter = 1
                    AND newscontent.Idioma = 'ES'
                    AND news.dateIn BETWEEN '$from_esc' AND '$to_esc'
                  ORDER BY news.dateIn DESC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function get_all_week_news($bd)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_esc = $bd->real_escape_string($from);
        $to_esc   = $bd->real_escape_string($to);
        $query = "SELECT news.idNews, newscontent.Title, news.dateIn, news.newsletter,
                         (SELECT ruta FROM newsdata WHERE newsdata.idNews = news.idNews AND newsdata.tipo = 1 AND newsdata.orden = 1) AS ruta
                  FROM news
                  JOIN newscontent ON news.idNews = newscontent.idNews
                  WHERE newscontent.Idioma = 'ES'
                    AND news.dateIn BETWEEN '$from_esc' AND '$to_esc'
                  ORDER BY news.dateIn DESC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function update_news_newsletter_flags($bd, $enabled_ids)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_esc = $bd->real_escape_string($from);
        $to_esc   = $bd->real_escape_string($to);
        $bd->query("UPDATE news SET newsletter = 0 WHERE dateIn BETWEEN '$from_esc' AND '$to_esc'");
        if (!empty($enabled_ids)) {
            $ids = implode(',', array_map('intval', $enabled_ids));
            $bd->query("UPDATE news SET newsletter = 1 WHERE idNews IN ($ids)");
        }
    }

    public function get_all_current_week_news($bd)
    {
        $monday   = strtotime('monday this week midnight');
        $from_esc = $bd->real_escape_string(date('Y-m-d 00:00:00', $monday));
        $to_esc   = $bd->real_escape_string(date('Y-m-d 23:59:59', $monday + 6 * 86400));
        $query = "SELECT news.idNews, newscontent.Title, news.dateIn, news.newsletter
                  FROM news
                  JOIN newscontent ON news.idNews = newscontent.idNews
                  WHERE newscontent.Idioma = 'ES'
                    AND news.dateIn BETWEEN '$from_esc' AND '$to_esc'
                  ORDER BY news.dateIn DESC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) $rows[] = $row;
        }
        return $rows;
    }

    public function update_current_week_news_flags($bd, $enabled_ids)
    {
        $monday   = strtotime('monday this week midnight');
        $from_esc = $bd->real_escape_string(date('Y-m-d 00:00:00', $monday));
        $to_esc   = $bd->real_escape_string(date('Y-m-d 23:59:59', $monday + 6 * 86400));
        $bd->query("UPDATE news SET newsletter = 0 WHERE dateIn BETWEEN '$from_esc' AND '$to_esc'");
        if (!empty($enabled_ids)) {
            $ids = implode(',', array_map('intval', $enabled_ids));
            $bd->query("UPDATE news SET newsletter = 1 WHERE idNews IN ($ids)");
        }
    }

    public function get_week_reviews($bd)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_esc = $bd->real_escape_string($from);
        $to_esc   = $bd->real_escape_string($to);
        $query = "SELECT reviews.idreviews, reviews.banda, reviews.disc, reviews.portada,
                         reviews.link, reviews.nota, estil.estil
                  FROM reviews
                  LEFT JOIN estil ON reviews.idestil = estil.idestil
                  WHERE reviews.release_date BETWEEN '$from_esc' AND '$to_esc'
                  ORDER BY reviews.release_date DESC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    private function get_next_week_concerts($bd)
    {
        $next_monday  = date('Ymd', strtotime('next monday')) . '000000';
        $monday_after = date('Ymd', strtotime('next monday') + 7 * 86400) . '000000';
        $query = "SELECT concertsdata.idConcert, concertsdata.idGig,
                         COALESCE(
                           (SELECT GROUP_CONCAT(Grup ORDER BY ordre SEPARATOR ' + ')
                            FROM concertsgrups WHERE concertsgrups.idConcert = concertsdata.idConcert),
                           NULLIF(concerts.Nom, '')
                         ) AS Nom,
                         concerts.Nom AS concerts_nom,
                         concertsdata.localitat, concertsdata.sala, concertsdata.dateConcert
                  FROM concertsdata, concerts
                  WHERE concertsdata.dateConcert >= $next_monday
                    AND concertsdata.dateConcert < $monday_after
                    AND concerts.idGig = concertsdata.idGig
                  ORDER BY concertsdata.dateConcert ASC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) $rows[] = $row;
        }
        return $rows;
    }

    public function get_week_concerts($bd)
    {
        $hoy        = date('Ymd') . '000000';
        $next_monday = date('Ymd', strtotime('next monday')) . '000000';
        $query = "SELECT concertsdata.idConcert, concertsdata.idGig,
                         COALESCE(
                           (SELECT GROUP_CONCAT(Grup ORDER BY ordre SEPARATOR ' + ')
                            FROM concertsgrups WHERE concertsgrups.idConcert = concertsdata.idConcert),
                           NULLIF(concerts.Nom, '')
                         ) AS Nom,
                         concerts.Nom AS concerts_nom,
                         concertsdata.localitat, concertsdata.sala, concertsdata.dateConcert
                  FROM concertsdata, concerts
                  WHERE concertsdata.dateConcert >= $hoy
                    AND concertsdata.dateConcert < $next_monday
                    AND concerts.idGig = concertsdata.idGig
                  ORDER BY concertsdata.dateConcert ASC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function get_week_interviews($bd)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_esc = $bd->real_escape_string(date('YmdHis', strtotime($from)));
        $to_esc   = $bd->real_escape_string(date('YmdHis', strtotime($to)));
        $query = "SELECT identrevistes, banda, titol_es, link, data
                  FROM entrevnews
                  WHERE (idioma = 'ES' OR idioma = 'BOTH')
                    AND data BETWEEN '$from_esc' AND '$to_esc'
                  ORDER BY data DESC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function get_week_metal_report($bd)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_esc = $bd->real_escape_string(date('YmdHis', strtotime($from)));
        $to_esc   = $bd->real_escape_string(date('YmdHis', strtotime($to)));
        $query = "SELECT idopinio, titol_es, data, ruta
                  FROM opinio
                  WHERE (idioma = 'ES' OR idioma = 'BOTH')
                    AND data BETWEEN '$from_esc' AND '$to_esc'
                  ORDER BY data DESC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function get_all_week_cronicas($bd)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_ymd = $bd->real_escape_string(date('YmdHis', strtotime($from)));
        $to_ymd   = $bd->real_escape_string(date('YmdHis', strtotime($to)));
        $query = "SELECT idcronicas, titol, data, cartell, newsletter, link
                  FROM cronicas
                  WHERE (idioma = 'ES' OR idioma = 'BOTH')
                    AND data BETWEEN '$from_ymd' AND '$to_ymd'
                  ORDER BY data DESC";
        $result = $bd->query($query);
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) $rows[] = $row;
        }
        return $rows;
    }

    public function update_cronicas_newsletter_flags($bd, $enabled_ids)
    {
        list($from, $to) = $this->get_prev_week_range();
        $from_ymd = $bd->real_escape_string(date('YmdHis', strtotime($from)));
        $to_ymd   = $bd->real_escape_string(date('YmdHis', strtotime($to)));
        $bd->query("UPDATE cronicas SET newsletter = 0 WHERE (idioma = 'ES' OR idioma = 'BOTH') AND data BETWEEN '$from_ymd' AND '$to_ymd'");
        if (!empty($enabled_ids)) {
            $ids = implode(',', array_map('intval', $enabled_ids));
            $bd->query("UPDATE cronicas SET newsletter = 1 WHERE idcronicas IN ($ids)");
        }
    }

    public function count_active_subscribers($bd)
    {
        $result = $bd->query("SELECT COUNT(*) as total FROM newsletter_subscribers WHERE active = 1");
        if ($result) {
            $row = $result->fetch_assoc();
            return (int)$row['total'];
        }
        return 0;
    }

    public function get_auto_status($bd)
    {
        $result = $bd->query("SELECT comptador_main FROM comptadors WHERE seccio = 'newsletter_auto'");
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row === null) return 0;
            return (int)$row['comptador_main'];
        }
        return 0;
    }

    public function save_auto_status($bd, $value)
    {
        $val = (int)$value;
        $bd->query("UPDATE comptadors SET comptador_main = $val WHERE seccio = 'newsletter_auto'");
    }

    public function build_email_html($news, $cronicas, $reviews, $concerts, $interviews, $metal_report, $token, $week_from = null, $week_to = null)
    {
        if ($week_from === null || $week_to === null) {
            list($from, $to) = $this->get_prev_week_range();
            $week_from = date('d/m/Y', strtotime($from));
            $week_to   = date('d/m/Y', strtotime($to));
        }

        $base = 'https://www.satanarise.com';

        $html  = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"/></head>';
        $html .= '<body style="margin:0;padding:0;background-color:#111111;font-family:Arial,Helvetica,sans-serif;">';
        $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#111111;">';
        $html .= '<tr><td align="center" style="padding:12px 10px 0 10px;">';
        $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#555555;">&iquest;No se muestra bien? <a href="' . $base . '/newsletter_web.php" style="font-family:Arial,sans-serif;font-size:11px;color:#cc2200;text-decoration:underline;">Ver en el navegador</a></span>';
        $html .= '</td></tr>';
        $html .= '<tr><td align="center" style="padding:12px 10px 20px 10px;">';
        $html .= '<table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#000000;border:1px solid #600;">';

        /* Header */
        $html .= '<tr><td style="background-color:#600;padding:24px 20px 16px 20px;text-align:center;">';
        $html .= '<a href="' . $base . '" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:32px;font-weight:bold;color:#ffffff;letter-spacing:4px;text-transform:uppercase;text-decoration:none;">SATANARISE</span></a><br/>';
        $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#ffcccc;letter-spacing:2px;text-transform:uppercase;">Newsletter Semanal &bull; ' . $week_from . ' - ' . $week_to . '</span>';
        $html .= '</td></tr>';

        /* Intro */
        $html .= '<tr><td style="padding:20px 30px 10px 30px;border-bottom:1px solid #330000;">';
        $html .= '<p style="margin:0;font-size:13px;color:#cccccc;line-height:1.6;letter-spacing:normal;">Lo mejor de la semana en el mundo del metal: noticias, cr&iacute;ticas, conciertos y entrevistas.</p>';
        $html .= '</td></tr>';

        /* Noticias */
        if (!empty($news)) {
            $html .= '<tr><td style="padding:24px 30px 0 30px;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
            $html .= '<td style="background-color:#600;padding:6px 14px;"><a href="' . $base . '/index.php?ln=ES&sec=noticias" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#ffffff;letter-spacing:2px;text-decoration:none;white-space:nowrap;">NOTICIAS</span></a></td>';
            $html .= '</tr></table></td></tr>';
            $html .= '<tr><td style="padding:10px 30px 0 30px;">';
            $count = count($news);
            foreach ($news as $i => $n) {
                $clean_title = strip_tags($n['Title']);
                $url = $base . '/index.php?ln=ES&sec=noticias&id=' . (int)$n['idNews'] . '&noticia=' . urlencode($clean_title);
                $date = date('d/m/Y', strtotime($n['dateIn']));
                $html .= '<table width="540" cellpadding="0" cellspacing="0" border="0"><tr>';
                if (!empty($n['ruta'])) {
                    $img_src = $base . '/' . htmlspecialchars(ltrim($n['ruta'], '/'));
                    $html .= '<td width="90" valign="middle" style="width:90px;padding-right:14px;padding-bottom:10px;">';
                    $html .= '<img src="' . $img_src . '" width="76" height="52" alt="" style="display:block;border:1px solid #330000;"/>';
                    $html .= '</td>';
                    $html .= '<td width="450" valign="middle" style="width:450px;padding-bottom:10px;">';
                } else {
                    $html .= '<td width="540" valign="middle" style="width:540px;padding-bottom:10px;">';
                }
                $html .= '<a href="' . $this->email_escape($url) . '" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:14px;font-weight:bold;color:#cc2200;text-decoration:none;">' . htmlspecialchars($clean_title) . '</span></a><br/>';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#666666;">' . $date . '</span>';
                $html .= '</td></tr></table>';
                if ($i < $count - 1) {
                    $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#220000;height:1px;font-size:1px;line-height:1px;mso-line-height-rule:exactly;padding:0;">&nbsp;</td></tr></table>';
                }
            }
            $html .= '</td></tr>';
        }

        /* Crónicas */
        if (!empty($cronicas)) {
            $html .= '<tr><td style="padding:24px 30px 0 30px;border-top:1px solid #330000;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
            $html .= '<td style="background-color:#600;padding:6px 14px;"><a href="' . $base . '/index.php?ln=ES&sec=cronicas" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#ffffff;letter-spacing:2px;text-decoration:none;white-space:nowrap;">CR&Oacute;NICAS</span></a></td>';
            $html .= '</tr></table></td></tr>';
            $html .= '<tr><td style="padding:10px 30px 0 30px;">';
            $count = count($cronicas);
            foreach ($cronicas as $i => $cr) {
                $clean_title = strip_tags($cr['titol']);
                $url = $base . '/index.php?ln=ES&sec=cronicas&' . $cr['link'];
                $dt = DateTime::createFromFormat('YmdHis', $cr['data']);
                $date_str = $dt ? $dt->format('d/m/Y') : '';
                $html .= '<table width="540" cellpadding="0" cellspacing="0" border="0"><tr>';
                if (!empty($cr['cartell'])) {
                    $img_src = $base . '/pics/cronicas_pics/' . htmlspecialchars($cr['cartell']);
                    $html .= '<td width="90" valign="middle" style="width:90px;padding-right:14px;padding-bottom:10px;">';
                    $html .= '<img src="' . $img_src . '" width="76" height="52" alt="" style="display:block;border:1px solid #330000;"/>';
                    $html .= '</td>';
                    $html .= '<td width="450" valign="middle" style="width:450px;padding-bottom:10px;">';
                } else {
                    $html .= '<td width="540" valign="middle" style="width:540px;padding-bottom:10px;">';
                }
                $html .= '<a href="' . $this->email_escape($url) . '" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:14px;font-weight:bold;color:#cc2200;text-decoration:none;">' . htmlspecialchars($clean_title) . '</span></a><br/>';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#666666;">' . $date_str . '</span>';
                $html .= '</td></tr></table>';
                if ($i < $count - 1) {
                    $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#220000;height:1px;font-size:1px;line-height:1px;mso-line-height-rule:exactly;padding:0;">&nbsp;</td></tr></table>';
                }
            }
            $html .= '</td></tr>';
        }

        /* Criticas */
        if (!empty($reviews)) {
            $html .= '<tr><td style="padding:24px 30px 0 30px;border-top:1px solid #330000;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
            $html .= '<td style="background-color:#600;padding:6px 14px;"><a href="' . $base . '/index.php?ln=ES&sec=criticas" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#ffffff;letter-spacing:2px;text-decoration:none;white-space:nowrap;">CR&Iacute;TICAS DE LA SEMANA</span></a></td>';
            $html .= '</tr></table></td></tr>';
            $html .= '<tr><td style="padding:10px 30px 0 30px;">';
            $count = count($reviews);
            foreach ($reviews as $i => $r) {
                $url = $base . '/index.php?ln=ES&sec=criticas&' . $r['link'];
                $html .= '<table width="540" cellpadding="0" cellspacing="0" border="0"><tr>';
                $html .= '<td width="70" valign="top" style="width:70px;padding-right:14px;padding-bottom:10px;">';
                $html .= '<img src="' . $base . '/pics/covers/' . htmlspecialchars(ltrim($r['portada'], '/')) . '" width="60" height="60" alt="Portada" style="display:block;border:1px solid #330000;"/>';
                $html .= '</td><td width="470" valign="top" style="width:470px;padding-bottom:10px;">';
                $html .= '<a href="' . $this->email_escape($url) . '" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#cc2200;text-decoration:none;">' . htmlspecialchars($r['banda']) . ' &ndash; ' . htmlspecialchars($r['disc']) . '</span></a><br/>';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#666666;">' . htmlspecialchars($r['estil']) . '</span><br/>';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:12px;color:#cccccc;">Puntuaci&oacute;n: <strong style="color:#cc2200;">' . htmlspecialchars($r['nota']) . '</strong></span>';
                $html .= '</td></tr></table>';
                if ($i < $count - 1) {
                    $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#220000;height:1px;font-size:1px;line-height:1px;mso-line-height-rule:exactly;padding:0;">&nbsp;</td></tr></table>';
                }
            }
            $html .= '</td></tr>';
        }

        /* Conciertos */
        if (!empty($concerts)) {
            $html .= '<tr><td style="padding:24px 30px 0 30px;border-top:1px solid #330000;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
            $html .= '<td style="background-color:#600;padding:6px 14px;"><a href="' . $base . '/index.php?ln=ES&sec=conciertos&type=agenda" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#ffffff;letter-spacing:2px;text-decoration:none;white-space:nowrap;">CONCIERTOS DE LA SEMANA</span></a></td>';
            $html .= '</tr></table></td></tr>';
            $html .= '<tr><td style="padding:10px 30px 0 30px;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
            $count = count($concerts);
            foreach ($concerts as $i => $c) {
                $url = $base . '/index.php?ln=ES&sec=conciertos&type=entrada&id=' . (int)$c['idConcert'];
                $date_str = date('d M', strtotime($c['dateConcert']));
                $html .= '<tr><td style="padding:8px 0;">';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:12px;color:#cc2200;font-weight:bold;">' . $date_str . '</span>&nbsp;&nbsp;';
                $html .= '<a href="' . $this->email_escape($url) . '" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#ffffff;">' . htmlspecialchars(preg_replace('/\s+/', ' ', trim(str_replace(['&nbsp;', "\xc2\xa0"], '', strip_tags($c['Nom']))))) . '</span></a><br/>';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#666666;">' . htmlspecialchars(preg_replace('/\s+/', ' ', trim($c['sala']))) . ' &#8226; ' . htmlspecialchars(preg_replace('/\s+/', ' ', trim($c['localitat']))) . '</span>';
                $html .= '</td></tr>';
                if ($i < $count - 1) {
                    $html .= '<tr><td style="background-color:#1a0000;height:1px;font-size:1px;line-height:1px;mso-line-height-rule:exactly;padding:0;">&nbsp;</td></tr>';
                }
            }
            $html .= '</table></td></tr>';
        }

        /* Entrevistas */
        if (!empty($interviews)) {
            $html .= '<tr><td style="padding:24px 30px 0 30px;border-top:1px solid #330000;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
            $html .= '<td style="background-color:#600;padding:6px 14px;"><a href="' . $base . '/index.php?ln=ES&sec=entrevistasn" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#ffffff;letter-spacing:2px;text-decoration:none;white-space:nowrap;">ENTREVISTAS DE LA SEMANA</span></a></td>';
            $html .= '</tr></table></td></tr>';
            $html .= '<tr><td style="padding:10px 30px 20px 30px;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
            $count = count($interviews);
            foreach ($interviews as $i => $e) {
                $url = $base . '/index.php?ln=ES&sec=entrevistasn&' . $e['link'];
                $date_str = date('d/m/Y', strtotime($e['data']));
                $html .= '<tr><td style="padding:8px 0;">';
                $html .= '<a href="' . $this->email_escape($url) . '" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#cc2200;text-decoration:none;">' . htmlspecialchars(strip_tags($e['titol_es'])) . '</span></a><br/>';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#666666;">' . htmlspecialchars(strip_tags($e['banda'])) . ' &#8226; ' . $date_str . '</span>';
                $html .= '</td></tr>';
                if ($i < $count - 1) {
                    $html .= '<tr><td style="background-color:#1a0000;height:1px;font-size:1px;line-height:1px;mso-line-height-rule:exactly;padding:0;">&nbsp;</td></tr>';
                }
            }
            $html .= '</table></td></tr>';
        }

        /* Metal Report */
        if (!empty($metal_report)) {
            $html .= '<tr><td style="padding:24px 30px 0 30px;border-top:1px solid #330000;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>';
            $html .= '<td style="background-color:#600;padding:6px 14px;"><a href="' . $base . '/index.php?ln=ES&sec=opinion" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:13px;font-weight:bold;color:#ffffff;letter-spacing:2px;text-decoration:none;white-space:nowrap;">METAL REPORT</span></a></td>';
            $html .= '</tr></table></td></tr>';
            $html .= '<tr><td style="padding:10px 30px 0 30px;">';
            $count = count($metal_report);
            foreach ($metal_report as $i => $mr) {
                $url = $base . '/index.php?ln=ES&sec=opinion&type=entrada&id=' . (int)$mr['idopinio'];
                $date_str = date('d/m/Y', strtotime($mr['data']));
                $html .= '<table width="540" cellpadding="0" cellspacing="0" border="0"><tr>';
                if (!empty($mr['ruta'])) {
                    $img_src = $base . '/pics/opinio_pics/' . htmlspecialchars(ltrim($mr['ruta'], '/'));
                    $html .= '<td width="90" valign="middle" style="width:90px;padding-right:14px;padding-bottom:10px;">';
                    $html .= '<img src="' . $img_src . '" width="76" height="52" alt="" style="display:block;border:1px solid #330000;"/>';
                    $html .= '</td>';
                    $html .= '<td width="450" valign="middle" style="width:450px;padding-bottom:10px;">';
                } else {
                    $html .= '<td width="540" valign="middle" style="width:540px;padding-bottom:10px;">';
                }
                $html .= '<a href="' . $this->email_escape($url) . '" style="text-decoration:none;"><span style="font-family:Arial,sans-serif;font-size:14px;font-weight:bold;color:#cc2200;text-decoration:none;">' . htmlspecialchars(strip_tags($mr['titol_es'])) . '</span></a><br/>';
                $html .= '<span style="font-family:Arial,sans-serif;font-size:11px;color:#666666;">' . $date_str . '</span>';
                $html .= '</td></tr></table>';
                if ($i < $count - 1) {
                    $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#220000;height:1px;font-size:1px;line-height:1px;mso-line-height-rule:exactly;padding:0;">&nbsp;</td></tr></table>';
                }
            }
            $html .= '</td></tr>';
        }

        /* Footer */
        $html .= '<tr><td style="background-color:#0d0d0d;border-top:2px solid #600;padding:20px 30px;text-align:center;">';
        if (!empty($token)) {
            $unsubscribe_url = $base . '/unsubscribe.php?token=' . urlencode($token);
            $html .= '<p style="margin:0 0 8px 0;font-family:Arial,sans-serif;font-size:11px;color:#555555;">Est&aacute;s recibiendo este email porque te suscribiste al newsletter de SatanArise.</p>';
            $html .= '<p style="margin:0;"><a href="' . $this->email_escape($unsubscribe_url) . '" style="font-family:Arial,sans-serif;font-size:11px;color:#cc2200;text-decoration:underline;">Darse de baja</a>';
            $html .= '&#160;&#8226;&#160;<a href="' . $base . '" style="font-family:Arial,sans-serif;font-size:11px;color:#666666;text-decoration:none;">satanarise.com</a></p>';
        } else {
            $html .= '<p style="margin:0;"><a href="' . $base . '" style="font-family:Arial,sans-serif;font-size:11px;color:#666666;text-decoration:none;">satanarise.com</a></p>';
        }
        $html .= '</td></tr>';

        $html .= '</table></td></tr></table></body></html>';
        return $html;
    }

    public function send_newsletter($bd)
    {
        $news         = $this->get_newsletter_news($bd);
        $all_cronicas = $this->get_all_week_cronicas($bd);
        $cronicas     = array_values(array_filter($all_cronicas, function($c) { return (int)$c['newsletter'] === 1; }));
        $reviews      = $this->get_week_reviews($bd);
        $concerts     = $this->get_week_concerts($bd);
        $interviews   = $this->get_week_interviews($bd);
        $metal_report = $this->get_week_metal_report($bd);

        $result = $bd->query("SELECT email, unsubscribe_token FROM newsletter_subscribers WHERE active = 1");
        if (!$result) {
            return ['sent' => 0, 'error' => 'no_subscribers'];
        }
        if ($result->num_rows == 0) {
            return ['sent' => 0, 'error' => 'no_subscribers'];
        }

        $subject = 'Newsletter SatanArise';
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: SatanArise <info@satanarise.com>\r\n";
        $headers .= "Reply-To: info@satanarise.com\r\n";

        $sent = 0;
        while ($subscriber = $result->fetch_assoc()) {
            $html = $this->build_email_html($news, $cronicas, $reviews, $concerts, $interviews, $metal_report, $subscriber['unsubscribe_token']);
            $ok = mail($subscriber['email'], $subject, $html, $headers);
            if ($ok) {
                $sent++;
            } else {
                error_log('Newsletter: mail() failed for ' . $subscriber['email']);
            }
        }
        return ['sent' => $sent];
    }

    private function build_next_preview_html($bd)
    {
        $monday      = strtotime('monday this week midnight');
        $next_sunday = $monday + 6 * 86400;
        $from        = date('Y-m-d 00:00:00', $monday);
        $to          = date('Y-m-d 23:59:59', $next_sunday);
        $week_from   = date('d/m/Y', $monday);
        $week_to     = date('d/m/Y', $next_sunday);

        $from_dt  = $bd->real_escape_string($from);
        $to_dt    = $bd->real_escape_string($to);
        $from_ymd = $bd->real_escape_string(date('YmdHis', $monday));
        $to_ymd   = $bd->real_escape_string(date('YmdHis', $next_sunday + 86399));

        $news = [];
        $r = $bd->query("SELECT news.idNews, newscontent.Title, news.dateIn,
                         (SELECT ruta FROM newsdata WHERE newsdata.idNews = news.idNews AND newsdata.tipo = 1 AND newsdata.orden = 1) AS ruta
                  FROM news
                  JOIN newscontent ON news.idNews = newscontent.idNews
                  WHERE news.newsletter = 1 AND newscontent.Idioma = 'ES'
                    AND news.dateIn BETWEEN '$from_dt' AND '$to_dt'
                  ORDER BY news.dateIn DESC");
        if ($r) while ($row = $r->fetch_assoc()) $news[] = $row;

        $reviews = [];
        $r = $bd->query("SELECT reviews.idreviews, reviews.banda, reviews.disc, reviews.portada,
                         reviews.link, reviews.nota, estil.estil
                  FROM reviews LEFT JOIN estil ON reviews.idestil = estil.idestil
                  WHERE reviews.release_date BETWEEN '$from_dt' AND '$to_dt'
                  ORDER BY reviews.release_date DESC");
        if ($r) while ($row = $r->fetch_assoc()) $reviews[] = $row;

        $concerts = $this->get_next_week_concerts($bd);

        $interviews = [];
        $r = $bd->query("SELECT identrevistes, banda, titol_es, link, data
                  FROM entrevnews
                  WHERE (idioma = 'ES' OR idioma = 'BOTH') AND data BETWEEN '$from_ymd' AND '$to_ymd'
                  ORDER BY data DESC");
        if ($r) while ($row = $r->fetch_assoc()) $interviews[] = $row;

        $metal_report = [];
        $r = $bd->query("SELECT idopinio, titol_es, data, ruta
                  FROM opinio
                  WHERE (idioma = 'ES' OR idioma = 'BOTH') AND data BETWEEN '$from_ymd' AND '$to_ymd'
                  ORDER BY data DESC");
        if ($r) while ($row = $r->fetch_assoc()) $metal_report[] = $row;

        $cronicas = [];
        $r = $bd->query("SELECT idcronicas, titol, data, cartell, newsletter, link
                  FROM cronicas
                  WHERE (idioma = 'ES' OR idioma = 'BOTH') AND newsletter = 1
                    AND data BETWEEN '$from_ymd' AND '$to_ymd'
                  ORDER BY data DESC");
        if ($r) while ($row = $r->fetch_assoc()) $cronicas[] = $row;

        return $this->build_email_html($news, $cronicas, $reviews, $concerts, $interviews, $metal_report, '', $week_from, $week_to);
    }

    public function render_send_form($bd)
    {
        $count      = $this->count_active_subscribers($bd);
        $auto       = $this->get_auto_status($bd);
        $all_news     = $this->get_all_week_news($bd);
        $news         = array_values(array_filter($all_news, function($n) { return (int)$n['newsletter'] === 1; }));
        $all_cronicas = $this->get_all_week_cronicas($bd);
        $cronicas     = array_values(array_filter($all_cronicas, function($c) { return (int)$c['newsletter'] === 1; }));
        $reviews      = $this->get_week_reviews($bd);
        $concerts     = $this->get_week_concerts($bd);
        $interviews   = $this->get_week_interviews($bd);
        $metal_report = $this->get_week_metal_report($bd);

        list($from, $to) = $this->get_prev_week_range();

        print '<p class="titol_parcial">Newsletter</p>';
        print '<p class="terminal">Suscriptores activos: ' . $count . '</p>';

        /* Settings form */
        print '<form action="home_cp.php?sec=newsletter&action=main" method="post" style="margin-bottom:20px;">';
        print '<input type="hidden" name="nl_action" value="save_auto" />';
        $checked = ($auto == 1) ? ' checked="checked"' : '';
        print '<p class="contingut"><input type="checkbox" name="newsletter_auto" value="1"' . $checked . ' /> Enviar newsletter autom&aacute;ticamente cada semana (primer acceso del lunes)</p>';
        print '<input type="submit" value="Guardar configuraci&oacute;n" /></form>';

        /* Preview */
        print '<p class="titol_parcial">Contenido de la semana anterior (' . date('d/m/Y', strtotime($from)) . ' - ' . date('d/m/Y', strtotime($to)) . ')</p>';

        $news_marked = count($news);
        print '<p class="contingut"><strong>Noticias:</strong> ';
        if (empty($all_news)) {
            print '<span style="color:#cc2200;">Sin noticias esta semana.</span></p>';
        } else {
            print $news_marked . ' de ' . count($all_news) . ' marcadas</p>';
            print '<form action="home_cp.php?sec=newsletter&action=main" method="post" style="margin:4px 0 16px 0;">';
            print '<input type="hidden" name="nl_action" value="save_news_selection" />';
            print '<table cellpadding="3" cellspacing="0" border="0">';
            foreach ($all_news as $n) {
                $checked = ((int)$n['newsletter'] === 1) ? ' checked="checked"' : '';
                $color   = ((int)$n['newsletter'] === 1) ? '#ffffff' : '#666666';
                print '<tr>';
                print '<td style="vertical-align:middle;"><input type="checkbox" name="nl_news[]" value="' . (int)$n['idNews'] . '"' . $checked . ' /></td>';
                print '<td class="contingut" style="color:' . $color . ';padding-left:6px;">' . htmlspecialchars(strip_tags($n['Title'])) . '</td>';
                print '<td class="contingut" style="color:#555;padding-left:10px;">' . date('d/m/Y', strtotime($n['dateIn'])) . '</td>';
                print '</tr>';
            }
            print '</table>';
            print '<input type="submit" value="Guardar selecci&oacute;n" style="margin-top:8px;padding:4px 12px;" />';
            print '</form>';
        }

        $cronicas_marked = count($cronicas);
        print '<p class="contingut"><strong>Cr&oacute;nicas:</strong> ';
        if (empty($all_cronicas)) {
            print '<span style="color:#cc2200;">Sin cr&oacute;nicas esta semana.</span></p>';
        } else {
            print $cronicas_marked . ' de ' . count($all_cronicas) . ' marcadas</p>';
            print '<form action="home_cp.php?sec=newsletter&action=main" method="post" style="margin:4px 0 16px 0;">';
            print '<input type="hidden" name="nl_action" value="save_cronicas_selection" />';
            print '<table cellpadding="3" cellspacing="0" border="0">';
            foreach ($all_cronicas as $cr) {
                $ck    = ((int)$cr['newsletter'] === 1) ? ' checked="checked"' : '';
                $color = ((int)$cr['newsletter'] === 1) ? '#ffffff' : '#666666';
                $dt    = DateTime::createFromFormat('YmdHis', $cr['data']);
                $dstr  = $dt ? $dt->format('d/m/Y') : '';
                print '<tr>';
                print '<td style="vertical-align:middle;"><input type="checkbox" name="nl_cronicas[]" value="' . (int)$cr['idcronicas'] . '"' . $ck . ' /></td>';
                if (!empty($cr['cartell'])) {
                    print '<td style="vertical-align:middle;padding-left:6px;"><img src="../pics/cronicas_pics/' . htmlspecialchars($cr['cartell']) . '" height="30" style="display:block;" /></td>';
                } else {
                    print '<td></td>';
                }
                print '<td class="contingut" style="color:' . $color . ';padding-left:6px;">' . htmlspecialchars(strip_tags($cr['titol'])) . '</td>';
                print '<td class="contingut" style="color:#555;padding-left:10px;">' . $dstr . '</td>';
                print '</tr>';
            }
            print '</table>';
            print '<input type="submit" value="Guardar selecci&oacute;n" style="margin-top:8px;padding:4px 12px;" />';
            print '</form>';
        }

        print '<p class="contingut"><strong>Cr&iacute;ticas:</strong> ';
        if (empty($reviews)) {
            print 'Sin cr&iacute;ticas esta semana.';
        } else {
            print count($reviews) . ' cr&iacute;tica(s)';
        }
        print '</p>';

        print '<p class="contingut"><strong>Conciertos:</strong> ';
        if (empty($concerts)) {
            print 'Sin conciertos esta semana.';
        } else {
            print count($concerts) . ' concierto(s)';
        }
        print '</p>';

        print '<p class="contingut"><strong>Entrevistas:</strong> ';
        if (empty($interviews)) {
            print 'Sin entrevistas esta semana.';
        } else {
            print count($interviews) . ' entrevista(s)';
        }
        print '</p>';

        print '<p class="contingut"><strong>Metal Report:</strong> ';
        if (empty($metal_report)) {
            print 'Sin Metal Report esta semana.';
        } else {
            print count($metal_report) . ' art&iacute;culo(s)';
        }
        print '</p>';

        /* Manual send form */
        print '<form action="home_cp.php?sec=newsletter&action=main" method="post">';
        print '<input type="hidden" name="nl_action" value="send_now" />';
        print '<input type="submit" value="Enviar newsletter ahora" style="background:#600;color:#fff;border:none;padding:8px 16px;cursor:pointer;" />';
        print '</form>';

        /* Two-column preview */
        $monday    = strtotime('monday this week midnight');
        $last_html = $this->build_email_html($news, $cronicas, $reviews, $concerts, $interviews, $metal_report, '');
        $next_html = $this->build_next_preview_html($bd);

        print '<p class="titol_parcial" style="margin-top:32px;">Previsualizaci&oacute;n</p>';

        /* Next-week news checklist */
        $all_current_news  = $this->get_all_current_week_news($bd);
        $current_week_from = date('d/m/Y', $monday);
        $current_week_to   = date('d/m/Y', $monday + 6 * 86400);
        $current_marked    = count(array_filter($all_current_news, function($n) { return (int)$n['newsletter'] === 1; }));
        print '<p class="contingut"><strong>Noticias pr&oacute;ximo newsletter</strong> (' . $current_week_from . ' &ndash; ' . $current_week_to . '): ';
        if (empty($all_current_news)) {
            print '<span style="color:#666;">Sin noticias esta semana.</span></p>';
        } else {
            print $current_marked . ' de ' . count($all_current_news) . ' marcadas</p>';
            print '<form action="home_cp.php?sec=newsletter&action=main" method="post" style="margin:4px 0 16px 0;">';
            print '<input type="hidden" name="nl_action" value="save_next_news_selection" />';
            print '<table cellpadding="3" cellspacing="0" border="0">';
            foreach ($all_current_news as $n) {
                $checked = ((int)$n['newsletter'] === 1) ? ' checked="checked"' : '';
                $color   = ((int)$n['newsletter'] === 1) ? '#ffffff' : '#666666';
                print '<tr>';
                print '<td style="vertical-align:middle;"><input type="checkbox" name="nl_next_news[]" value="' . (int)$n['idNews'] . '"' . $checked . ' /></td>';
                print '<td class="contingut" style="color:' . $color . ';padding-left:6px;">' . htmlspecialchars(strip_tags($n['Title'])) . '</td>';
                print '<td class="contingut" style="color:#555;padding-left:10px;">' . date('d/m/Y', strtotime($n['dateIn'])) . '</td>';
                print '</tr>';
            }
            print '</table>';
            print '<input type="submit" value="Guardar selecci&oacute;n" style="margin-top:8px;padding:4px 12px;" />';
            print '</form>';
        }

        print '<div style="display:flex;gap:24px;overflow-x:auto;padding-bottom:16px;">';

        print '<div style="flex:0 0 auto;">';
        print '<p class="contingut" style="margin-bottom:6px;"><strong>&Uacute;ltimo newsletter</strong> &mdash; ' . date('d/m/Y', strtotime($from)) . ' &ndash; ' . date('d/m/Y', strtotime($to)) . '</p>';
        print '<iframe srcdoc="' . htmlspecialchars($last_html, ENT_QUOTES, 'UTF-8') . '" width="600" height="700" style="display:block;border:2px solid #600;"></iframe>';
        print '</div>';

        print '<div style="flex:0 0 auto;">';
        print '<p class="contingut" style="margin-bottom:6px;"><strong>Pr&oacute;ximo newsletter</strong> &mdash; ' . date('d/m/Y', $monday) . ' &ndash; ' . date('d/m/Y', $monday + 6 * 86400) . '</p>';
        print '<iframe srcdoc="' . htmlspecialchars($next_html, ENT_QUOTES, 'UTF-8') . '" width="600" height="700" style="display:block;border:2px solid #333;"></iframe>';
        print '</div>';

        print '</div>';
    }
}
?>
