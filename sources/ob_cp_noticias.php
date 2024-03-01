<?php
class cp_noticia
{

	public $formulari_ok; /* control dels formularis */
	public $titol_es;
	public $texte_es;
	public $titol_cat;
	public $texte_cat;
	public $idioma; /* ES - CAT - BOTH */
	public $tipus;
	public $video;

	public $imgs;
	public $control_imatges;
	public $enviat;
	public $dia;
	public $mes;
	public $any;
	public $hora;
	public $mins;
	public $segs;
	public $error;
	public $resultat_consulta;
	public $resultat_consulta_es;
	public $resultat_consulta_cat;
	public $numero_resultats;
	public $timestamp;
	public $id;
	public $descripcio; /* tags */



	public function __construct()
	{
		$this->formulari_ok = FALSE;
		$this->error = 'Error: ';
		$this->control_imatges = 'no';
		$this->timestamp = '';
		$this->imgs = array('', '', '', '', '', '');
	}

	public function recull_parametres($formulari) /* Mira si hi ha un formulari enviat i recull parametres */
	{
		if ($_POST['enviat'] == 'si') {
			$this->formulari_ok = TRUE;
			$this->titol_es = htmlspecialchars(trim($_POST['titol_es']));
			$this->titol_cat = htmlspecialchars(trim($_POST['titol_cat']));
			$this->texte_es = ($_POST['texte_es']);
			$this->texte_cat = ($_POST['texte_cat']);
			$this->idioma = $_POST['idioma'];
			$this->tipus = $_POST['tipus'];
			$this->video = $_POST['video'];
			$this->timestamp = $_POST['timestamp'];
			$this->descripcio = $_POST['descripcio'];
			if ($this->video != '') {
				$this->video = trim($this->video);
			}
			if ($this->timestamp == '')
				$this->timestamp = (date('Y-m-d H:i:s'));
			$time_file = str_replace('-', '', $this->timestamp);
			$time_file = str_replace(' ', '', $time_file);
			$time_file = str_replace(':', '', $time_file);
			$arxius = array('file_1', 'file_2', 'file_3', 'file_4', 'file_5');
			for ($i = 0; $i < 5; $i++) {          /* Recollir imatge */
				if ($_FILES[$arxius[$i]]['error'] > 0)
				/* Comprovacio erros al pujar */{
					switch ($_FILES[$arxius[$i]]['error']) {
						case 1:
							$this->error = $this->error . 'El archivo ' . ($i + 1) . ' excede del tamaño máximo.<br />';
							$this->formulari_ok = FALSE;
							break;
						case 2:
							$this->error = $this->error . 'El archivo ' . ($i + 1) . ' excede del tamaño máximo.<br />';
							$this->formulari_ok = FALSE;
							break;
						case 4:
							break;
						default:
							$this->error = $this->error . 'Error al subir el archivo ' . ($i + 1) . '.<br />';
							$this->formulari_ok = FALSE;
							break;
					}
					/* si hi ha imatge, copiarla */
					print '<p>Passo per aqui al pas' . $i . '</p>';
					if (isset($_POST['arxius_' . ($i + 1)])) {
						$this->imgs[$i] = $_POST['arxius_' . ($i + 1)];
					}


				} else {
					$ext = '';
					if (stristr($_FILES[$arxius[$i]]['name'], '.webp') != FALSE)
						$ext = '.webp';
					if (stristr($_FILES[$arxius[$i]]['name'], '.jpg') != FALSE)
						$ext = '.jpg';
					if (stristr($_FILES[$arxius[$i]]['name'], '.jpeg') != FALSE)
						$ext = '.jpeg';
					if (stristr($_FILES[$arxius[$i]]['name'], '.gif') != FALSE)
						$ext = '.gif';
					if (stristr($_FILES[$arxius[$i]]['name'], '.png') != FALSE)
						$ext = '.png';
					if ($ext == '') {
						$this->error = $this->error . 'El archivo no es una imagen ' . ($i + 1) . '.<br />';
						$this->formulari_ok = FALSE;
					} else {
						$directori = '../pics/not/' . $time_file . '_' . ($i + 1) . $ext;
						if (is_uploaded_file($_FILES[$arxius[$i]]['tmp_name'])) {
							if (!move_uploaded_file($_FILES[$arxius[$i]]['tmp_name'], $directori)) {
								$this->error = $this->error . 'Error al subir la imagen ' . ($i + 1) . ' a su carpeta.<br />';
								$this->formulari_ok = FALSE;
							} else {
								$this->imgs[$i] = 'pics/not/' . $time_file . '_' . ($i + 1) . $ext;

							}
						} else {
							$this->error = $this->error . 'Error al subir la imagen ' . ($i + 1) . '.<br />';
							$this->formulari_ok = FALSE;
						}
					}
				}

			}
		}
		return ($this->formulari_ok);
	}

