<?php

class ob_noticias_web
{
    public $id;
    public $resultat_consulta;
    public $numero_resultats;
    public $noticia_individual;

    public function __construct()
    {
        $this->id = '';
        $this->numero_resultats = 0;
        $this->punter = 1;
        $this->quantitat = 10;
        $this->noticia_individual = false;
    }

    public function estructurar_noticia($noticia, $bd, $desti)
    {
        for ($i = 0; $i < $this->numero_resultats; $i++) {
            $noticia->reset_noticia();
            $resultat = $this->resultat_consulta->fetch_assoc();
            $noticia->id = $resultat['idNews'];
            $noticia->titol = $resultat['Title'];
            $noticia->texte = $resultat['Body'];
            $noticia->tipus = $resultat['type'];
            $noticia->descripcio = $resultat['descripcio'];
            $noticia->timestamp = $resultat['dateIn'];
            $noticia->idioma = $resultat['Idioma'];
            $noticia->imatge1 = $resultat['ruta'];
            $noticia->dia = substr($noticia->timestamp, 8, 2);
            $noticia->any = substr($noticia->timestamp, 0, 4);
            $noticia->mes = substr($noticia->timestamp, 5, 2);
            switch ($desti) {
                case 'noticies':
                    if ($noticia->tipus == 2) {
                        $query =
                            'select ruta from newsdata where idNews = ' .
                            $noticia->id .
                            ' and tipo = 2';
                        $resultat2 = $bd->query($query);
                        if ($resultat2 != false && $resultat2->num_rows == 1) {
                            $resultat3 = $resultat2->fetch_assoc();
                            $noticia->video = $resultat3['ruta'];
                        }
                    }
                    $query =
                        'select ruta from newsdata where idNews = ' .
                        $noticia->id .
                        ' and tipo = 1 order by orden asc';
                    $resultat2 = $bd->query($query);
                    if ($resultat2 != false) {
                        for ($y = 0; $y < $resultat2->num_rows; $y++) {
                            $num = $y + 1;
                            $var = 'imatge' . $num;
                            $resultat3 = $resultat2->fetch_assoc();
                            $noticia->$var = $resultat3['ruta'];
                            $noticia->control_imatges = 'si';
                            $noticia->num_imatges = $noticia->num_imatges + 1;
                        }
                    }
                    $this->mostrar_noticia($noticia);
                    break;
                case 'index':
                    $this->mostrar_noticia_index($noticia, $i);
                    if ($i == 11) {
                        $i = $this->numero_resultats;
                    }
                    break;
                case 'individual':
                    if ($noticia->tipus == 2) {
                        $query =
                            'select ruta from newsdata where idNews = ' .
                            $noticia->id .
                            ' and tipo = 2';
                        $resultat2 = $bd->query($query);
                        if ($resultat2 != false && $resultat2->num_rows == 1) {
                            $resultat3 = $resultat2->fetch_assoc();
                            $noticia->video = $resultat3['ruta'];
                        }
                    }
                    $query =
                        'select ruta from newsdata where idNews = ' .
                        $noticia->id .
                        ' and tipo = 1 order by orden asc';
                    $resultat2 = $bd->query($query);
                    if ($resultat2 != false) {
                        for ($y = 0; $y < $resultat2->num_rows; $y++) {
                            $num = $y + 1;
                            $var = 'imatge' . $num;
                            $resultat3 = $resultat2->fetch_assoc();
                            $noticia->$var = $resultat3['ruta'];
                            $noticia->control_imatges = 'si';
                            $noticia->num_imatges = $noticia->num_imatges + 1;
                        }
                    }
                    $this->mostrar_noticia_individual($noticia);
                    break;
            }
        }
    }

