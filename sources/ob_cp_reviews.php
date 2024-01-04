<?php
class ob_cp_reviews
{

	public $formulari_ok; /* control dels formularis */
	public $error;
	public $resultat_consulta;
	public $resultat_consulta2;
	public $numero_resultats;
	public $arxius_pujats;
	public $contador_arxius_pujats;



	public function __construct()
	{
		$this->formulari_ok = FALSE;

		$this->error = 'Errores:<br /> ';
		/*$this->arxius_pujats=array();*/
		$this->contador_arxius_pujats = 0;
	}

	public function recull_parametres($formulari, $review, $basedades) /* Mira si hi ha un formulari enviat i recull parametres */
	{

		if ($formulari['enviat'] == 'si') {
			$this->formulari_ok = TRUE;
			if ($formulari['id'] != '') {
				$review->id = trim($formulari['id']);
			}
			if ($formulari['link'] != '') {
				$review->link = $formulari['link'];
			}
			$review->banda = trim($formulari['banda']);
			if ($review->banda == '') {
				$this->error = $this->error . 'No se ha rellenado el nombre de la banda.<br />';
				$this->formulari_ok = FALSE;
			} else {
				if (isset($formulari['logo_off']))
					$review->logo = trim($formulari['logo_off']);
				$time_file = (date('YmdHis'));
				/* recollir imatge de la banda */
				if (isset($_FILES['fitxer_logo'])) {
					if ($_FILES['fitxer_logo']['error'] > 0)
					/* Comprovacio erros al pujar */{
						switch ($_FILES['fitxer_logo']['error']) {
							case 1:
								$this->error = $this->error . 'El archivo excede del tamaño máximo.<br />';
								$this->formulari_ok = FALSE;
								break;
							case 2:
								$this->error = $this->error . 'El archivo excede del tamaño máximo.<br />';
								$this->formulari_ok = FALSE;
								break;
							case 4:
								break;
							default:
								$this->error = $this->error . 'Error al subir el archivo ' . $_FILES['fitxer_logo'] . '.<br />';
								$this->formulari_ok = FALSE;
								break;
						}

					} else {
						$ext = '';
						if (stristr($_FILES['fitxer_logo']['name'], '.jpg') != FALSE)
							$ext = '.jpg';
						if (stristr($_FILES['fitxer_logo']['name'], '.jpeg') != FALSE)
							$ext = '.jpeg';
						if (stristr($_FILES['fitxer_logo']['name'], '.gif') != FALSE)
							$ext = '.gif';
						if (stristr($_FILES['fitxer_logo']['name'], '.png') != FALSE)
							$ext = '.png';
						if ($ext == '') {
							$this->error = $this->error . 'El archivo no es una imagen válida.<br />';
							$this->formulari_ok = FALSE;
						} else {
							$directori = '../pics/logos/' . convertir_cadena_arxiu($review->banda) . $time_file . $ext;
							if (is_uploaded_file($_FILES['fitxer_logo']['tmp_name'])) {
								if (!move_uploaded_file($_FILES['fitxer_logo']['tmp_name'], $directori)) {
									$this->error = $this->error . 'Error al subir la imagen a su carpeta.<br />';
									$this->formulari_ok = FALSE;
								} else {
									$review->logo = convertir_cadena_arxiu($review->banda) . $time_file . $ext;
								}
							} else {
								$this->error = $this->error . 'Error al subir la imagen.<br />';
								$this->formulari_ok = FALSE;
							}
						}
					}
				}

				if ($review->logo == '') {
					$nom = convertir_cadena_arxiu($review->banda);
					$correcte = FALSE;
					if (file_exists('../pics/logos/' . $nom . $time_file . '.jpg')) {
						$correcte = TRUE;
						$review->logo = $nom . '.jpg';
					}
					if (file_exists('../pics/logos/' . $nom . $time_file . '.jpeg')) {
						$correcte = TRUE;
						$review->logo = $nom . '.jpeg';
					}
					if (file_exists('../pics/logos/' . $nom . $time_file . '.gif')) {
						$correcte = TRUE;
						$review->logo = $nom . '.gif';
					}
					if (file_exists('../pics/logos/' . $nom . $time_file . '.png')) {
						$correcte = TRUE;
						$review->logo = $nom . '.png';
					}
					if ($correcte == FALSE) {
						$this->error = $this->error . 'No hay imagen del logo de la banda.<br />';
						$this->formulari_ok = FALSE;
					}
				}
			}


			$review->disc = trim($formulari['disc']);
			if ($review->disc == '') {
				$this->error = $this->error . 'No se ha rellenado el nombre del disco.<br />';
				$this->formulari_ok = FALSE;
			} else {


				/* recollir imatge de la banda */
				if (isset($formulari['portada_off'])) {
					$review->portada = trim($formulari['portada_off']);
				} else {
					if (isset($_FILES['fitxer_portada'])) {
						if ($_FILES['fitxer_portada']['error'] > 0)
						/* Comprovacio erros al pujar */{
							switch ($_FILES['fitxer_portada']['error']) {
								case 1:
									$this->error = $this->error . 'El archivo excede del tamaño máximo.<br />';
									$this->formulari_ok = FALSE;
									break;
								case 2:
									$this->error = $this->error . 'El archivo excede del tamaño máximo.<br />';
									$this->formulari_ok = FALSE;
									break;
								case 4:
									break;
								default:
									$this->error = $this->error . 'Error al subir el archivo ' . $_FILES['fitxer_portada'] . '.<br />';
									$this->formulari_ok = FALSE;
									break;
							}

						} else {
							$ext = '';
							if (stristr($_FILES['fitxer_portada']['name'], '.jpg') != FALSE)
								$ext = '.jpg';
							if (stristr($_FILES['fitxer_portada']['name'], '.jpeg') != FALSE)
								$ext = '.jpeg';
							if (stristr($_FILES['fitxer_portada']['name'], '.gif') != FALSE)
								$ext = '.gif';
							if (stristr($_FILES['fitxer_portada']['name'], '.png') != FALSE)
								$ext = '.png';
							if ($ext == '') {
								$this->error = $this->error . 'El archivo no es una imagen .<br />';
								$this->formulari_ok = FALSE;
							} else {
								$directori = '../pics/covers/' . convertir_cadena_arxiu($review->banda) . '_' . convertir_cadena_arxiu($review->disc) . $ext;
								if (is_uploaded_file($_FILES['fitxer_portada']['tmp_name'])) {
									if (!move_uploaded_file($_FILES['fitxer_portada']['tmp_name'], $directori)) {
										$this->error = $this->error . 'Error al subir la imagen a su carpeta.<br />';
										$this->formulari_ok = FALSE;
									} else {
										$review->portada = convertir_cadena_arxiu($review->banda) . '_' . convertir_cadena_arxiu($review->disc) . $ext;
									}
								} else {
									$this->error = $this->error . 'Error al subir la imagen.<br />';
									$this->formulari_ok = FALSE;
								}
							}
						}
					}
				}
				if ($review->portada == '') {
					$nom = convertir_cadena_arxiu($review->banda) . '_' . convertir_cadena_arxiu($review->disc);
					$correcte = FALSE;
					if (file_exists('../pics/covers/' . $nom . '.jpg')) {
						$correcte = TRUE;
						$review->portada = $nom . '.jpg';
					}
					if (file_exists('../pics/covers/' . $nom . '.jpeg')) {
						$correcte = TRUE;
						$review->portada = $nom . '.jpeg';
					}
					if (file_exists('../pics/covers/' . $nom . '.gif')) {
						$correcte = TRUE;
						$review->portada = $nom . '.gif';
					}
					if (file_exists('../pics/covers/' . $nom . '.png')) {
						$correcte = TRUE;
						$review->portada = $nom . '.png';
					}
					if ($correcte == FALSE) {
						$this->error = $this->error . 'No hay imagen de la portada del disco.<br />';
						$this->formulari_ok = FALSE;
					}
				}
			}

			$review->tipus = ($formulari['tipus']);

			$review->any = ($formulari['any']);

			$review->nota = ($formulari['nota']);

			$review->video = ($formulari['video']);

			if ($review->video == 1) {
				$review->media_video = trim($formulari['media_video']);
				$review->media = $review->media_video;
			} else {
				/* recollir imatge de la banda */
				if (isset($formulari['media_off'])) {
					$review->media = trim($formulari['media_off']);
				} else {
					if (isset($_FILES['fitxer_media'])) {
						if ($_FILES['fitxer_media']['error'] > 0)
						/* Comprovacio erros al pujar */{
							switch ($_FILES['fitxer_media']['error']) {
								case 1:
									$this->error = $this->error . 'El archivo excede del tamaño máximo.<br />';
									$this->formulari_ok = FALSE;
									break;
								case 2:
									$this->error = $this->error . 'El archivo excede del tamaño máximo.<br />';
									$this->formulari_ok = FALSE;
									break;
								case 4:
									break;
								default:
									$this->error = $this->error . 'Error al subir el archivo ' . $_FILES['fitxer_media'] . '.<br />';
									$this->formulari_ok = FALSE;
									break;
							}

						} else {
							$ext = '';
							if (stristr($_FILES['fitxer_media']['name'], '.jpg') != FALSE)
								$ext = '.jpg';
							if (stristr($_FILES['fitxer_media']['name'], '.jpeg') != FALSE)
								$ext = '.jpeg';
							if (stristr($_FILES['fitxer_media']['name'], '.gif') != FALSE)
								$ext = '.gif';
							if (stristr($_FILES['fitxer_media']['name'], '.png') != FALSE)
								$ext = '.png';
							if ($ext == '') {
								$this->error = $this->error . 'El archivo no es una imagen .<br />';
								$this->formulari_ok = FALSE;
							} else {
								$directori = '../pics/band/' . convertir_cadena_arxiu($review->banda) . $review->any . $ext;
								if (is_uploaded_file($_FILES['fitxer_media']['tmp_name'])) {
									if (!move_uploaded_file($_FILES['fitxer_media']['tmp_name'], $directori)) {
										$this->error = $this->error . 'Error al subir la imagen a su carpeta.<br />';
										$this->formulari_ok = FALSE;
									} else {
										$review->media_foto = convertir_cadena_arxiu($review->banda) . $review->any . $ext;
										print $review->media_foto;
									}
								} else {
									$this->error = $this->error . 'Error al subir la imagen.<br />';
									$this->formulari_ok = FALSE;
								}
							}
						}
					}
				}
				if ($review->media_foto == '') {
					$nom = convertir_cadena_arxiu($review->banda);
					$correcte = FALSE;
					if (file_exists('../pics/band/' . $nom . $review->any . '.jpg')) {
						$correcte = TRUE;
						$review->media_foto = $nom . '.jpg';
					}
					if (file_exists('../pics/band/' . $nom . $review->any . '.jpeg')) {
						$correcte = TRUE;
						$review->media_foto = $nom . '.jpeg';
					}
					if (file_exists('../pics/band/' . $nom . $review->any . '.gif')) {
						$correcte = TRUE;
						$review->media_foto = $nom . '.gif';
					}
					if (file_exists('../pics/band/' . $nom . $review->any . '.png')) {
						$correcte = TRUE;
						$review->media_foto = $nom . '.png';
					}
					if ($correcte == FALSE) {
						$this->error = $this->error . 'No hay imagen de la banda.<br />';
						$this->formulari_ok = FALSE;
					}
				}
				$review->media = $review->media_foto;
			}

			if (trim($formulari['nou_estil']) == '') {
				$review->idestil = ($formulari['idestil']);
			} else {
				$nou_estil = trim(($formulari['nou_estil']));
				$estil_global = trim(($formulari['estil_global']));
				$review->idestil = $this->introduir_estil($basedades, $nou_estil, $estil_global);
			}

			if (trim($formulari['nou_segell_nom']) == '') {
				$review->idlabel = ($formulari['idlabel']);
			} else {
				$nou_segell_nom = trim(($formulari['nou_segell_nom']));
				$nou_segell_link = trim(($formulari['nou_segell_link']));
				$review->idlabel = $this->introduir_label($basedades, $nou_segell_nom, $nou_segell_link);
			}

			if (trim($formulari['nou_pais_nom']) == '') {
				$review->idpais = ($formulari['idpais']);
			} else {
				$nou_pais_nom = trim(($formulari['nou_pais_nom']));
				$nou_pais_ruta = trim(($formulari['nou_pais_ruta']));
				$review->idpais = $this->introduir_pais($basedades, $nou_pais_nom, $nou_pais_ruta);
			}

			$review->idcolaboradors = ($formulari['idcolaboradors']);

			$review->tracklist = $formulari['tracklist'];
			$review->formacio_es = $formulari['formacio_es'];
			$review->formacio_cat = $formulari['formacio_cat'];
			$review->texte_es = $formulari['texte_es'];
			$review->texte_cat = $formulari['texte_cat'];

			/* buscar hora actual per afegir a la data introduida */


			$minut = date('i');
			$hora = date('H');
			$review->anydata = $formulari['anydata'];
			$review->mes = $formulari['mes'];
			if (($review->mes) < 10)
				$review->mes = '0' . $review->mes;
			$review->dia = $formulari['dia'];
			if (($review->dia) < 10)
				$review->dia = '0' . $review->dia;
			$review->timestamp = $review->anydata . $review->mes . $review->dia . $hora . $minut . '00';





		}
		return ($this->formulari_ok);
	}
	public function introduir_pais($bs, $nom, $link)
	{
		$query = "insert into banderes (pais, ruta) values ('" . $nom . "', '" . $link . "')";
		$this->resultat_consulta = $bs->query($query);
		if (!$this->resultat_consulta) {
			print '<p class="terminal">Error al guardar pais en la bbdd.</p>';
		} else {
			$query = "select idpais from banderes order by idpais desc limit 1";
			$this->resultat_consulta = $bs->query($query);
			if (!$this->resultat_consulta) {
				print '<p class="terminal">Extraer paises en la bbdd.</p>';
			} else {

				$row = $this->resultat_consulta->fetch_assoc();
				$id = $row['idpais'];
			}
		}
		return ($id);
	}
	public function introduir_label($bs, $nom, $link)
	{
		$query = "insert into label (labelnom, labellink) values ('" . $nom . "', '" . $link . "')";
		$this->resultat_consulta = $bs->query($query);
		if (!$this->resultat_consulta) {
			print '<p class="terminal">Error al guardar sello en la bbdd.</p>';
		} else {
			$query = "select idlabel from label order by idlabel desc limit 1";
			$this->resultat_consulta = $bs->query($query);
			if (!$this->resultat_consulta) {
				print '<p class="terminal">Extraer sellos en la bbdd.</p>';
			} else {

				$row = $this->resultat_consulta->fetch_assoc();
				$id = $row['idlabel'];
			}
		}
		return ($id);
	}
	public function introduir_estil($bs, $nou_estil, $estil_global)
	{
		$query = "insert into estil (estil,estil_global) values ('" . $nou_estil . "'," . $estil_global . ")";
		$this->resultat_consulta = $bs->query($query);
		if (!$this->resultat_consulta) {
			print '<p class="terminal">Error al guardar estilo en la bbdd.</p>';
		} else {
			$query = "select idestil from estil order by estil asc limit 1";
			$this->resultat_consulta = $bs->query($query);
			if (!$this->resultat_consulta) {
				print '<p class="terminal">Error al extraer sell en la bbdd.</p>';
			} else {

				$row = $this->resultat_consulta->fetch_assoc();
				$id = $row['idestil'];
			}
		}
		return ($id);
	}