	public function validar_entrada()
	{
		switch ($this->idioma) {
			case 'ES':
				if ($this->titol_es == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Título ES ';
				}
				if ($this->texte_es == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Contenido ES ';
				}
				break;
			case 'CAT':
				if ($this->titol_cat == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Título CAT ';
				}
				if ($this->texte_cat == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Contenido CAT ';
				}
				break;
			case 'BOTH':
				if ($this->titol_es == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Título ES ';
				}
				if ($this->texte_es == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Contenido ES ';
				}
				if ($this->titol_cat == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Título CAT ';
				}
				if ($this->texte_cat == '') {
					$this->formulari_ok = FALSE;
					$this->error = $this->error . 'Contenido CAT ';
				}
				break;
		}
		if ($this->control_imatges == 'si') {
			if (($this->imatge1 == '') && ($this->imatge2 == '') && ($this->imatge3 == '') && ($this->imatge4 == '') && ($this->imatge5 == '') && ($this->imatge6 == '') && ($this->imatge7 == '') && ($this->imatge8 == '') && ($this->imatge9 == '') && ($this->imatge10 == '')) {
				$this->formulari_ok = FALSE;
				$this->error = $this->error . 'Has indicado que hay imagenes pero no has indicado su nombre ';
			}
		}
		if (($this->tipus == '2') && ($this->video == '')) {
			$this->formulari_ok = FALSE;
			$this->error = $this->error . 'No hay codigo de video';
		}
		return ($this->formulari_ok);
	}