    public function extreure_noticies($bd, $idioma, $punter, $quantitat)
    {
        /* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
        /* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
        $inici = $punter - 1;
        $query =
            "SELECT news.idNews, descripcio, newscontent.Idioma, Title, Body, type, news.dateIn, ruta FROM news INNER JOIN newscontent ON news.idNews = newscontent.idNews LEFT JOIN newsdata ON news.idNews = newsdata.idNews AND newsdata.tipo = 1 AND newsdata.orden = 1 WHERE newscontent.Idioma = '" .
            $idioma .
            "' AND news.idNews=newscontent.idNews ORDER BY news.dateIn desc limit " .
            $inici .
            ', ' .
            $quantitat;
        $this->resultat_consulta = $bd->query($query);
        if ($this->resultat_consulta != false) {
            $this->numero_resultats = $this->resultat_consulta->num_rows;
        }
    }
    public function extreure_noticia($bd, $id, $idioma)
    {
        /* consulta noticies a la bbdd a partir d'una id */
        $error = true;
        $query =
            "select news.idNews, type, descripcio, newscontent.Idioma, news.dateIn, Title, Body
			FROM news, newscontent
			WHERE newscontent.idNews = " .
            $id .
            ' and news.idNews = ' .
            $id .
            " and newscontent.Idioma='" .
            $idioma .
            "'";
        $this->resultat_consulta = $bd->query($query);
        if ($this->resultat_consulta != false) {
            $this->numero_resultats = $this->resultat_consulta->num_rows;
            if ($this->numero_resultats == 0) {
                $error = false;
            }
        } else {
            $error = false;
        }
        return $error;
    }

    public function mostrar_noticia($noticia)
    {
        print '<meta property="og:image" content="' .
            $noticia->imatge1 .
            '" />';
        print '<div class="noticia">
			<div class="data_not">' .
            $noticia->dia .
            ' / ' .
            $noticia->mes .
            ' / ' .
            $noticia->any .
            '</div>';

        switch ($noticia->idioma) {
            case 'ES':
                $section = 'noticias';
                break;
            case 'CAT':
                $section = 'noticies';
                break;
        }
        print '<h1 class="tit"><a class="linkk" href="index.php?ln=' .
            $noticia->idioma .
            '&sec=' .
            $section .
            '&id=' .
            $noticia->id .
            '&noticia=' .
            urlencode($noticia->titol) .
            '"> ' .
            $noticia->titol .
            '</a></h1>';

        if ($noticia->control_imatges == 'si') {
            $tamany = [];
            $tamany = getimagesize($noticia->imatge1);
            /* Es mesuren les proporcions a 154 alçada */

            $ample = floor((150 * $tamany[0]) / $tamany[1]);
            if ($tamany[0] > $tamany[1]) {
                /* mes ample me alt */
                if ($tamany[0] > 600) {
                    $tam_imp = 'width="600"';
                } else {
                    $tam_imp = 'width="' . $tamany[0] . '"';
                }
            } elseif ($tamany[0] < $tamany[1]) {
                /* mes alt que llarg */
                if ($tamany[1] > 350) {
                    $tam_imp = 'height="350"';
                } else {
                    $tam_imp = 'height="' . $tamany[0] . '"';
                }
            } elseif ($tamany[0] == $tamany[1]) {
                if ($tamany[0] < 300) {
                    $tam_imp = 'width="300"';
                } else {
                    $tam_imp = 'width="' . $tamany[0] . '"';
                }
            }
            print '<div class="centrar"><a href="' .
                $noticia->imatge1 .
                '" rel="lightbox[' .
                $noticia->id .
                ']" title="' .
                $noticia->titol .
                '"><img src = "' .
                $noticia->imatge1 .
                '" ' .
                $tam_imp .
                ' alt="' .
                $noticia->titol .
                '" /></a></div>';
        }
        $noticia->texte = nl2br($this->tractar_tag_link(1, $noticia->texte));
        $noticia->texte = $this->posar_negretes(
            $noticia->texte,
            $noticia->descripcio
        );
        print '<p>' . $noticia->texte . '</p>';
        if ($noticia->tipus == 2) {
            print '<div class="centrar">
   	         	<iframe width="600" height="338" src="http://www.youtube.com/embed/' .
                $noticia->video .
                '?rel=0" frameborder="0" allowfullscreen></iframe>
	            </div><br />';
        }
        if ($noticia->num_imatges > 1) {
            print '<div class="centrar">';
            for ($i = 2; $i <= $noticia->num_imatges; $i++) {
                $var = 'imatge' . $i;
                print '<a href="' .
                    $noticia->$var .
                    '" rel="lightbox[' .
                    $noticia->id .
                    ']" title="' .
                    $noticia->titol .
                    '"><img class="general" src = "' .
                    $noticia->$var .
                    '" width="300" alt="' .
                    $noticia->titol .
                    '" /></a>';
            }
            print '</div>';
        }
        print '</div>';
    }