	public function introduir($bs, $review, $logica_id, $id)
	{

		$review->banda = addslashes(htmlspecialchars($review->banda));
		$review->disc = addslashes(htmlspecialchars($review->disc));
		$review->portada = addslashes($review->portada);
		$review->logo = addslashes($review->logo);
		$review->media = addslashes($review->media);
		$review->tracklist = addslashes(htmlspecialchars($review->tracklist));
		$review->formacio_es = addslashes(htmlspecialchars($review->formacio_es));
		$review->formacio_cat = addslashes(htmlspecialchars($review->formacio_cat));
		$review->texte_es = addslashes($review->texte_es);
		$review->texte_cat = addslashes($review->texte_cat);
		$review->link = addslashes($review->link);

		print 'ID: ' . $review->id . '<br />';
		print 'Banda: ' . $review->banda . '<br />';
		print 'Ruta logo: ' . $review->logo . '<br />';
		print 'Disco: ' . $review->disc . '<br />';
		print 'Ruta portada: ' . $review->portada . '<br />';
		print 'Video: ' . $review->video . '<br />';
		print 'Ruta media: ' . $review->media . '<br />';
		print 'Tracklist: ' . $review->tracklist . '<br />';
		print 'Formacio ES: ' . $review->formacio_es . '<br />';
		print 'Formacio CAT: ' . $review->formacio_cat . '<br />';
		print 'Id Colaborador: ' . $review->idcolaboradors . '<br />';
		print 'Id Sello: ' . $review->idlabel . '<br />';
		print 'Id Estilo: ' . $review->idestil . '<br />';
		print 'Id Pais: ' . $review->idpais . '<br />';
		print 'Año: ' . $review->any . '<br />';
		print 'Tipo: ' . $review->tipus . '<br />';
		print 'Fecha: ' . $review->timestamp . '<br />';
		print 'Link: ' . $review->link . '<br />';

		if ($logica_id) {
			$query1 = "update reviews set data='" . $review->timestamp . "', banda='" . $review->banda . "', disc='" . $review->disc . "', portada='" . $review->portada . "', logo='" . $review->logo . "', video='" . $review->video . "', media='" . $review->media . "', tracklist='" . $review->tracklist . "', formacio_es='" . $review->formacio_es . "', formacio_cat='" . $review->formacio_cat . "', texte_es='" . $review->texte_es . "', texte_cat='" . $review->texte_cat . "', idcolaboradors='" . $review->idcolaboradors . "', nota='" . $review->nota . "', idpais='" . $review->idpais . "', any='" . $review->any . "', idestil='" . $review->idestil . "', idlabel='" . $review->idlabel . "', tipus='" . $review->tipus . "', link='" . $review->link . "' where idreviews='" . $review->id . "'";
		} else {
			$query1 = "insert into reviews (data, banda, disc, portada, logo, video, media, tracklist, formacio_es, formacio_cat, texte_es, texte_cat, idcolaboradors, nota, idpais, any, idestil, idlabel, tipus) values ('" . $review->timestamp . "', '" . $review->banda . "', '" . $review->disc . "', '" . $review->portada . "', '" . $review->logo . "', '" . $review->video . "', '" . $review->media . "', '" . $review->tracklist . "', '" . $review->formacio_es . "', '" . $review->formacio_cat . "', '" . $review->texte_es . "', '" . $review->texte_cat . "', '" . $review->idcolaboradors . "', '" . $review->nota . "', '" . $review->idpais . "', '" . $review->any . "', '" . $review->idestil . "', '" . $review->idlabel . "', '" . $review->tipus . "')";
			$query2 = "select idreviews from reviews order by idreviews desc limit 1";
		}
		print $query1;
		$this->resultat_consulta = $bs->query($query1);
		if ($this->resultat_consulta) {
			if (!$logica_id) {

				$this->resultat_consulta = $bs->query($query2);
				$row = $this->resultat_consulta->fetch_assoc();
				$review->id = $row['idreviews'];

				/* preparem links */

				$review->link = 'type=entrada&id=' . $review->id . '&cont=' . urlencode(convertir_cadena_arxiu($review->banda) . '_' . convertir_cadena_arxiu($review->disc));
				$query = "update reviews set link='" . $review->link . "' where idreviews=" . $review->id;
				$this->resultat_consulta = $bs->query($query);
				if (!$this->resultat_consulta) {
					print '<p class="terminal">Error 1</p>';
				}
			}
		} else {
			print '<p class="terminal">Error 2</p>';
		}
	}