	public function introduir($bs, $logica_id, $id)
	{
		$this->titol_es = addslashes($this->titol_es);
		$this->texte_es = addslashes($this->texte_es);
		$this->titol_cat = addslashes($this->titol_cat);
		$this->texte_cat = addslashes($this->texte_cat);
		$this->descripcio = addslashes($this->descripcio);

		if ($logica_id) {
			$query1 = "insert into news (idNews, type, dateIn, descripcio) values ('" . $id . "', '" . $this->tipus . "', '" . $this->timestamp . "', '" . $this->descripcio . "')";
			switch ($this->idioma) {
				case 'ES':
					$query2 = "insert into newscontent (idNews, Idioma, Title, Body, dateIn) values ('" . $id . "', 'ES', '" . $this->titol_es . "', '" . $this->texte_es . "', '" . $this->timestamp . "')";
					break;
				case 'CAT':
					$query2 = "insert into newscontent (idNews, Idioma, Title, Body, dateIn) values ('" . $id . "', 'CAT', '" . $this->titol_cat . "', '" . $this->texte_cat . "', '" . $this->timestamp . "')";
					break;
				case 'BOTH':
					$query2 = "insert into newscontent (idNews, Idioma, Title, Body, dateIn) values ('" . $id . "', 'ES', '" . $this->titol_es . "', '" . $this->texte_es . "', '" . $this->timestamp . "')";
					$query3 = "insert into newscontent (idNews, Idioma, Title, Body, dateIn) values ('" . $id . "', 'CAT', '" . $this->titol_cat . "', '" . $this->texte_cat . "', '" . $this->timestamp . "')";
					break;
			}

		} else {
			$query1 = "insert into news (type, dateIn, descripcio) values ('" . $this->tipus . "', '" . $this->timestamp . "', '" . $this->descripcio . "')";
			switch ($this->idioma) {
				case 'ES':
					$query2 = "insert into newscontent (idNews, title, body, dateIn, idioma) values ((select idNews from news order by idNews desc limit 1), '" . $this->titol_es . "', '" . $this->texte_es . "', '" . $this->timestamp . "', 'ES')";
					break;
				case 'CAT':
					$query2 = "insert into newscontent (idNews, title, body, dateIn, idioma) values ((select idNews from news order by idNews desc limit 1), '" . $this->titol_cat . "', '" . $this->texte_cat . "', '" . $this->timestamp . "', 'CAT')";
					break;
				case 'BOTH':
					$query2 = "insert into newscontent (idNews, title, body, dateIn, idioma) values ((select idNews from news order by idNews desc limit 1), '" . $this->titol_es . "', '" . $this->texte_es . "', '" . $this->timestamp . "', 'ES')";
					$query3 = "insert into newscontent (idNews, title, body, dateIn, idioma) values ((select idNews from news order by idNews desc limit 1), '" . $this->titol_cat . "', '" . $this->texte_cat . "', '" . $this->timestamp . "', 'CAT')";
					break;
			}

		}
		$this->resultat_consulta = $bs->query($query1);
		if ($this->resultat_consulta) {
			print '<p class="terminal">¡¡Noticia añadida en tabla news!!</p>';
		} else {
			print '<p class="terminal">Error, la noticia no ha podido ser añadida en la tabla news.</p>';
		}
		switch ($this->idioma) {
			case 'ES':
				$this->resultat_consulta = $bs->query($query2);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Noticia ES añadida en tabla newscontent!!</p>';
				} else {
					print '<p class="terminal">Error, la noticia ES no ha podido ser añadida en la tabla newscontent.</p>';
				}
				break;
			case 'CAT':
				$this->resultat_consulta = $bs->query($query2);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Noticia CAT añadida en la tabla newscontent!!</p>';
				} else {
					print '<p class="terminal">Error, la noticia CAT no ha podido ser añadida en la tabla newscontent.</p>';
				}
				break;
			case 'BOTH':
				$this->resultat_consulta = $bs->query($query2);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Noticia ES añadida en la tabla newscontent!!</p>';
				} else {
					print '<p class="terminal">Error, la noticia ES no ha podido ser añadida en la tabla newscontent.</p>';
				}
				$this->resultat_consulta = $bs->query($query3);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Noticia añadida CAT en la tabla newscontent!!</p>';
				} else {
					print '<p class="terminal">Error, la noticia CAT no ha podido ser añadida en la tabla newscontent.</p>';
				}
				break;
		}
		$contador = 1;
		for ($i = 0; $i < 5; $i++) {
			if ($this->imgs[$i] != '') {
				$this->imgs[$i] = addslashes($this->imgs[$i]);

				if ($logica_id) {
					$query = "insert into newsdata (orden, idNews, tipo, ruta) values (" . $contador . ", '" . $id . "', '1', '" . $this->imgs[$i] . "')";
				} else {
					$query = "insert into newsdata (orden, idNews, tipo, ruta) values (" . $contador . ", (select idNews from news order by idNews desc limit 1), '1', '" . $this->imgs[$i] . "')";
				}
				$this->resultat_consulta = $bs->query($query);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Imagen ' . ($i + 1) . ' añadida correctamente!!</p>';
					$contador = $contador + 1;
				} else {
					print '<p class="terminal">No se ha podido añadir la imagen ' . ($i + 1) . '.</p>';
				}
			}

		}
		if ($this->tipus == '2') {
			/* si hi ha video */
			$this->video = addslashes($this->video);

			if ($logica_id) {
				$query = "insert into newsdata (orden, idNews, tipo, ruta) values (" . $contador . ", '" . $id . "', 2, '" . $this->video . "')";
			} else {
				$query = "insert into newsdata (orden, idNews, tipo, ruta) values (" . $contador . ", (select idNews from news order by idNews desc limit 1), 2, '" . $this->video . "')";
			}
			$this->resultat_consulta = $bs->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">¡¡Video añadido a la noticia!!</p>';
			} else {
				print '<p class="terminal">No se ha podido añadir el video.</p>';
			}

		}

	}

	public function inicialitzar_noticia() /* Inicialitza l'objecte*/
	{

		$this->titol_es = '';
		$this->texte_es = '';
		$this->titol_cat = '';
		$this->texte_cat = '';
		$this->idioma = 'ES';
		$this->tipus = '1';
		$this->video = '';
		$this->imgs = array('', '', '', '', '', '');
		$this->control_imatges = 'no';
		$this->enviat = 'no';
		$this->dia = '--';
		$this->mes = '--';
		$this->any = '--';
		$this->hora = '--';
		$this->mins = '--';
		$this->descripcio = '';



	}

	public function formulari()
	{
		print "<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
		print "<input type=\"hidden\" name=\"timestamp\" value=\"$this->timestamp\" \>\n";


		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';

		print '<p class="contingut">Idioma
			<select name="idioma">';

		switch ($this->idioma) {
			case 'ES':
				print '<option value="ES" selected="selected">Castellano</option>
					<option value="CAT">Català</option>
					<option value="BOTH">Castellano - Català</option>';
				break;
			case 'CAT':
				print '<option value="ES">Castellano</option>
					<option value="CAT" selected="selected">Català</option>
					<option value="BOTH">Castellano - Català</option>';
				break;
			case 'BOTH':
				print '<option value="ES">Castellano</option>
					<option value="CAT">Català</option>
					<option value="BOTH" selected="selected">Castellano - Català</option>';
				break;
		}

		print '</select></p>';
		print '<p class="contingut">Tipo de noticia
			<select name="tipus">';
		switch ($this->tipus) {
			case '1':
				print '<option value="1" selected="selected">Noticia</option>
					<option value="2">Videoclip</option>';
				break;
			case '2':
				print '<option value="1">Noticia</option>
					<option value="2" selected="selected">Videoclip</option>';
				break;
		}
		print ' </select></p>';

		print '<p class="contingut">Titulo ES<br /><br /><input class="titol_form" type="text" name="titol_es" maxlength="1000" value="' . $this->titol_es . '" /></p>';

		print '<p class="contingut">Texto ES<br /><br />
			<textarea class="texte_form" name="texte_es">' . $this->texte_es . '</textarea></p>';

		print '<p class="contingut">Titulo CAT<br /><br /><input class="titol_form" type="text" name="titol_cat" maxlength="1000" value="' . $this->titol_cat . '" /></p>';

		print '<p class="contingut">Texto CAT<br /><br />
			<textarea class="texte_form" name="texte_cat">' . $this->texte_cat . '</textarea></p>';

		print '<p class="contingut">Imagenes<br /><br />';
		print '<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />';
		for ($i = 0; $i < 5; $i++) {
			if ($this->imgs[$i] != '') {
				print '<img src="../' . $this->imgs[$i] . '" width="100" /><br />';
				print '<input type="hidden" name="arxius_' . ($i + 1) . '" value="' . $this->imgs[$i] . '" />';
				print '<input type="file" name="file_' . ($i + 1) . '" id="file_' . ($i + 1) . '"/><br />';
			} else {
				print '<input type="file" name="file_' . ($i + 1) . '" id="file_' . ($i + 1) . '"/><br />';
			}
		}
		print '</p>';



		print '<p class="contingut">Codi youtube (solo si es un videoclip) <br /><br /><input class="imgs_form" type="text" name="video" maxlength="200" value="';
		/*if ($this->tipus!=2) {
						   $opcio='';
					   } else {
						   $opcio=$this->video;
					   }
					   print $opcio.'" /></p>';*/

		print $this->video . '" /></p>';
		print '<p class="contingut">Etiquetas, separadas por comas<br /><br /><input class="imgs_form" type="text" name="descripcio" maxlength="200" value="' . $this->descripcio . '" /></p>';
		/*print '<p class="contingut">Introsucir una fecha y hora diferente a la real<br /><br />
					   Día <select name="dia">
					   <option value="--">--</option>';
						   
					   for ($i=1;$i<=31;$i++) {
						   if ($this->dia==$i) {
							   print '<option selected="selected" value="'.$i.'">'.$i.'</option>';
						   } else {
							   print '<option value="'.$i.'">'.$i.'</option>';
						   }
					   }
					   print '</select>';
							   
					   print 'Mes <select name="mes">
					   <option value="--">--</option>';
							   
					   for ($i=1;$i<=12;$i++) {
						   if ($this->mes==$i) {
							   print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

						   } else {
							   print '<option value="'.$i.'">'.$i.'</option>';
						   }
					   }
					   print'</select>';
							   
					   print 'Año <select name="any">
					   <option value="----">--</option>';
							   
					   for ($i=2012;$i<=2013;$i++) {
						   if ($this->any==$i) {
							   print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

						   } else {
							   print '<option value="'.$i.'">'.$i.'</option>';
						   }
					   }
					   print'</select>';
							   
					   print '<br />Hora <select name="hora">
					   <option value="--">--</option>';
							   
					   for ($i=0;$i<=23;$i++) {
						   if ($this->hora==$i) {
							   print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

						   } else {
							   print '<option value="'.$i.'">'.$i.'</option>';
						   }
					   }
					   print'</select>:
					   <select name="mins">
					   <option value="--">--</option>';
							   
					   for ($i=0;$i<=59;$i++) {
						   if ($this->mins==$i) {
							   print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

						   } else {
							   print '<option value="'.$i.'">'.$i.'</option>';
						   }
					   }
					   print'</select><br /><br /><br />';*/

		print "<input type=\"submit";
		print "\" value=\"";

		print 'Enviar';

		print "\" /></fieldset>";

		print "</form>\n";

	}

	public function consulta_noticies($basedades, $desde, $quantitat)
	/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
		$inici = $desde - 1;

		/* Recupera les 10 primeres ID */
		$query = "select idNews from news order by dateIn desc limit " . $inici . ", " . $quantitat . " ";
		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la id de las noticias a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
				/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */

			}
		}

	}

	public function extreu_dades_noticia_per_id($bd, $id)
	/* Extreu dades d'una unica noticia */
	{
		$query_es = "select Title, Body, Idioma, type, news.dateIn, descripcio from news, newscontent where news.idNews = " . $id . " and newscontent.idNews = " . $id . " and newscontent.Idioma = 'ES'";
		$query_cat = "select Title, Body, Idioma, type, news.dateIn, descripcio from news, newscontent where news.idNews = " . $id . " and newscontent.idNews = " . $id . " and newscontent.Idioma = 'CAT'";

		$this->resultat_consulta_es = $bd->query($query_es);
		if ($this->resultat_consulta_es == FALSE) {
			$numero_es = 0;
		} else {
			$numero_es = $this->resultat_consulta_es->num_rows;
		}

		$this->resultat_consulta_cat = $bd->query($query_cat);
		if ($this->resultat_consulta_cat == FALSE) {
			$numero_cat = 0;
		} else {
			$numero_cat = $this->resultat_consulta_cat->num_rows;
		}
		$control_es = FALSE;
		$control_cat = FALSE;
		if ($numero_es == 1) {

			print '<p class="terminal">¡¡Noticia ES lista para editar!!</p>';
			$resultat_es = $this->resultat_consulta_es->fetch_assoc();
			$this->timestamp = $resultat_es['dateIn'];
			$this->tipus = $resultat_es['type'];
			$this->titol_es = $resultat_es['Title'];
			$this->texte_es = $resultat_es['Body'];
			$this->descripcio = $resultat_es['descripcio'];
			$control_es = TRUE;

		}
		if ($numero_cat == 1) {

			print '<p class="terminal">¡¡Noticia CAT lista para editar!!</p>';
			$resultat_cat = $this->resultat_consulta_cat->fetch_assoc();
			$this->timestamp = $resultat_cat['dateIn'];
			$this->tipus = $resultat_cat['type'];
			$this->titol_cat = $resultat_cat['Title'];
			$this->texte_cat = $resultat_cat['Body'];
			$this->descripcio = $resultat_cat['descripcio'];
			$control_cat = TRUE;
		}
		if (($control_cat == TRUE) && ($control_es == TRUE)) {
			$this->idioma = 'BOTH';
		} else {
			if ($control_cat == TRUE)
				$this->idioma = 'CAT';
			if ($control_es == TRUE)
				$this->idioma = 'ES';
		}

		$this->id = $id;
		/*$this->dia=substr($data,8,2);
					   $this->any=substr($data,0,4);
					   $this->mes=substr($data,5,2);			
					   $this->hora=substr($data,11,2);
					   $this->mins=substr($data,14,2);*/

		$query = "select * from newsdata where Idnews = " . $id . " order by tipo desc, orden desc";
		$this->resultat_consulta = $bd->query($query);
		$numero = $this->resultat_consulta->num_rows;
		if ($numero >= 0) {
			for ($i = 0; $i < $numero; $i++) {
				$resultat = $this->resultat_consulta->fetch_assoc();
				if ($resultat['tipo'] == 1) {
					$this->imgs[$i] = $resultat['ruta'];

				}
				if ($resultat['tipo'] == 2) {
					$this->video = $resultat['ruta'];
				}
			}
		}

	}

	public function eliminar_registre($bd, $id)
	{
		$query = "delete from news where idNews = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Delete de news OK</p>';
		} else {
			print '<p class="terminal">Delete de news fallido</p>';
		}
		$query = "delete from newscontent where idNews = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Delete de newscontent OK</p>';
		} else {
			print '<p class="terminal">Delete de newscontent fallido</p>';
		}
		$query = "delete from newsdata where idNews = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Delete de newsdata OK</p>';
		} else {
			print '<p class="terminal">Delete de newsdata fallido</p>';
		}

	}
	public function presentar_noticies_formulari($bd, $tasca)
	/* tenint l'objecte de la consulta les posa a pantalla */
	{
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			$this->id = $row['idNews'];
			$control_es = FALSE;
			$control_cat = FALSE;
			$query_es = "select news.type, Title, Body, news.dateIn from news, newscontent where news.idNews=" . $this->id . " and newscontent.idNews=" . $this->id . " and newscontent.Idioma='ES'";
			$this->resultat_consulta_es = $bd->query($query_es);
			if (!$this->resultat_consulta_es == FALSE) {
				if (($this->resultat_consulta_es->num_rows) == 1) {
					$row = $this->resultat_consulta_es->fetch_assoc();
					$this->titol_es = $row['Title'];
					$this->texte_es = $row['Body'];
					$this->tipus = $row['type'];
					$this->timestamp = $row['dateIn'];
					$control_es = TRUE;
				}
			}
			$query_cat = "select news.type, Title, Body, news.dateIn from news, newscontent where news.idNews=" . $this->id . " and newscontent.idNews=" . $this->id . " and newscontent.Idioma='CAT'";
			$this->resultat_consulta_cat = $bd->query($query_cat);
			if (!$this->resultat_consulta_cat == FALSE) {
				if (($this->resultat_consulta_cat->num_rows) == 1) {
					$row = $this->resultat_consulta_cat->fetch_assoc();
					$this->titol_cat = $row['Title'];
					$this->texte_cat = $row['Body'];
					$this->tipus = $row['type'];
					$this->timestamp = $row['dateIn'];
					$control_cat = TRUE;
				}
			}
			if (($control_cat == TRUE) && ($control_es == TRUE)) {
				$this->idioma = 'BOTH';
			} else {
				if ($control_cat == TRUE)
					$this->idioma = 'CAT';
				if ($control_es == TRUE)
					$this->idioma = 'ES';
			}

			$this->dia = substr($this->timestamp, 8, 2);
			$this->any = substr($this->timestamp, 0, 4);
			$this->mes = substr($this->timestamp, 5, 2);
			$this->hora = substr($this->timestamp, 11, 2);
			$this->mins = substr($this->timestamp, 14, 2);
			print '<div class="noticia_curta">';
			switch ($tasca) {
				case ('editar'):
					print '<div class="noticia_curta">';
					print "<form action=\"home_cp.php?sec=noticias&action=edit&tasca=edit&id=$this->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
							<p class=\"form_data\">";
					print '<fieldset><legend class="white">Id: ' . $this->id . ' - Fecha: ' . $this->dia . ' / ' . $this->mes . ' / ' . $this->any . ' Hora: ' . $this->hora . ':' . $this->mins . '</legend>';
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";

					print 'Editar';

					print "\" />";
					switch ($this->tipus) {
						case '1':
							$nom = 'Noticia';
							break;
						case '2':
							$nom = 'Video';
							break;
					}

					switch ($this->idioma) {
						case 'ES':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br/>
								<p class=\"titol\">Titulo: $this->titol_es</p><br />
								<p class=\"texte\">Texto: $this->texte_es</p>\n";
							break;
						case 'CAT':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br />
								<p class=\"titol\">Titulo: $this->titol_cat</p><br />
								<p class=\"texte\">Texto: $this->texte_cat</p>\n";
							break;
						case 'BOTH':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br />
								<p class=\"titol\">Titulo ES: $this->titol_es</p><br />
								<p class=\"texte\">Texto ES: $this->texte_es</p><br /><br />\n
								<p class=\"titol\">Titulo CAT: $this->titol_cat</p><br />
								<p class=\"texte\">Texto CAT: $this->texte_cat</p>\n";
							break;
					}
					print "</fieldset>";

					print "</form></div>";
					break;
				case ('del'):
					print '<div class="noticia_curta">';
					print "<form action=\"home_cp.php?sec=noticias&action=del&tasca=del&id=$this->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
							<p class=\"form_data\">";
					print '<fieldset><legend class="white">Id: ' . $this->id . ' - Fecha: ' . $this->dia . ' / ' . $this->mes . ' / ' . $this->any . ' Hora: ' . $this->hora . ':' . $this->mins . '</legend>';
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";

					print 'Eliminar';

					print "\" />";
					switch ($this->tipus) {
						case '1':
							$nom = 'Noticia';
							break;
						case '2':
							$nom = 'Video';
							break;
					}
					switch ($this->idioma) {
						case 'ES':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br/>
								<p class=\"titol\">Titulo ES: $this->titol_es</p><br />
								<p class=\"texte\">Texto ES: $this->texte_es</p>\n";
							break;
						case 'CAT':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br />
								<p class=\"titol\">Titulo CAT: $this->titol_cat</p><br />
								<p class=\"texte\">Texto CAT: $this->texte_cat</p>\n";
							break;
						case 'BOTH':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br />
								<p class=\"titol\">Titulo ES: $this->titol_es</p><br />
								<p class=\"texte\">Texto ES: $this->texte_es</p><br /><br />\n
								<p class=\"titol\">Titulo CAT: $this->titol_cat</p><br />
								<p class=\"texte\">Texto CAT: $this->texte_cat</p>\n";
							break;
					}
					print "</form></div>";
					break;
				case ('edit_del'):
					print '<div class="noticia_curta">';
					print '<fieldset><legend class="white">Id: ' . $this->id . ' - Fecha: ' . $this->dia . ' / ' . $this->mes . ' / ' . $this->any . ' Hora: ' . $this->hora . ':' . $this->mins . '</legend>';
					print "<form action=\"home_cp.php?sec=noticias&action=edit&tasca=edit&id=$this->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";
					print 'Editar';
					print "\" /></form>";
					print "<form action=\"index_cp.php?sec=noticias&action=del&tasca=del&id=$this->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";
					print 'Eliminar';
					print "\" /></form>";

					switch ($this->tipus) {
						case '1':
							$nom = 'Noticia';
							break;
						case '2':
							$nom = 'Video';
							break;
					}
					switch ($this->idioma) {
						case 'ES':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br/>
								<p class=\"titol\">Titulo ES: $this->titol_es</p><br />
								<p class=\"texte\">Texto ES: $this->texte_es</p>\n";
							break;
						case 'CAT':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br />
								<p class=\"titol\">Titulo CAT: $this->titol_cat</p><br />
								<p class=\"texte\">Texto CAT: $this->texte_cat</p>\n";
							break;
						case 'BOTH':
							print "<p class=\"titol\">Idioma: $this->idioma</p>
								<p class=\"titol\">Tipo: $nom</p><br />
								<p class=\"titol\">Titulo ES: $this->titol_es</p><br />
								<p class=\"texte\">Texto ES: $this->texte_es</p><br /><br />\n
								<p class=\"titol\">Titulo CAT: $this->titol_cat</p><br />
								<p class=\"texte\">Texto CAT: $this->texte_cat</p>\n";
							break;
					}
					print "</div>";

					break;


			}

		}
	}

	public function navegador_entrades($numero, $punter, $quantitat, $action)
	/* controla fletxes de navegacio per presentar noticies */
	{
		?>
		<div class="navegador">

			<?php
			if ($punter != 1) {
				?>
				<a class="linkk" href="home_cp.php?sec=noticias&action=edit&punter=1">
					<img class="ico_navegador" src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
				<?php
			}
			if ($punter != 1) {
				$punter_dir = $punter - 10;
				print '<a class="linkk" href="home_cp.php?sec=noticias&action=' . $action . '&punter=' . $punter_dir . '">
						<img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = $punter + 10;
				print '<a class="linkk" href="home_cp.php?sec=noticias&action=' . $action . '&punter=' . $punter_dir . '">
						<img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';

				$punter_dir = (number_format(($numero / $quantitat), 0) * $quantitat) + 1;
				print '<a class="linkk" href="home_cp.php?sec=noticias&action=' . $action . '&punter=' . $punter_dir . '">
						<img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
			}
			?>
		</div>
		<?php
	}
}
?>