    public function mostrar_noticia_individual($noticia)
    {
        print '<div class="noticia">
			<div class="data_not">' .
            $noticia->dia .
            ' / ' .
            $noticia->mes .
            ' / ' .
            $noticia->any .
            '</div>';

        print '<h1 class="tit_centrada">' . $noticia->titol . '</h1>';
        if ($noticia->control_imatges == 'si') {
            $tamany = [];
            $tamany = getimagesize($noticia->imatge1);
            /* Es mesuren les proporcions a 154 alçada */

            $ample = floor((150 * $tamany[0]) / $tamany[1]);
            if ($tamany[0] > $tamany[1]) {
                /* mes ample me alt */
                if ($tamany[0] > 600) {
                    $tam_imp = 'width="600"';
                } else {
                    $tam_imp = 'width="' . $tamany[0] . '"';
                }
            } elseif ($tamany[0] < $tamany[1]) {
                /* mes alt que llarg */
                if ($tamany[0] > 350) {
                    $tam_imp = 'height="350"';
                } else {
                    $tam_imp = 'height="' . $tamany[0] . '"';
                }
            } elseif ($tamany[0] == $tamany[1]) {
                if ($tamany[0] < 300) {
                    $tam_imp = 'width="300"';
                } else {
                    $tam_imp = 'width="' . $tamany[0] . '"';
                }
            }
            print '<div class="centrar"><a href="' .
                $noticia->imatge1 .
                '" rel="lightbox[' .
                $noticia->id .
                ']" title="' .
                $noticia->titol .
                '"><img src = "' .
                $noticia->imatge1 .
                '" ' .
                $tam_imp .
                ' alt="' .
                $noticia->titol .
                '" /></a></div>';
        }
        //$noticia->texte=$this->posar_negretes(nl2br($this->tractar_tag_link(1,$noticia->texte)),$noticia->descripcio);

        $noticia->texte = nl2br($this->tractar_tag_link(1, $noticia->texte));
        $noticia->texte = $this->posar_negretes(
            $noticia->texte,
            $noticia->descripcio
        );
        print '<p>' . $noticia->texte . '</p>';
        if ($noticia->tipus == 2) {
            print '<div class="centrar">
   	         	<iframe width="600" height="338" src="http://www.youtube.com/embed/' .
                $noticia->video .
                '?rel=0" frameborder="0" allowfullscreen></iframe>
	            </div><br />';
        }
        if ($noticia->num_imatges > 1) {
            print '<div class="centrar">';
            for ($i = 2; $i <= $noticia->num_imatges; $i++) {
                $var = 'imatge' . $i;
                print '<a href="' .
                    $noticia->$var .
                    '" rel="lightbox[' .
                    $noticia->id .
                    ']" title="' .
                    $noticia->titol .
                    '"><img class="general" src = "' .
                    $noticia->$var .
                    '" width="300" alt="' .
                    $noticia->titol .
                    '" /></a>';
            }
            print '</div>';
        }
        ?>
<!-- AddThis Button BEGIN -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<div class="addthis_inline_share_toolbox"></div>
<!--<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>-->

<!-- AddThis Button END -->
<?php print '</div>';
    }