	public function formulari($review, $basedades)
	{
		print "<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
		print "<input type=\"hidden\" name=\"id\" value=\"$review->id\" \>\n";
		print "<input type=\"hidden\" name=\"link\" value=\"$review->link\" \>\n";

		print '<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />';

		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';


		print '<p class="contingut">Banda: <br /><br /><input class="titol_form" type="text" name="banda" maxlength="1000" value="' . $review->banda . '" /></p>';

		print '<p class="contingut">Logo: <br /><br />';
		if ($review->logo != '') {
			print '<img src="../pics/logos/' . $review->logo . '" width="325" /><br />';
			print "<input type=\"hidden\" name=\"logo_off\" value=\"$review->logo\" \>\n";
		}
		print '<input type="file" name="fitxer_logo" id="fitxer_logo"/><br />';
		print '</p>';


		print '<p class="contingut">Disco: <br /><br /><input class="titol_form" type="text" name="disc" maxlength="1000" value="' . $review->disc . '" /></p>';

		print '<p class="contingut">Portada: <br /><br />';
		if ($review->portada != '') {
			print '<img src="../pics/covers/' . $review->portada . '" width="325" /><br />';
			print "<input type=\"hidden\" name=\"portada_off\" value=\"$review->portada\" \>\n";
		}
		print '<input type="file" name="fitxer_portada" id="fitxer_portada"/><br />';
		print '</p>';

		print '<p class="contingut">Tipo de disco : ';
		print '<select name="tipus">';
		switch ($review->tipus) {
			case '1':
				print '<option value="1" selected="selected">LP</option>
					<option value="2">EP</option>
					<option value="3">Demo</option>
                    <option value="4">Single</option>
                    <option value="3">DVD</option>';
				break;
			case '2':
				print '<option value="1">LP</option>
					<option value="2" selected="selected">EP</option>
					<option value="3">Demo</option>
                    <option value="4">Single</option>
                    <option value="5">DVD</option>';
				break;
			case '3':
				print '<option value="1">LP</option>
					<option value="2">EP</option>
					<option value="3" selected="selected">Demo</option>
                    <option value="4">Single</option>
                    <option value="5">DVD</option>';
				break;
			case '4':
				print '<option value="1">LP</option>
					<option value="2">EP</option>
                    <option value="3">Demo</option>
                    <option value="4" selected="selected">Single</option>
                    <option value="5">DVD</option>';
				break;
			case '5':
				print '<option value="1">LP</option>
					<option value="2">EP</option>
                    <option value="3">Demo</option>
                    <option value="4">Single</option>
					<option value="5" selected="selected">DVD</option>';
				break;
			default:
				print '<option value="1">LP</option>
					<option value="2">EP</option>
					<option value="3">Demo</option>
                    <option value="4">Single</option>
                    <option value="5">DVD</option>';
				break;
		}


		print '</select></p>';

		print '<p class="contingut">Año: <br />';
		print '<select name="any">';
		for ($y = 2000; $y <= 2024; $y++) {
			if ($review->any == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';

			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';
		print '</p>';

		print '<p class="contingut">Nota: <br />';
		print '<select name="nota">';
		for ($y = 0; $y <= 105; $y = $y + 5) {
			if ($review->nota == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';

			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';
		print '</p>';

		print '<p class="contingut">Video: ';
		print '<select name="video">';
		switch ($review->video) {
			case '1':
				print '<option value="1" selected="selected">Si</option>
					<option value="2">No</option>';
				break;
			case '2':
				print '<option value="1">Si</option>
					<option value="2" selected="selected">No</option>';
				break;

			default:
				print '<option value="1">Si</option>
					<option value="2">No</option>';
				break;
		}


		print '</select></p>';

		print '<p class="contingut">Codigo del Vídeo: <br />';
		print '<br /><input class="texte_form" type="text" name="media_video" maxlength="1000" value="' . $review->media_video . '" />';
		print '</p>';

		print '<p class="contingut">Si no hay video, subir imagen de la banda: <br /><br />';
		if ($review->media_foto != '') {
			print '<img src="../pics/band/' . $review->media_foto . '" width="325" /><br />';
			print "<input type=\"hidden\" name=\"banda_off\" value=\"$review->media_foto\" \>\n";
		}
		print '<input type="file" name="fitxer_media" id="fitxer_media"/><br />';
		print '</p>';

		print '<p class="contingut">Estilo: <br />';
		$this->consulta_estils($basedades);
		print '<select name="idestil">';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($review->idestil == $row['idestil']) {
				print '<option value="' . $row['idestil'] . '" selected="selected">' . $row['estil'] . '</option>';
			} else {
				print '<option value="' . $row['idestil'] . '">' . $row['estil'] . '</option>';

			}
		}
		print '</select></p>';

		print '<p class="contingut">Nuevo estilo:';
		print '<br /><input class="texte_form" type="text" name="nou_estil" maxlength="1000" value="" />';
		print '<br />Estilo global para comparación:';
		print '<br />1 - Heavy, 2 - Power, 3 - Death, 4 - Gothic/simphonic, 5 - Metalcore, 6 - Black, 7- Nu/alternativo, 8 - Melodic death, 9 - folk/pagan, 10 - Thrash, 11 - Progressive, 12 - Rock, 13 -  Experimental, 14 - Vacío<br /><select name="estil_blogal:">';
		for ($y = 1; $y <= 14; $y++) {
			print '<option value="' . $y . '">' . $y . '</option>';
		}
		print '</select></p>';

		print '<p class="contingut">Discográfica: <br />';
		$this->consulta_segells($basedades);
		print '<select name="idlabel">';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($review->idlabel == $row['idlabel']) {
				print '<option value="' . $row['idlabel'] . '" selected="selected">' . $row['labelnom'] . '</option>';
			} else {
				print '<option value="' . $row['idlabel'] . '">' . $row['labelnom'] . '</option>';

			}
		}
		print '</select></p>';



		print '<p class="contingut">Nueva discográfica: <br />';
		print '<br />Nombre: <input class="texte_form" type="text" name="nou_segell_nom" maxlength="1000" value="" />';
		print '<br />Link: <input class="texte_form" type="text" name="nou_segell_link" maxlength="1000" value="" />';
		print '</p>';

		print '<p class="contingut">País: <br />';
		$this->consulta_banderes($basedades);
		print '<select name="idpais">';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($review->idpais == $row['idpais']) {
				print '<option value="' . $row['idpais'] . '" selected="selected">' . $row['pais'] . '</option>';
			} else {
				print '<option value="' . $row['idpais'] . '">' . $row['pais'] . '</option>';

			}
		}
		print '</select></p>';


		print '<p class="contingut">Nuevo país: <br />';
		print '<br />Nombre: <input class="texte_form" type="text" name="nou_pais_nom" maxlength="1000" value="" />';
		print '<br />Bandera: <input class="texte_form" type="text" name="nou_pais_ruta" maxlength="1000" value="" />';
		print '</p>';


		print '<p class="contingut">Autor: <br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idcolaboradors">';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($review->idcolaboradors == $row['idcolaboradors']) {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '" selected="selected">' . $row['nom'] . '</option>';
			} else {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '">' . $row['nom'] . '</option>';
			}
		}
		$x = $x . '</select></p>';
		print $x;


		print '<p class="contingut">Tracklist:<br /><br />
			<textarea class="texte_form" name="tracklist">' . $review->tracklist . '</textarea></p>';

		print '<p class="contingut">Formación ES<br /><br />
			<textarea class="texte_form" name="formacio_es">' . $review->formacio_es . '</textarea></p>';

		print '<p class="contingut">Formacio CAT<br /><br />
			<textarea class="texte_form" name="formacio_cat">' . $review->formacio_cat . '</textarea></p>';

		print '<p class="contingut">Review ES<br /><br />
			<textarea class="texte_form" name="texte_es">' . $review->texte_es . '</textarea></p>';

		print '<p class="contingut">Review CAT<br /><br />
			<textarea class="texte_form" name="texte_cat">' . $review->texte_cat . '</textarea></p>';

		print '<p class="contingut">Fecha: <br /><br />';

		print 'Día <select name="dia">';
		for ($y = 1; $y <= 31; $y++) {
			if ($review->dia == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Mes <select name="mes">';
		for ($y = 1; $y <= 12; $y++) {
			if ($review->mes == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Año <select name="anydata">';
		for ($y = 2024; $y <= 2024; $y++) {
			if ($review->anydata == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';

			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';
		print '</p>';





		print "<input type=\"submit";
		print "\" value=\"";
		print 'Enviar';
		print "\" />";

		print "</fieldset>";

		print "</form>\n";

	}


	public function consulta_banderes($basedades)
	/* consulta els pasisos a la bbdd a partir de la conexió */
	{



		$query = "select idpais, pais from banderes order by pais asc";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer los paises a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';


			}
		}

	}
	public function consulta_estils($basedades)
	/* consulta els estils a la bbdd a partir de la conexió */
	{
		$query = "select idestil, estil from estil order by estil asc";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer los estilos a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';


			}
		}

	}

	public function consulta_colaboradors($basedades)
	/* consulta els colaboradors a la bbdd a partir de la conexió */
	{


		$query = "select idcolaboradors, nom from colaboradors order by nom asc";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer los colaboradores a mostrar.</p>';
		} else {
			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
			}

		}

	}

