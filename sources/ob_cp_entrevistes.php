<?php
class ob_cp_entrevistes
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

	public function recull_parametres($formulari, $entrevista) /* Mira si hi ha un formulari enviat i recull parametres */
	{
		$entrevista->reset_entrevistes();
		if ($formulari['enviat'] == 'si') {
			$this->formulari_ok = TRUE;
			if ($formulari['id'] != '') {
				$entrevista->id = trim($formulari['id']);
			}
			if ($formulari['link'] != '') {
				$entrevista->link = $formulari['link'];
			}
			if ($entrevista->timestamp == '')
				$time_file = (date('Y-m-d H:i:s'));
			$time_file = str_replace('-', '', $time_file);
			$time_file = str_replace(' ', '', $time_file);
			$time_file = str_replace(':', '', $time_file);
			$entrevista->banda = trim($formulari['banda']);
			if ($entrevista->banda == '') {
				$this->error = $this->error . 'No se ha rellenado el nombre de la banda.<br />';
				$this->formulari_ok = FALSE;
			} else {
				if (isset($formulari['logo_off'])) {
					$entrevista->logo = trim($formulari['logo_off']);
				} else {
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
							if (isset($_POST['logo_off'])) {
								print 'Hi ha un logo ja i no sha pujat res';
								$entrevista->logo = $_POST['logo_off'];
							}


						} else {
							$ext = '';
							if (stristr($_FILES['fitxer_logo']['name'], '.jpg') != FALSE)
								$ext = '.jpg';
							if (stristr($_FILES['fitxer_logo']['name'], '.gif') != FALSE)
								$ext = '.gif';
							if (stristr($_FILES['fitxer_logo']['name'], '.png') != FALSE)
								$ext = '.png';
							if ($ext == '') {
								$this->error = $this->error . 'El archivo no es una imagen .<br />';
								$this->formulari_ok = FALSE;
							} else {
								$directori = '../pics/entrevistes_pics/' . $time_file . '_1' . $ext;
								if (is_uploaded_file($_FILES['fitxer_logo']['tmp_name'])) {
									if (!move_uploaded_file($_FILES['fitxer_logo']['tmp_name'], $directori)) {
										$this->error = $this->error . 'Error al subir la imagen a su carpeta.<br />';
										$this->formulari_ok = FALSE;
									} else {
										$entrevista->logo = $time_file . '_1' . $ext;
									}
								} else {
									$this->error = $this->error . 'Error al subir la imagen.<br />';
									$this->formulari_ok = FALSE;
								}
							}
						}
					}
				}
				if ($entrevista->logo == '') {
					$this->error = $this->error . 'No hay imagen del logo de la banda.<br />';
					$this->formulari_ok = FALSE;
				}
			}


			$entrevista->tipus = $formulari['tipus'];
			$entrevista->idioma = ($formulari['idioma']);
			$entrevista->idcolaboradors = ($formulari['idcolaboradors']);
			$entrevista->idcolaboradors2 = ($formulari['idcolaboradors2']);
			$entrevista->idtraductor = ($formulari['idtraductor']);
			$entrevista->titol_es = $formulari['titol_es'];
			if (($entrevista->titol_es == '') && (($entrevista->idioma == 'ES') || ($entrevista->idioma == 'BOTH'))) {
				$this->error = $this->error . 'No hay Encabezado ES.<br />';
				$this->formulari_ok = FALSE;
			}
			$entrevista->titol_cat = $formulari['titol_cat'];
			if (($entrevista->titol_cat == '') && (($entrevista->idioma == 'CAT') || ($entrevista->idioma == 'BOTH'))) {
				$this->error = $this->error . 'No hay Encabezado CAT.<br />';
				$this->formulari_ok = FALSE;
			}
			$entrevista->texte_es = $formulari['texte_es'];
			if (($entrevista->texte_es == '') && (($entrevista->idioma == 'ES') || ($entrevista->idioma == 'BOTH')) && ($entrevista->tipus == 2)) {
				$this->error = $this->error . 'No hay Texto ES.<br />';
				$this->formulari_ok = FALSE;
			}
			$entrevista->texte_cat = $formulari['texte_cat'];
			if (($entrevista->texte_cat == '') && (($entrevista->idioma == 'CAT') || ($entrevista->idioma == 'BOTH')) && ($entrevista->tipus == 2)) {
				$this->error = $this->error . 'No hay Texto CAT.<br />';
				$this->formulari_ok = FALSE;
			}
			$arxius = array('file_1', 'file_2', 'file_3');
			for ($i = 0; $i < 3; $i++) {

				/* Recollir imatge */
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

					if (isset($_POST['arxius_' . ($i + 1)])) {
						print '<p>Hi ha una imatge a la posicio' . ($i + 1) . '</p>';
						$entrevista->imgs[$i] = $_POST['arxius_' . ($i + 1)];
					}

					if (isset($_POST['borrar_' . ($i + 1)])) {
						print 'borrrrrar';
						if (file_exists('../pics/entrevistes_pics/' . $entrevista->imgs[$i])) {
							unlink('../pics/entrevistes_pics/' . $entrevista->imgs[$i]);
						}
						$entrevista->imgs[$i] = 'borrar';
					}


				} else {
					$ext = '';
					if (stristr($_FILES[$arxius[$i]]['name'], '.jpg') != FALSE)
						$ext = '.jpg';
					if (stristr($_FILES[$arxius[$i]]['name'], '.gif') != FALSE)
						$ext = '.gif';
					if (stristr($_FILES[$arxius[$i]]['name'], '.png') != FALSE)
						$ext = '.png';
					if ($ext == '') {
						$this->error = $this->error . 'El archivo no es una imagen ' . ($i + 1) . '.<br />';
						$this->formulari_ok = FALSE;
					} else {
						$directori = '../pics/entrevistes_pics/' . $time_file . '_' . ($i + 2) . $ext;
						if (is_uploaded_file($_FILES[$arxius[$i]]['tmp_name'])) {
							if (!move_uploaded_file($_FILES[$arxius[$i]]['tmp_name'], $directori)) {
								$this->error = $this->error . 'Error al subir la imagen ' . ($i + 1) . ' a su carpeta.<br />';
								$this->formulari_ok = FALSE;
							} else {
								$entrevista->imgs[$i] = $time_file . '_' . ($i + 2) . $ext;

							}
						} else {
							$this->error = $this->error . 'Error al subir la imagen ' . ($i + 1) . '.<br />';
							$this->formulari_ok = FALSE;
						}
					}
				}
			}
			/* buscar hora actual per afegir a la data introduida */

			$entrevista->ruta_audio = $formulari['audio'];
			$minut = date('i');
			$hora = date('H');
			$entrevista->anydata = $formulari['anydata'];
			$entrevista->mes = $formulari['mes'];
			if (($entrevista->mes) < 10)
				$entrevista->mes = '0' . $entrevista->mes;
			$entrevista->dia = $formulari['dia'];
			if (($entrevista->dia) < 10)
				$entrevista->dia = '0' . $entrevista->dia;
			$entrevista->timestamp = $entrevista->anydata . $entrevista->mes . $entrevista->dia . $hora . $minut . '00';





		}
		return ($this->formulari_ok);
	}


	public function introduir($bs, $entrevista, $logica_id, $id)
	{

		$entrevista->banda = addslashes(htmlspecialchars($entrevista->banda));
		$entrevista->link = addslashes($entrevista->link);
		$entrevista->titol_es = addslashes($entrevista->titol_es);
		$entrevista->titol_cat = addslashes($entrevista->titol_cat);
		$entrevista->texte_es = addslashes($entrevista->texte_es);
		$entrevista->texte_cat = addslashes($entrevista->texte_cat);


		print 'ID: ' . $entrevista->id . '<br />';
		print 'Banda: ' . $entrevista->banda . '<br />';
		print 'Ruta logo: ' . $entrevista->logo . '<br />';
		print 'Ruta audio: ' . $entrevista->ruta_audio . '<br />';
		print 'Encabezado ES: ' . $entrevista->titol_es . '<br />';
		print 'Encabezado CAT: ' . $entrevista->titol_cat . '<br />';
		print 'Texto ES: ' . $entrevista->texte_es . '<br />';
		print 'Texto CAT: ' . $entrevista->texte_cat . '<br />';
		print 'Id Colaborador 1: ' . $entrevista->idcolaboradors . '<br />';
		print 'Id Colaborador 2: ' . $entrevista->idcolaboradors2 . '<br />';
		print 'Id Traductor: ' . $entrevista->idtraductor . '<br />';
		print 'Tipo: ' . $entrevista->tipus . '<br />';
		print 'Idioma: ' . $entrevista->idioma . '<br />';
		print 'Fecha: ' . $entrevista->timestamp . '<br />';
		print 'Link: ' . $entrevista->link . '<br />';
		for ($i = 0; $i < 3; $i++) {
			if (isset($entrevista->imgs[$i])) {
				print 'Img ' . ($i + 1) . ' - ' . $entrevista->imgs[$i] . '<br />';
			}
		}

		if ($logica_id) {
			$query1 = "update entrevistes set data='" . $entrevista->timestamp . "', banda='" . $entrevista->banda . "', tipus='" . $entrevista->tipus . "', link='" . $entrevista->link . "', idioma='" . $entrevista->idioma . "', titol_es='" . $entrevista->titol_es . "', titol_cat='" . $entrevista->titol_cat . "', texte_es='" . $entrevista->texte_es . "', texte_cat='" . $entrevista->texte_cat . "', idcolaboradors='" . $entrevista->idcolaboradors . "', idcolaboradors2='" . $entrevista->idcolaboradors2 . "', idtraductor='" . $entrevista->idtraductor . "' where identrevistes='" . $entrevista->id . "'";
		} else {
			$query1 = "insert into entrevistes (data, banda, idcolaboradors, idcolaboradors2, idtraductor, tipus, idioma, titol_es, titol_cat, texte_es, texte_cat, visites) values ('" . $entrevista->timestamp . "', '" . $entrevista->banda . "', '" . $entrevista->idcolaboradors . "', '" . $entrevista->idcolaboradors2 . "', '" . $entrevista->idtraductor . "', '" . $entrevista->tipus . "', '" . $entrevista->idioma . "', '" . $entrevista->titol_es . "', '" . $entrevista->titol_cat . "', '" . $entrevista->texte_es . "', '" . $entrevista->texte_cat . "', 0)";
			$query2 = "select identrevistes from entrevistes order by identrevistes desc limit 1";
		}

		$this->resultat_consulta = $bs->query($query1);
		print $query1;
		if ($this->resultat_consulta) {
			if (!$logica_id) {

				$this->resultat_consulta = $bs->query($query2);
				$row = $this->resultat_consulta->fetch_assoc();
				$entrevista->id = $row['identrevistes'];

				/* preparem links */

				$entrevista->link = 'type=entrada&id=' . $entrevista->id . '&cont=' . urlencode(convertir_cadena_arxiu($entrevista->banda));
				$query = "update entrevistes set link='" . $entrevista->link . "' where identrevistes=" . $entrevista->id;
				$this->resultat_consulta = $bs->query($query);
				if (!$this->resultat_consulta) {
					print '<p class="terminal">Error 1</p>';
				}
			}
		} else {
			print '<p class="terminal">Error 2</p>';
		}
		if ($logica_id) {
			$query = "select ruta, tipus, ordre from entrevistesdata where identrevistes=" . $entrevista->id . " order by tipus, ordre asc";
			$this->resultat_consulta = $bs->query($query);
			$numero = $this->resultat_consulta->num_rows;
			if ($this->resultat_consulta) {
				for ($x = 0; $x < $numero; $x++) {
					$row = $this->resultat_consulta->fetch_assoc();
					$data[$x]['ruta'] = $row['ruta'];
					$data[$x]['tipus'] = $row['tipus'];
					$data[$x]['ordre'] = $row['ordre'];
					print 'Data ' . $x . ' : Ruta : ' . $data[$x]['ruta'] . ' Tipus :' . $data[$x]['tipus'] . ' Ordre : ' . $data[$x]['ordre'] . '<br />';
				}
			}
		}
		$contador = 1;
		if ($entrevista->logo != '') {
			$entrevista->logo = addslashes($entrevista->logo);

			if ($logica_id) {
				$contador++;
				/* mirar quin logo hi ha a la bbdd */
				if ($entrevista->logo != $data[0]['ruta']) {
					/* si es igual no es fa res.. sino... s'esborra i es posa un nou' */
					$query = "update entrevistesdata set ruta=" . $entrevista->logo . " where identrevistes=" . $entrevista->id . " and ordre=1 and tipus=1";
					$this->resultat_consulta = $bs->query($query);
					if ($this->resultat_consulta) {
						print '<p class="terminal">¡¡Imagen logo añadida correctamente!!</p>';
						$contador = $contador + 1;
					} else {
						print '<p class="terminal">No se ha podido añadir la imagen del logo.</p>';
					}
					if (file_exists('../pics/entrevistes_pics/' . $data[0]['ruta'])) {
						unlink('../pics/entrevistes_pics/' . $data[0]['ruta']);
					}
				}

			} else {
				$query = "insert into entrevistesdata (ordre, identrevistes, tipus, ruta) values (" . $contador . ", (select identrevistes from entrevistes order by identrevistes desc limit 1), '1', '" . $entrevista->logo . "')";
				$this->resultat_consulta = $bs->query($query);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Imagen logo añadida correctamente!!</p>';
					$contador = $contador + 1;
				} else {
					print '<p class="terminal">No se ha podido añadir la imagen del logo.</p>';
				}
			}
		}
		$cont = 1;
		for ($i = 1; $i <= 3; $i++) {
			if ($entrevista->imgs[($i - 1)] != '') {
				$entrevista->imgs[($i - 1)] = addslashes($entrevista->imgs[($i - 1)]);
				if ($logica_id) {
					$contador = $contador + 1;
					/* es mira si hi ha dades a la bbdd */
					if (isset($data[$i])) {
						if ($data[$i]['tipus'] == 1) {
							if ($entrevista->imgs[($i - 1)] == 'borrar') {
								$query = "delete from entrevistesdata where identrevistes=" . $entrevista->id . " and ordre=" . $data[$i]['ordre'] . " and tipus=1";
								$contador = $contador - 1;

							} else {
								if ($entrevista->imgs[($i - 1)] != $data[$i]['ruta']) {
									print $entrevista->imgs[($i - 1)] . ' - ' . $data[$i]['ruta'];
									$cont++;
									/* si es igual no es fa res.. sino... s'esborra i es posa un nou' */
									$query = "update entrevistesdata set ruta=" . $entrevista->imgs[($i - 1)] . " where identrevistes=" . $entrevista->id . " and ordre=" . $data[$i]['ordre'] . " and tipus=1";
									print $query;
									$this->resultat_consulta = $bs->query($query);
									if ($this->resultat_consulta) {
										print '<p class="terminal">¡¡Imagen ' . $i . ' añadida correctamente!!</p>';

									} else {
										print '<p class="terminal">No se ha podido añadir la imagen ' . $i . '.</p>';
									}
									if (file_exists('../pics/entrevistes_pics/' . $data[$i]['ruta'])) {
										unlink('../pics/entrevistes_pics/' . $data[$i]['ruta']);
									}
								}
							}
						}
					} else {
						$cont = 0;
						$query = "insert into entrevistesdata (ordre, identrevistes, tipus, ruta) values (" . $contador . ", '" . $id . "', '1', '" . $entrevista->imgs[($i - 1)] . "')";
						print $query;
						$this->resultat_consulta = $bs->query($query);
						if ($this->resultat_consulta) {
							print '<p class="terminal">¡¡Imagen ' . $i . ' añadida correctamente!!</p>';
							$contador = $contador + 1;
						} else {
							print '<p class="terminal">No se ha podido añadir la imagen ' . $i . '.</p>';
						}
					}
				} else {
					$query = "insert into entrevistesdata (ordre, identrevistes, tipus, ruta) values (" . $contador . ", (select identrevistes from entrevistes order by identrevistes desc limit 1), '1', '" . $entrevista->imgs[($i - 1)] . "')";
					print $query;
					$this->resultat_consulta = $bs->query($query);
					if ($this->resultat_consulta) {
						print '<p class="terminal">¡¡Imagen ' . $i . ' añadida correctamente!!</p>';
						$contador = $contador + 1;
					} else {
						print '<p class="terminal">No se ha podido añadir la imagen ' . $i . '.</p>';
					}

				}
			}

		}
		if ($entrevista->tipus == '1') {
			/* si hi ha video */
			$entrevista->ruta_audio = addslashes($entrevista->ruta_audio);
			if ($logica_id) {
				if (($cont != 0) || (isset($data[$i]))) {
					if (isset($data[$i])) {
						if ($data[$i]['tipus'] == 2) {
							if ($entrevista->ruta_audio != $data[$i]['ruta']) {
								$cont++;
								/* si es igual no es fa res.. sino... s'esborra i es posa un nou' */
								$query = "update entrevistesdata set ruta=" . $entrevista->imgs[($i - 1)] . " where identrevistes=" . $entrevista->id . " and ordre=" . $data[$i]['ordre'] . " and tipus=2";
								$this->resultat_consulta = $bs->query($query);
								if ($this->resultat_consulta) {
									print '<p class="terminal">¡¡Audio añadido!!</p>';
								} else {
									print '<p class="terminal">No se ha podido añadir el audio.</p>';
								}
							}
						}
					}
				}
				$query = "insert into entrevistesdata (ordre, identrevistes, tipus, ruta) values (" . $contador . ", '" . $id . "', 2, '" . $entrevista->ruta_audio . "')";
				$this->resultat_consulta = $bs->query($query);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Audio añadido!!</p>';
				} else {
					print '<p class="terminal">No se ha podido añadir el audio.</p>';
				}
			} else {
				$query = "insert into entrevistesdata (ordre, identrevistes, tipus, ruta) values (" . $contador . ", (select identrevistes from entrevistes order by identrevistes desc limit 1), 2, '" . $entrevista->ruta_audio . "')";
				print $query;
				$this->resultat_consulta = $bs->query($query);
				if ($this->resultat_consulta) {
					print '<p class="terminal">¡¡Audio añadido!!</p>';
				} else {
					print '<p class="terminal">No se ha podido añadir el audio.</p>';
				}
			}


		}
	}



	public function formulari($entrevista, $basedades)
	{
		print "<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
		print "<input type=\"hidden\" name=\"id\" value=\"$entrevista->id\" \>\n";
		print "<input type=\"hidden\" name=\"link\" value=\"$entrevista->link\" \>\n";

		print '<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />';

		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';

		print '<p class="contingut">Idioma
			<select name="idioma">';

		switch ($entrevista->idioma) {
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
			default:
				print '<option value="ES">Castellano</option>
					<option value="CAT">Català</option>
					<option value="BOTH">Castellano - Català</option>';
				break;
		}
		print '</select></p>';

		print '<p class="contingut">Banda: <br /><br /><input class="titol_form" type="text" name="banda" maxlength="1000" value="' . $entrevista->banda . '" /></p>';

		print '<p class="contingut">Logo: <br /><br />';
		if ($entrevista->logo != '') {
			print '<img src="../pics/entrevistes_pics/' . $entrevista->logo . '" width="325" /><br />';
			print "<input type=\"hidden\" name=\"logo_off\" value=\"$entrevista->logo\" \>\n";
		}
		print '<input type="file" name="fitxer_logo" id="fitxer_logo"/><br />';
		print '</p>';


		print '<p class="contingut">Encabezado ES: <br /><br />';
		print '<textarea class="texte_form" name="titol_es">' . $entrevista->titol_es . '</textarea></p>';

		print '<p class="contingut">Contenido ES ([p] [/p] [r] [/r] [audio] [img#] [imgcentrada#]): <br /><br />';
		print '<textarea class="texte_form" name="texte_es">' . $entrevista->texte_es . '</textarea></p>';

		print '<p class="contingut">Encabezado CAT: <br /><br />';
		print '<textarea class="texte_form" name="titol_cat">' . $entrevista->titol_cat . '</textarea></p>';

		print '<p class="contingut">Contenido CAT ([p] [/p] [r] [/r] [audio] [img#] [imgcentrada#]): <br /><br />';
		print '<textarea class="texte_form" name="texte_cat">' . $entrevista->texte_cat . '</textarea></p>';


		print '<p class="contingut">Tipo de entrevista: ';
		print '<select name="tipus">';
		switch ($entrevista->tipus) {
			case '1':
				print '<option value="1" selected="selected">Audio</option>
					<option value="2">Texto</option>';
				break;
			case '2':
				print '<option value="1">Audio</option>
					<option value="2" selected="selected">Texto</option>';
				break;

			default:
				print '<option value="1">Audio</option>
					<option value="2">Texto</option>';
				break;
		}
		print '</select></p>';

		print '<p class="contingut">Subida de imágenes: <br /><br />';


		for ($i = 0; $i < 3; $i++) {
			print 'Imagen ' . ($i + 1) . ':<br />';
			if ($entrevista->imgs[$i] != '') {
				print '<img src="../pics/entrevistes_pics/' . $entrevista->imgs[$i] . '" width="100" /><br />';
				print '<input type="hidden" name="arxius_' . ($i + 1) . '" value="' . $entrevista->imgs[$i] . '" />';
				print '<input type="checkbox" name="borrar_' . ($i + 1) . '" value="borrar_' . ($i + 1) . '" /> Eliminar<br />';
				print '<input type="file" name="file_' . ($i + 1) . '" id="file_' . ($i + 1) . '"/><br />';
			} else {
				print '<input type="file" name="file_' . ($i + 1) . '" id="file_' . ($i + 1) . '"/><br />';
			}
		}
		print '</p>';

		print '<p class="contingut">Selecciona el audio: <br /><br />';
		//print '<input type="file" name="audio" id="audio"/><br />';
		$currant_dir = '../audio/';
		$dir = opendir($currant_dir);
		print '<select id="audio" name="audio">';
		print '<option>Sin audio</option>';
		while (false !== ($file = readdir($dir))) {
			/* Mostrar entradas */
			if ($file != "." && $file != "..") {
				print '<option>' . $file . '</option>';
			}
		}
		print '</select>';
		print '</p>';

		print '<p class="contingut">Autor 1: <br /><br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idcolaboradors">';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($entrevista->idcolaboradors == $row['idcolaboradors']) {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '" selected="selected">' . $row['nom'] . '</option>';
			} else {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '">' . $row['nom'] . '</option>';
			}
		}
		$x = $x . '</select></p>';
		print $x;

		print '<p class="contingut">Autor 2: <br /><br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idcolaboradors2">';
		$x = $x . '<option value="0" selected="selected">No</option>';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($entrevista->idcolaboradors2 == $row['idcolaboradors']) {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '" selected="selected">' . $row['nom'] . '</option>';
			} else {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '">' . $row['nom'] . '</option>';
			}
		}
		$x = $x . '</select></p>';
		print $x;

		print '<p class="contingut">Traductor: <br /><br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idtraductor">';
		$x = $x . '<option value="0" selected="selected">No</option>';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($entrevista->idtraductor == $row['idcolaboradors']) {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '" selected="selected">' . $row['nom'] . '</option>';
			} else {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '">' . $row['nom'] . '</option>';
			}
		}
		$x = $x . '</select></p>';
		print $x;

		print '<p class="contingut">Fecha: <br /><br />';

		print 'Día <select name="dia">';
		for ($y = 1; $y <= 31; $y++) {
			if ($entrevista->dia == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Mes <select name="mes">';
		for ($y = 1; $y <= 12; $y++) {
			if ($entrevista->mes == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Año <select name="anydata">';
		for ($y = 2025; $y <= 2025; $y++) {
			if ($entrevista->anydata == $y) {
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


	public function consulta_entrevistes($basedades, $desde, $quantitat)
	/* consulta media a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
		$inici = $desde - 1;

		/* Recupera les 10 primeres ID */
		$query = "select identrevistes from entrevistes order by data desc limit " . $inici . ", " . $quantitat . " ";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la id de las entrevistas a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
				/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */

			}
		}

	}

	public function extreu_dades_entrevistes_per_id($bd, $entrevista, $id)
	/* Extreu dades d'una unica noticia */
	{
		$entrevista->reset_entrevistes();
		$query = "select * from entrevistes where identrevistes = " . $id;

		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la entrevista</p>';
		} else {
			$resultat = $this->resultat_consulta->fetch_assoc();
			$entrevista->id = $resultat['identrevistes'];
			$entrevista->timestamp = $resultat['data'];
			$entrevista->banda = $resultat['banda'];
			$entrevista->link = $resultat['link'];
			$entrevista->tipus = $resultat['tipus'];
			$entrevista->texte_es = $resultat['texte_es'];
			$entrevista->texte_cat = $resultat['texte_cat'];
			$entrevista->titol_es = $resultat['titol_es'];
			$entrevista->titol_cat = $resultat['titol_cat'];
			$entrevista->idioma = $resultat['idioma'];
			$entrevista->idcolaboradors = $resultat['idcolaboradors'];
			$entrevista->idcolaboradors2 = $resultat['idcolaboradors2'];
			$entrevista->idtraductor = $resultat['idtraductor'];
			$entrevista->dia = substr($entrevista->timestamp, 8, 2);
			$entrevista->anydata = substr($entrevista->timestamp, 0, 4);
			$entrevista->mes = substr($entrevista->timestamp, 5, 2);


		}
		$query = "select * from entrevistesdata where identrevistes = " . $id . " order by ordre asc";
		$this->resultat_consulta = $bd->query($query);
		$numero = $this->resultat_consulta->num_rows;
		if ($numero >= 0) {
			for ($i = 0; $i < $numero; $i++) {
				print $i;
				$resultat = $this->resultat_consulta->fetch_assoc();
				if ($resultat['tipus'] == 1) {
					if ($i == 0) {
						$entrevista->logo = $resultat['ruta'];
						print 'Aixo es un logo: <img src="../pics/entrevistes_pics/' . $entrevista->logo . '" widht="100" /><br />';
					} else {
						$entrevista->imgs[($i - 1)] = $resultat['ruta'];
						print 'Aixo NO es un logo: <img src="../pics/entrevistes_pics/' . $entrevista->imgs[($i - 1)] . '" widht="100" /><br />';
					}

				}
				if ($resultat['tipus'] == 2) {
					$entrevista->audio = $resultat['ruta'];
				}
			}
		}
	}

	public function eliminar_registre($bd, $id)
	{


		$query = "delete from entrevistes where identrevistes = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Registro borrado</p>';
		} else {
			print '<p class="terminal">Delete de news fallido</p>';
		}
		$query = "select ruta, tipus from entrevistesdata where identrevistes = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		$numero = $this->resultat_consulta->num_rows;
		if ($numero >= 0) {
			for ($i = 0; $i < $numero; $i++) {
				$resultat = $this->resultat_consulta->fetch_assoc();
				if ($resultat['tipus'] == 1) {
					if ($i == 0) {
						if (file_exists('../pics/entrevistes_pics/' . $resultat['ruta'])) {
							unlink('../pics/entrevistes_pics/' . $resultat['ruta']);
						}
					}

				}

			}
		}
		$query = "delete from entrevistesdata where identrevistes = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);

	}
	public function presentar_entrevistes_formulari($bd, $tasca, $entrevista)
	/* tenint l'objecte de la consulta les posa a pantalla */
	{
		print $this->numero_resultats;
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			$entrevista->id = $row['identrevistes'];
			$query = "select banda, data from entrevistes where identrevistes=" . $entrevista->id;
			$this->resultat_consulta2 = $bd->query($query);
			if (!$this->resultat_consulta2 == FALSE) {
				if (($this->resultat_consulta2->num_rows) == 1) {
					$row = $this->resultat_consulta2->fetch_assoc();
					$entrevista->banda = $row['banda'];
					$entrevista->timestamp = $row['data'];
					$entrevista->dia = substr($entrevista->timestamp, 8, 2);
					$entrevista->anydata = substr($entrevista->timestamp, 0, 4);
					$entrevista->mes = substr($entrevista->timestamp, 5, 2);

					print '<div class="noticia_curta">';
					switch ($tasca) {
						case ('editar'):
							print '<div class="noticia_curta">';
							print "<form action=\"home_cp.php?sec=entrevistas&action=edit&tasca=edit&id=$entrevista->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
							print '<fieldset><legend class="white">Id: ' . $entrevista->id . ' - Fecha: ' . $entrevista->dia . ' / ' . $entrevista->mes . ' / ' . $entrevista->anydata . '</legend>';
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";

							print 'Editar';

							print "\" />";
							print "<p class=\"titol\">Banda: $entrevista->banda</p><br />";
							print "</fieldset>";

							print "</form></div>";
							break;
						case ('del'):
							print '<div class="noticia_curta">';
							print "<form action=\"home_cp.php?sec=mediaentrevistas&action=del&tasca=del&id=$entrevista->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
							print '<fieldset><legend class="white">Id: ' . $entrevista->id . ' - Fecha: ' . $entrevista->dia . ' / ' . $entrevista->mes . ' / ' . $entrevista->anydata . '</legend>';
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";

							print 'Eliminar';

							print "\" />";

							print "<p class=\"titol\">Banda: $entrevista->banda</p><br />";
							print "</fieldset>";

							print "</form></div>";
							break;
						case ('edit_del'):
							print '<div class="noticia_curta">';
							print '<fieldset><legend class="white">Id: ' . $entrevista->id . ' - Fecha: ' . $entrevista->dia . ' / ' . $entrevista->mes . ' / ' . $entrevista->anydata . '</legend>';
							print "<form action=\"home_cp.php?sec=entrevistas&action=edit&tasca=edit&id=$entrevista->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";
							print 'Editar';
							print "\" /></form>";
							print "<form action=\"home_cp.php?sec=entrevistas&action=del&tasca=del&id=$entrevista->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";
							print 'Eliminar';
							print "\" /></form>";

							print "<p class=\"titol\">Banda: $entrevista->banda</p><br />";
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
				<a class="linkk" href="home_cp.php?sec=entrevistas&action=edit&punter=1"><img class="ico_navegador"
						src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
				<?php
			}
			if ($punter != 1) {
				$punter_dir = $punter - 10;
				print '<a class="linkk" href="home_cp.php?sec=entrevistas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
			}

			if ($numero >= ($punter + 10)) {
				$punter_dir = $punter + 10;
				print '<a class="linkk" href="home_cp.php?sec=entrevistas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = ((number_format(($numero / $quantitat), 0) * $quantitat) + 1) - 10;
				print '<a class="linkk" href="home_cp.php?sec=entrevistas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
			}
			?>
		</div>
		<?php
	}
}
?>