    public function mostrar_noticia_index($noticia, $control_tags)
    {
        if ($control_tags % 4 == 0) {
            /*parell*/
            print '<div class="not">';
        }
        print '<div class="notind">';
        switch ($noticia->idioma) {
            case 'ES':
                $section = 'noticias';
                break;
            case 'CAT':
                $section = 'noticies';
                break;
        }
        $titolAux = substr($noticia->titol, 0, 75);
        if ($titolAux != $noticia->titol) {
            $titolAux .= '...';
        }
        print '<h1><a class="linkk" href="index.php?ln=' .
            $noticia->idioma .
            '&sec=' .
            $section .
            '&id=' .
            $noticia->id .
            '&noticia=' .
            urlencode($noticia->titol) .
            '"> ' .
            $titolAux .
            '</a></h1>';
        $noticia->texte = $this->tractar_tag_link(2, $noticia->texte);
        print '<div class="contimgnot"><a href="index.php?ln=' .
            $noticia->idioma .
            '&sec=' .
            $section .
            '&id=' .
            $noticia->id .
            '&noticia=' .
            urlencode($noticia->titol) .
            '" title="' .
            $noticia->titol .
            '">
				<img src = "' .
            $noticia->imatge1 .
            '" alt="' .
            $noticia->titol .
            '" /></a></div>	';
        print '<p>' . substr($noticia->texte, 0, 115) . '...</p></div>';
        if (
            $control_tags % 4 == 3 ||
            $control_tags == $this->numero_resultats - 1
        ) {
            print '</div>';
        }
    }

    public function tractar_tag_link($opcio, $texte)
    {
        /* Als textes busca el tag [link] www.xemple.es [link] on www.exemple.es es una adreça url completa sense els http i si opcio es 1 el converteix en un link class linkk i la resta del texte el tracta per caracterls especials html i si es 2 ignira els tags i els treu del texte i el filtra per caracters html */

        $array_texte = explode('[link]', $texte);
        $texte = '';
        switch ($opcio) {
            case '1' /* [link]www.exemple.es[link] -> <a class="linkk" href="http://www.exemple.es">www.exemple.es</a> */:
                for ($i = 0; $i < count($array_texte); $i++) {
                    if (substr($texte, 0, 6) == '[link]') {
                        if ($i % 2 == 0) {
                            $texte =
                                $texte .
                                '<a class="linkk" target="_blank" href="http://' .
                                $array_texte[$i] .
                                '">' .
                                $array_texte[$i] .
                                '</a>';
                        } else {
                            /*$texte=$texte.htmlspecialchars($array_texte[$i]);*/
                            $texte = $texte . $array_texte[$i];
                        }
                    } else {
                        if ($i % 2 != 0) {
                            $texte =
                                $texte .
                                '<a class="linkk" target="_blank" href="http://' .
                                $array_texte[$i] .
                                '">' .
                                $array_texte[$i] .
                                '</a>';
                        } else {
                            /*$texte=$texte.htmlspecialchars($array_texte[$i]);*/
                            $texte = $texte . $array_texte[$i];
                        }
                    }
                }
                break;

            case '2' /* Anula le tag [link]www.exemple.s[link] -> www.exemple.es i el filtra per caracters html */:
                for ($i = 0; $i < count($array_texte); $i++) {
                    $texte = $texte . $array_texte[$i];
                }
                /*$texte=htmlspecialchars($texte);*/
                break;
        }
        return $texte;
    }

    public function posar_negretes($text, $tags)
    {
        if ($tags != '') {
            $paraules = explode(',', $tags);
            for ($i = 0; $i < count($paraules); $i++) {
                /*$paraules[$i]=htmlspecialchars(trim($paraules[$i]));*/
                $paraules[$i] = trim($paraules[$i]);
                $text = str_replace(
                    $paraules[$i],
                    '<span class="cursiva">' . $paraules[$i] . '</span>',
                    $text
                );
            }
        }
        return $text;
    }
} ?>	