	public function consulta_segells($basedades)
	/* consulta els segells a la bbdd a partir de la conexió */
	{



		$query = "select idlabel, labelnom from label order by labelnom asc";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer los sellos a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';


			}
		}

	}
	public function consulta_reviews($basedades, $desde, $quantitat)
	/* consulta media a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
		$inici = $desde - 1;

		/* Recupera les 10 primeres ID */
		$query = "select idreviews from reviews order by data desc limit " . $inici . ", " . $quantitat . " ";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la id de las reviews a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
				/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */

			}
		}

	}

	public function extreu_dades_reviews_per_id($bd, $review, $id)
	/* Extreu dades d'una unica noticia */
	{
		$query = "select * from reviews where idreviews = " . $id;

		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la review</p>';
		} else {
			$resultat = $this->resultat_consulta->fetch_assoc();
			$review->id = $resultat['idreviews'];
			$review->timestamp = $resultat['data'];
			$review->disc = $resultat['disc'];
			$review->banda = $resultat['banda'];
			$review->portada = $resultat['portada'];
			$review->logo = $resultat['logo'];
			$review->video = $resultat['video'];
			$review->media = $resultat['media'];
			switch ($review->video) {
				case 1:
					$review->media_video = $review->media;
					break;
				case 2:
					$review->media_foto = $review->media;
					break;
			}
			$review->texte_es = $resultat['texte_es'];
			$review->texte_cat = $resultat['texte_cat'];
			$review->tracklist = $resultat['tracklist'];
			$review->formacio_es = $resultat['formacio_es'];
			$review->formacio_cat = $resultat['formacio_cat'];
			$review->idcolaboradors = $resultat['idcolaboradors'];
			$review->nota = $resultat['nota'];
			$review->idpais = $resultat['idpais'];
			$review->any = $resultat['any'];
			$review->idestil = $resultat['idestil'];
			$review->idlabel = $resultat['idlabel'];
			$review->tipus = $resultat['tipus'];
			$review->link = $resultat['link'];
			$review->dia = substr($review->timestamp, 8, 2);
			$review->anydata = substr($review->timestamp, 0, 4);
			$review->mes = substr($review->timestamp, 5, 2);


		}
	}

	public function eliminar_registre($bd, $id)
	{


		$query = "delete from reviews where idreviews = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Registro borrado</p>';
		} else {
			print '<p class="terminal">Delete de news fallido</p>';
		}


	}
	public function presentar_reviews_formulari($bd, $tasca, $review)
	/* tenint l'objecte de la consulta les posa a pantalla */
	{
		print $this->numero_resultats;
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			$review->id = $row['idreviews'];
			$query = "select banda, disc, data from reviews where idreviews=" . $review->id;
			$this->resultat_consulta2 = $bd->query($query);
			if (!$this->resultat_consulta2 == FALSE) {
				if (($this->resultat_consulta2->num_rows) == 1) {
					$row = $this->resultat_consulta2->fetch_assoc();
					$review->banda = $row['banda'];
					$review->disc = $row['disc'];
					$review->timestamp = $row['data'];
					$review->dia = substr($review->timestamp, 8, 2);
					$review->anydata = substr($review->timestamp, 0, 4);
					$review->mes = substr($review->timestamp, 5, 2);

					print '<div class="noticia_curta">';
					switch ($tasca) {
						case ('editar'):
							print '<div class="noticia_curta">';
							print "<form action=\"home_cp.php?sec=criticas&action=edit&tasca=edit&id=$review->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
							print '<fieldset><legend class="white">Id: ' . $review->id . ' - Fecha: ' . $review->dia . ' / ' . $review->mes . ' / ' . $review->anydata . '</legend>';
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";

							print 'Editar';

							print "\" />";
							print "<p class=\"titol\">Banda: $review->banda</p><br />";
							print "<p class=\"titol\">Disco: $review->disc</p><br />";

							print "</fieldset>";

							print "</form></div>";
							break;
						case ('del'):
							print '<div class="noticia_curta">';
							print "<form action=\"home_cp.php?sec=mediacriticas&action=del&tasca=del&id=$review->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
							print '<fieldset><legend class="white">Id: ' . $review->id . ' - Fecha: ' . $review->dia . ' / ' . $review->mes . ' / ' . $review->anydata . '</legend>';
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";

							print 'Eliminar';

							print "\" />";

							print "<p class=\"titol\">Banda: $review->banda</p><br />";
							print "<p class=\"titol\">Disco: $review->disc</p><br />";

							print "</fieldset>";

							print "</form></div>";
							break;
						case ('edit_del'):
							print '<div class="noticia_curta">';
							print '<fieldset><legend class="white">Id: ' . $review->id . ' - Fecha: ' . $review->dia . ' / ' . $review->mes . ' / ' . $review->anydata . '</legend>';
							print "<form action=\"home_cp.php?sec=criticas&action=edit&tasca=edit&id=$review->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";
							print 'Editar';
							print "\" /></form>";
							print "<form action=\"home_cp.php?sec=criticas&action=del&tasca=del&id=$review->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";
							print 'Eliminar';
							print "\" /></form>";

							print "<p class=\"titol\">Banda: $review->banda</p><br />";
							print "<p class=\"titol\">Disco: $review->disc</p><br />";

							print "</fieldset>";
							print "</div>";

							break;
					}
				}

			}

		}
	}

	public function navegador_entrades($numero, $punter, $quantitat, $action)
	/* controla fletxes de navegacio per presentar noticies */
	{
		?>
		<div class="navegador">

			<?php if ($punter != 1) {
				?>
				<a class="linkk" href="home_cp.php?sec=criticas&action=edit&punter=1"><img class="ico_navegador"
						src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
				<?php
			}
			if ($punter != 1) {
				$punter_dir = $punter - 10;
				print '<a class="linkk" href="home_cp.php?sec=criticas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
			}

			if ($numero >= ($punter + 10)) {
				$punter_dir = $punter + 10;
				print '<a class="linkk" href="home_cp.php?sec=criticas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = ((number_format(($numero / $quantitat), 0) * $quantitat) + 1) - 10;
				print '<a class="linkk" href="home_cp.php?sec=criticas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
			}
			?>
		</div>
		<?php
	}
}
?>