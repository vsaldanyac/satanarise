<?php
class ob_cp_cronicas
{

	public $formulari_1_ok; /* control dels formularis */
	public $formulari_2_ok; /* control dels formularis */
	public $error;
	public $resultat_consulta;
	public $resultat_consulta2;
	public $numero_resultats;
	public $arxius_pujats;
	public $contador_arxius_pujats;



	public function __construct()
	{
		$this->formulari_1_ok = TRUE;
		$this->formulari_2_ok = TRUE;

		$this->error = 'Errores:<br /> ';
		/*$this->arxius_pujats=array();*/
		$this->contador_arxius_pujats = 0;
	}
	public function recull_parametres_formulari_1($formulari, $cronicas)
	{
		if (isset($formulari['enviat_formulari_1'])) { /* formulari 1 enviat */
			$cronicas->num_div = $formulari['num_div'];
			$cronicas->crear_divisions();
			$this->formulari_1_ok = TRUE;

		}
		return $this->formulari_1_ok;
	}
	public function recull_parametres_formulari_2($formulari, $cronicas)
	{
		if (isset($formulari['enviat_formulari_2'])) { /* formulari 1 enviat */
			$cronicas->num_div = $formulari['num_div'];
			$cronicas->crear_divisions();
			$cronicas->titol = $formulari['titol'];
			$cronicas->idioma = $formulari['idioma'];

			$time_file = (date('Y-m-d H:i:s'));
			$time_file = str_replace('-', '', $time_file);
			$time_file = str_replace(' ', '', $time_file);
			$time_file = str_replace(':', '', $time_file);

			$cronicas->intro_es = $formulari['intro_es'];
			if (($cronicas->intro_es == '') && (($cronicas->idioma == 'ES') || ($cronicas->idioma == 'BOTH'))) {
				$this->error = $this->error . 'No se ha introducido la intro ES.<br />';
				$this->formulari_2_ok = FALSE;
			}
			$cronicas->intro_cat = $formulari['intro_cat'];
			if (($cronicas->intro_cat == '') && (($cronicas->idioma == 'CAT') || ($cronicas->idioma == 'BOTH'))) {
				$this->error = $this->error . 'No se ha introducido la intro CAT.<br />';
				$this->formulari_2_ok = FALSE;
			}
			$cronicas->outro_es = $formulari['outro_es'];
			if (($cronicas->outro_es == '') && (($cronicas->idioma == 'ES') || ($cronicas->idioma == 'BOTH'))) {
				$this->error = $this->error . 'No se ha introducido el final ES.<br />';
				$this->formulari_2_ok = FALSE;
			}
			$cronicas->outro_cat = $formulari['outro_cat'];
			if (($cronicas->outro_cat == '') && (($cronicas->idioma == 'CAT') || ($cronicas->idioma == 'BOTH'))) {
				$this->error = $this->error . 'No se ha introducido el final CAT.<br />';
				$this->formulari_2_ok = FALSE;
			}
			$cronicas->setlist = $formulari['setlist'];
			$cronicas->idcolaborador1 = ($formulari['idcolaborador1']);
			$cronicas->idcolaborador2 = ($formulari['idcolaborador2']);
			$cronicas->idfoto1 = ($formulari['idfoto1']);
			$cronicas->idfoto2 = ($formulari['idfoto2']);
			$minut = date('i');
			$hora = date('H');
			$cronicas->anydata = $formulari['anydata'];
			$cronicas->mes = $formulari['mes'];
			if (($cronicas->mes) < 10)
				$cronicas->mes = '0' . $cronicas->mes;
			$cronicas->dia = $formulari['dia'];
			if (($cronicas->dia) < 10)
				$cronicas->dia = '0' . $cronicas->dia;
			$cronicas->timestamp = $cronicas->anydata . $cronicas->mes . $cronicas->dia . $hora . $minut . '00';
			if (isset($formulari['cartell_off'])) {
				$cronicas->cartell = trim($formulari['cartell_off']);
			} else {
				/* recollir imatge de la banda */
				if (isset($_FILES['fitxer_cartell'])) {
					if ($_FILES['fitxer_cartell']['error'] > 0)
					/* Comprovacio erros al pujar */{
						switch ($_FILES['fitxer_cartell']['error']) {
							case 1:
								$this->error = $this->error . 'El cartel excede del tamaño máximo.<br />';
								$this->formulari_2_ok = FALSE;
								break;
							case 2:
								$this->error = $this->error . 'El cartel excede del tamaño máximo.<br />';
								$this->formulari_2_ok = FALSE;
								break;
							case 4:
								break;
							default:
								$this->error = $this->error . 'Error al subir el cartel.<br />';
								$this->formulari_2_ok = FALSE;
								break;
						}
						if (isset($_POST['cartell_off'])) {
							print 'Hi ha un cartel ja i no sha pujat res';
							$cronicas->cartell = $_POST['cartell_off'];

						}


					} else {
						$ext = '';
						if (stristr($_FILES['fitxer_cartell']['name'], '.jpg') != FALSE)
							$ext = '.jpg';
						if (stristr($_FILES['fitxer_cartell']['name'], '.jpeg') != FALSE)
							$ext = '.jpeg';
						if (stristr($_FILES['fitxer_cartell']['name'], '.gif') != FALSE)
							$ext = '.gif';
						if (stristr($_FILES['fitxer_cartell']['name'], '.png') != FALSE)
							$ext = '.png';
						if ($ext == '') {
							$this->error = $this->error . 'El cartel no es una imagen .<br />';
							$this->formulari_ok = FALSE;
						} else {
							$directori = '../pics/cronicas_pics/' . $time_file . '_c' . $ext;
							if (is_uploaded_file($_FILES['fitxer_cartell']['tmp_name'])) {
								if (!move_uploaded_file($_FILES['fitxer_cartell']['tmp_name'], $directori)) {
									$this->error = $this->error . 'Error al subir el cartel a su carpeta.<br />';
									$this->formulari_2_ok = FALSE;
								} else {
									$cronicas->cartell = $time_file . '_c' . $ext;
								}
							} else {
								$this->error = $this->error . 'Error al subir el cartel.<br />';
								$this->formulari_2_ok = FALSE;
							}
						}
					}
				}
			}
			/* Recuperació de les divisions */
			for ($x = 1; $x <= $cronicas->num_div; $x++) {
				/* Recuperació textes */
				$nom = 'div' . $x;
				$cronicas->$nom->id_cronica = $formulari['id_div_' . $x];
				$cronicas->$nom->texte_es = $formulari['texte_' . $x . '_es'];
				if (($cronicas->$nom->texte_es == '') && (($cronicas->idioma == 'ES') || ($cronicas->idioma == 'BOTH'))) {
					$this->error = $this->error . 'No se ha introducido el texto ' . $i . ' ES.<br />';
					$this->formulari_2_ok = FALSE;

				}
				$cronicas->$nom->texte_cat = $formulari['texte_' . $x . '_cat'];
				if (($cronicas->$nom->texte_cat == '') && (($cronicas->idioma == 'CAT') || ($cronicas->idioma == 'BOTH'))) {
					$this->error = $this->error . 'No se ha introducido el texto ' . $x . ' CAT.<br />';
					$this->formulari_2_ok = FALSE;

				}

				/* recuperacio dels cins arxius */

				$arxius = array('file_' . $x . '_1', 'file_' . $x . '_2', 'file_' . $x . '_3', 'file_' . $x . '_4', 'file_' . $x . '_5');
				for ($i = 1; $i <= 5; $i++) {

					/* Recollir imatge */
					if ($_FILES[$arxius[($i - 1)]]['error'] > 0)
					/* Comprovacio erros al pujar */{
						switch ($_FILES[$arxius[($i - 1)]]['error']) {
							case 1:
								$this->error = $this->error . 'El archivo ' . ($i) . ' de la división ' . $x . ' excede del tamaño máximo.<br />';
								$this->formulari_2_ok = FALSE;
								break;
							case 2:
								$this->error = $this->error . 'El archivo ' . ($i) . ' de la división ' . $x . ' excede del tamaño máximo.<br />';
								$this->formulari_2_ok = FALSE;
								break;
							case 4:
								break;
							default:
								$this->error = $this->error . 'Error al subir el archivo ' . ($i) . ' de la división ' . $x . ' .<br />';
								$this->formulari_2_ok = FALSE;
								break;
						}
						/* si hi ha imatge, copiarla */

						if (isset($_POST['arxius_' . $x . '_' . $i])) {
							print '<p>Hi ha una imatge a la posicio' . ($i) . ' de la división ' . $x . ' </p>';
							$cronicas->$nom->imgs[$i] = $_POST['arxius_' . $x . '_' . $i];

						}

						if (isset($_POST['borrar_' . ($i + 1)])) {
							print 'borrrrrar';
							if (file_exists('../pics/cronicas_pics/' . $cronicas->$nom->imgs[$i])) {
								unlink('../pics/cronicas_pics/' . $cronicas->$nom->imgs[$i]);
							}
							$cronicas->$nom->imgs[$i] = 'borrar';
						}


					} else {
						$ext = '';
						if (stristr($_FILES[$arxius[($i - 1)]]['name'], '.jpg') != FALSE)
							$ext = '.jpg';
						if (stristr($_FILES[$arxius[($i - 1)]]['name'], '.jpeg') != FALSE)
							$ext = '.jpeg';
						if (stristr($_FILES[$arxius[($i - 1)]]['name'], '.gif') != FALSE)
							$ext = '.gif';
						if (stristr($_FILES[$arxius[($i - 1)]]['name'], '.png') != FALSE)
							$ext = '.png';
						if ($ext == '') {
							$this->error = $this->error . 'El archivo no es una imagen ' . ($i) . ' de la división ' . $x . ' .<br />';
							$this->formulari_2_ok = FALSE;
						} else {
							$directori = '../pics/cronicas_pics/' . $time_file . '_' . $x . '_' . $i . $ext;
							if (is_uploaded_file($_FILES[$arxius[($i - 1)]]['tmp_name'])) {
								if (!move_uploaded_file($_FILES[$arxius[($i - 1)]]['tmp_name'], $directori)) {
									$this->error = $this->error . 'Error al subir la imagen ' . ($i) . ' de la división ' . $x . ' a su carpeta.<br />';
									$this->formulari_2_ok = FALSE;
								} else {
									$cronicas->$nom->imgs[$i] = $time_file . '_' . $x . '_' . $i . $ext;

								}
							} else {
								$this->error = $this->error . 'Error al subir la imagen ' . ($i) . ' de la división ' . $x . ' .<br />';
								$this->formulari_2_ok = FALSE;
							}
						}
					}
				}
			}
		}
		return $this->formulari_2_ok;
	}





	public function introduir($bs, $cronicas, $logica_id, $id)
	{

		print 'ID: ' . $cronicas->id . '<br />';
		print 'Divisions: ' . $cronicas->num_div . '<br />';
		print 'Titol: ' . $cronicas->titol . '<br />';
		print 'Ruta cartell: ' . $cronicas->cartell . '<br />';
		print 'Idioma: ' . $cronicas->idioma . '<br />';
		print 'Intro ES: ' . $cronicas->intro_es . '<br />';
		print 'Intro CAT: ' . $cronicas->intro_cat . '<br />';
		for ($x = 1; $x <= $cronicas->num_div; $x++) {
			$nom = 'div' . $x;
			print 'División ' . $x . ':<br />';
			print 'Texto ' . $x . ' ES: ' . $cronicas->$nom->texte_es . '<br />';
			print 'Texto ' . $x . ' CAT: ' . $cronicas->$nom->texte_cat . '<br />';
			for ($i = 1; $i <= 5; $i++) {
				print 'Ruta imagen ' . $i . ': ' . $cronicas->$nom->imgs[$i] . '<br />';
			}
		}
		print 'Final ES: ' . $cronicas->outro_es . '<br />';
		print 'Final CAT: ' . $cronicas->outro_cat . '<br />';
		print 'Id Colaborador 1: ' . $cronicas->idcolaborador1 . '<br />';
		print 'Id Colaborador 2: ' . $cronicas->idcolaborador2 . '<br />';
		print 'Id Foto 1: ' . $cronicas->idcolaborador2 . '<br />';
		print 'Id Foto 2: ' . $cronicas->idcolaborador2 . '<br />';
		print 'Fecha: ' . $cronicas->timestamp . '<br />';
		print 'Link: ' . $cronicas->link . '<br />';

		$cronicas->titol = addslashes($cronicas->titol);
		$cronicas->intro_es = addslashes($cronicas->intro_es);
		$cronicas->intro_cat = addslashes($cronicas->intro_cat);
		$cronicas->outro_es = addslashes($cronicas->outro_es);
		$cronicas->outro_cat = addslashes($cronicas->outro_cat);
		$cronicas->cartell = addslashes($cronicas->cartell);
		$cronicas->setlist = addslashes($cronicas->setlist);
		for ($x = 1; $x <= $cronicas->num_div; $x++) {
			$nom = 'div' . $x;
			$cronicas->$nom->texte_es = addslashes($cronicas->$nom->texte_es);
			$cronicas->$nom->texte_cat = addslashes($cronicas->$nom->texte_cat);
		}
		$cronicas->link = addslashes($cronicas->link);


		if ($logica_id) {
			//$query1="update crxonicass set data='".$cronicas->timestamp."', banda='".$cronicas->banda."', disc='".$cronicas->disc."', portada='".$cronicas->portada."', logo='".$cronicas->logo."', video='".$cronicas->video."', media='".$cronicas->media."', tracklist='".$cronicas->tracklist."', formacio_es='".$cronicas->formacio_es."', formacio_cat='".$cronicas->formacio_cat."', texte_es='".$cronicas->texte_es."', texte_cat='".$cronicas->texte_cat."', idcolaboradors='".$cronicas->idcolaboradors."', nota='".$cronicas->nota."', idpais='".$cronicas->idpais."', any='".$cronicas->any."', idestil='".$cronicas->idestil."', idlabel='".$cronicas->idlabel."', tipus='".$cronicas->tipus."', link='".$cronicas->link."' where idcronicass='".$cronicas->id."'" ;
		} else {
			$query1 = "insert into cronicas (data, titol, cartell, num_div, intro_es, intro_cat, idioma, outro_es, outro_cat, setlist, idcolaborador1, idcolaborador2, idfoto1, idfoto2, link) values ('" . $cronicas->timestamp . "', '" . $cronicas->titol . "', '" . $cronicas->cartell . "', '" . $cronicas->num_div . "', '" . $cronicas->intro_es . "', '" . $cronicas->intro_cat . "', '" . $cronicas->idioma . "', '" . $cronicas->outro_es . "', '" . $cronicas->outro_cat . "', '" . $cronicas->setlist . "', '" . $cronicas->idcolaborador1 . "', '" . $cronicas->idcolaborador2 . "', '" . $cronicas->idfoto1 . "', '" . $cronicas->idfoto2 . "', '" . $cronicas->link . "')";
			$query2 = "select idcronicas from cronicas order by idcronicas desc limit 1";
		}
		$this->resultat_consulta = $bs->query($query1);
		if ($this->resultat_consulta) {
			if (!$logica_id) {

				$this->resultat_consulta = $bs->query($query2);
				$row = $this->resultat_consulta->fetch_assoc();
				$cronicas->id = $row['idcronicas'];

				/* preparem links */

				$cronicas->link = 'type=entrada&id=' . $cronicas->id . '&cont=' . urlencode(convertir_cadena_arxiu($cronicas->titol));
				$query = "update cronicas set link='" . $cronicas->link . "' where idcronicas=" . $cronicas->id;
				$this->resultat_consulta = $bs->query($query);
				if (!$this->resultat_consulta) {
					print '<p class="terminal">Error 1</p>';
				}


			}
			for ($x = 1; $x <= $cronicas->num_div; $x++) {
				$nom = 'div' . $x;
				if (!$logica_id) {
					$query1 = "insert into cronicasdata (idcronicas, texte_es, texte_cat) values (" . $cronicas->id . ", '" . $cronicas->$nom->texte_es . "', '" . $cronicas->$nom->texte_cat . "')";
					$query2 = "select idcronicasdata from cronicasdata where idcronicas=" . $cronicas->id . " order by idcronicasdata desc limit 1 ";

				} else {

				}
				$this->resultat_consulta = $bs->query($query1);
				if ($this->resultat_consulta) {
					$this->resultat_consulta = $bs->query($query2);
					$row = $this->resultat_consulta->fetch_assoc();
					$cronicas->$nom->id_cronica = $row['idcronicasdata'];
					/* intoduir imatges */
					for ($i = 1; $i <= 5; $i++) {
						if ($cronicas->$nom->imgs[$i] != '') {
							$query = "insert into cronicasimgs (idcronicas, idcronicasdata, ordre, ruta) values (" . $cronicas->id . ", " . $cronicas->$nom->id_cronica . ", " . $i . ", '" . $cronicas->$nom->imgs[$i] . "')";
							print $query;
							$this->resultat_consulta = $bs->query($query);
						}
					}
				}



			}
		} else {
			print '<p class="terminal">Error 2</p>';
		}
	}


	public function formulari_1()
	{
		print "<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\">";
		print "<input type=\"hidden\" name=\"enviat_formulari_1\" value=\"si\" \>\n";

		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario para poder mostrar el formualrio de entrada de crónicas.</p></legend>';




		print '<p class="contingut">Numero de divisiones::
			<select name="num_div">';
		for ($i = 1; $i <= 20; $i++) {
			if (1 == $i) {
				print '<option selected="selected" value="' . $i . '">' . $i . '</option>';

			} else {
				print '<option value="' . $i . '">' . $i . '</option>';
			}
		}
		print ' </select></p>';




		print "<input type=\"submit";
		print "\" value=\"";

		print 'Enviar';

		print "\" /></fieldset>";

		print "</form>\n";

	}
	public function formulari_2($cronicas, $basedades)
	{
		print "<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
		print "<input type=\"hidden\" name=\"enviat_formulari_2\" value=\"si\" \>\n";
		print "<input type=\"hidden\" name=\"id\" value=\"$cronicas->id\" \>\n";
		print "<input type=\"hidden\" name=\"link\" value=\"$cronicas->link\" \>\n";

		print '<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />';

		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';


		print '<p class="contingut">Título: <br /><br /><input class="titol_form" type="text" name="titol" maxlength="1000" value="' . $cronicas->titol . '" /></p>';

		print '<p class="contingut">Numero de divisiones:
			<select name="num_div">';
		for ($i = 1; $i <= 20; $i++) {
			if ($cronicas->num_div == $i) {
				print '<option selected="selected" value="' . $i . '">' . $i . '</option>';

			} else {
				print '<option value="' . $i . '">' . $i . '</option>';
			}
		}
		print ' </select></p>';

		print '<p class="contingut">Cartel: <br /><br />';
		if ($cronicas->cartell != '') {
			print '<img src="../pics/cronicas_pics/' . $cronicas->cartell . '" width="325" /><br />';
			print "<input type=\"hidden\" name=\"cartell_off\" value=\"$cronicas->cartell\" \>\n";
		}
		print '<input type="file" name="fitxer_cartell" id="fitxer_cartell"/><br />';
		print '</p>';



		print '<p class="contingut">Idioma
			<select name="idioma">';

		switch ($cronicas->idioma) {
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



		print '<p class="contingut">Intro ES<br /><br />
			<textarea class="texte_form" name="intro_es">' . $cronicas->intro_es . '</textarea></p>';

		print '<p class="contingut">Intro CAT<br /><br />
			<textarea class="texte_form" name="intro_cat">' . $cronicas->intro_cat . '</textarea></p>';

		/* preparar x divisions */

		for ($i = 1; $i <= $cronicas->num_div; $i++) /* Genera x concerts */{

			$nom = 'div' . $i;
			print '<input type="hidden" name="id_div_' . $i . '" value="$cronicas->$nom->id_cronica" >';
			print '<p class="contingut">División ' . $i . ' ES<br /><br />
        		<textarea class="texte_form" name="texte_' . $i . '_es">' . $cronicas->$nom->texte_es . '</textarea></p>';

			print '<p class="contingut">División ' . $i . ' CAT<br /><br />
        		<textarea class="texte_form" name="texte_' . $i . '_cat">' . $cronicas->$nom->texte_cat . '</textarea></p>';

			print '<p class="contingut">Subida de imágenes: <br /><br />';
			for ($x = 1; $x <= 5; $x++) {
				print 'Imagen ' . ($x) . ':<br />';
				if ($cronicas->$nom->imgs[$x] != '') {
					print '<img src="../pics/cronicas_pics/' . $cronicas->$nom->imgs[$x] . '" width="100" /><br />';
					print '<input type="hidden" name="arxius_' . $i . '_' . $x . '" value="' . $cronicas->$nom->imgs[$x] . '" />';
					print '<input type="checkbox" name="borrar_' . $i . '_' . $x . '" value="borrar_' . $i . '_' . $x . '" /> Eliminar<br />';
					print '<input type="file" name="file_' . $i . '_' . $x . '" id="file_' . $i . '_' . $x . '"/><br />';
				} else {
					print '<input type="file" name="file_' . $i . '_' . $x . '" id="file_' . $i . '_' . $x . '"/><br />';
				}
			}
			print '</p>';
		}


		print '<p class="contingut">Final ES<br /><br />
			<textarea class="texte_form" name="outro_es">' . $cronicas->outro_es . '</textarea></p>';

		print '<p class="contingut">Final CAT<br /><br />
			<textarea class="texte_form" name="outro_cat">' . $cronicas->outro_cat . '</textarea></p>';

		print '<p class="contingut">SETLISTS:<br /><br />Copiar para Setlist:<br />' . htmlspecialchars('<div id="setlists"><div class="centrar">
             <h5 class="tl"><span class="cursiva">Set List Banda</span><br /><br />
Tema 1<br />Tema2<br />Tema 3<br />Tema 4</h5>') . '<br />' . htmlspecialchars('<h5 class="tl"><span class="cursiva">Set List Banda</span><br /><br />
Tema 1<br />Tema2<br />Tema 3<br />Tema 4</h5>') . '<br />' . htmlspecialchars('</div></div>') . '<br /><br />';
		print '<textarea class="texte_form" name="setlist">' . $cronicas->setlist . '</textarea></p>';


		print '<p class="contingut">Autor 1: <br /><br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idcolaborador1">';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($cronicas->idcolaborador1 == $row['idcolaboradors']) {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '" selected="selected">' . $row['nom'] . '</option>';
			} else {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '">' . $row['nom'] . '</option>';
			}
		}
		$x = $x . '</select></p>';
		print $x;

		print '<p class="contingut">Autor 2: <br /><br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idcolaborador2">';
		$x = $x . '<option value="0" selected="selected">No</option>';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($cronicas->idcolaborador2 == $row['idcolaboradors']) {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '" selected="selected">' . $row['nom'] . '</option>';
			} else {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '">' . $row['nom'] . '</option>';
			}
		}
		$x = $x . '</select></p>';
		print $x;

		print '<p class="contingut">Fotos 1: <br /><br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idfoto1">';
		$x = $x . '<option value="0" selected="selected">No</option>';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($cronicas->idfoto1 == $row['idcolaboradors']) {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '" selected="selected">' . $row['nom'] . '</option>';
			} else {
				$x = $x . '<option value="' . $row['idcolaboradors'] . '">' . $row['nom'] . '</option>';
			}
		}
		$x = $x . '</select></p>';
		print $x;

		print '<p class="contingut">Fotos 2: <br /><br />';
		$this->consulta_colaboradors($basedades);
		$x = '<select name="idfoto2">';
		$x = $x . '<option value="0" selected="selected">No</option>';
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			if ($cronicas->idfoto2 == $row['idcolaboradors']) {
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
			if ($cronicas->dia == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Mes <select name="mes">';
		for ($y = 1; $y <= 12; $y++) {
			if ($cronicas->mes == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Año <select name="anydata">';
		for ($y = 2024; $y <= 2024; $y++) {
			if ($cronicas->anydata == $y) {
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

	public function consulta_cronicas($basedades, $desde, $quantitat)
	/* consulta media a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
		$inici = $desde - 1;

		/* Recupera les 10 primeres ID */
		$query = "select idcronicas from cronicas order by data desc limit " . $inici . ", " . $quantitat . " ";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la id de las cronicas a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
				/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */

			}
		}

	}

	public function extreu_dades_cronicas_per_id($bd, $cronicas, $id)
	/* Extreu dades d'una unica crónica */
	{
		$query = "select * from cronicas where idcronicas = " . $id;

		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la cronicas</p>';
		} else {
			$resultat = $this->resultat_consulta->fetch_assoc();
			$cronicas->id = $resultat['idcronicas'];
			$cronicas->timestamp = $resultat['data'];
			$cronicas->titol = $resultat['titol'];
			$cronicas->cartell = $resultat['cartell'];
			$cronicas->num_div = $resultat['num_div'];
			$cronicas->intro_es = $resultat['intro_es'];
			$cronicas->intro_cat = $resultat['intro_cat'];
			$cronicas->outro_es = $resultat['outro_es'];
			$cronicas->outro_cat = $resultat['outro_cat'];
			$cronicas->idioma = $resultat['idioma'];
			$cronicas->colaborador1 = $resultat['colaborador1'];
			$cronicas->colaborador2 = $resultat['colaborador2'];
			$cronicas->foto1 = $resultat['foto1'];
			$cronicas->foto2 = $resultat['foto2'];
			$cronicas->link = $resultat['link'];
			$cronicas->dia = substr($cronicas->timestamp, 8, 2);
			$cronicas->anydata = substr($cronicas->timestamp, 0, 4);
			$cronicas->mes = substr($cronicas->timestamp, 5, 2);
			// crear divisions 
			$cronicas->crear_divisions();

			$query = "select * from cronicasdata where idcronicas = " . $cronicas->id . " order by idcronicasdata";
			$this->resultat_consulta = $bd->query($query);
			if ($this->resultat_consulta == FALSE) {
				print '<p class="terminal">Error al extraer de cronicasdata</p>';
			} else {
				for ($i = 1; $i <= $cronicas->num_div; $i++) {
					$nom = 'div' . $i;
					$resultat = $this->resultat_consulta->fetch_assoc();
					$cronicas->$nom->id = $resultat['idcronicasdata'];
					$cronicas->$nom->id_cronica = $resultat['idcronicas'];
					$cronicas->$nom->texte_es = $resultat['texte_es'];
					$cronicas->$nom->texte_cat = $resultat['texte_cat'];
					/*$query= "select * from cronicasimgs where idcronicasdata = ".$cronicas->$nom->id." order by ordre";
					$this->resultat_consulta2=$bd->query($query);
					if ($this->resultat_consulta2==FALSE) 
					{ 
								   print '<p class="terminal">Error al extraer de cronicasimgs</p>';			 
					} else {
						$this->numero_resultats=$this->resultat_consulta2->num_rows;
						print '<p class="terminal">Num Results: '.$this->numero_resultats.'</p>';
						for ($x=1;$x<=$this->numero_resultats;$x++)
						{
							$resultat2=$this->resultat_consulta->fetch_assoc();
							$cronicas->$nom->imgs[$x]=$resultat2['ruta'];
						}                     
					}*/
				}
			}
		}
	}

	public function eliminar_registre($bd, $id)
	{


		$query = "delete from cronicas where idcronicas = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Registro borrado</p>';
		} else {
			print '<p class="terminal">Delete de news fallido</p>';
		}

		$query = "select cartell from cronicas where idcronicas = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		$resultat = $this->resultat_consulta->fetch_assoc();
		if (file_exists('../pics/cronicas_pics/' . $resultat['cartell'])) {
			unlink('../pics/cronicas_pics/' . $resultat['cartell']);
		}

		$query = "delete from cronicasdata where idcronicas = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Registro borrado</p>';
		} else {
			print '<p class="terminal">Delete de news fallido</p>';
		}

		$query = "select ruta from cronicasimgs where idcronicas = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		$numero = $this->resultat_consulta->num_rows;
		if ($numero >= 0) {
			for ($i = 0; $i < $numero; $i++) {
				$resultat = $this->resultat_consulta->fetch_assoc();
				if (file_exists('../pics/cronicas_pics/' . $resultat['ruta'])) {
					unlink('../pics/cronicas_pics/' . $resultat['ruta']);

				}

			}
		}

		$query = "delete from cronicasimgs where idcronicas = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Registro borrado</p>';
		} else {
			print '<p class="terminal">Delete de news fallido</p>';
		}


	}
	public function presentar_cronicas_formulari($bd, $tasca, $cronicas)
	/* tenint l'objecte de la consulta les posa a pantalla */
	{
		print $this->numero_resultats;
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			$cronicas->id = $row['idcronicas'];
			$query = "select titol, cartell, data from cronicas where idcronicas=" . $cronicas->id;
			$this->resultat_consulta2 = $bd->query($query);
			if (!$this->resultat_consulta2 == FALSE) {
				if (($this->resultat_consulta2->num_rows) == 1) {
					$row = $this->resultat_consulta2->fetch_assoc();
					$cronicas->titol = $row['titol'];
					$cronicas->cartell = $row['cartell'];
					$cronicas->timestamp = $row['data'];
					$cronicas->dia = substr($cronicas->timestamp, 8, 2);
					$cronicas->anydata = substr($cronicas->timestamp, 0, 4);
					$cronicas->mes = substr($cronicas->timestamp, 5, 2);

					print '<div class="noticia_curta">';
					switch ($tasca) {
						case ('editar'):
							print '<div class="noticia_curta">';
							print "<form action=\"home_cp.php?sec=cronicas&action=edit&tasca=edit&id=$cronicas->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
							print '<fieldset><legend class="white">Id: ' . $cronicas->id . ' - Fecha: ' . $cronicas->dia . ' / ' . $cronicas->mes . ' / ' . $cronicas->anydata . '</legend>';
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";

							print 'Editar';

							print "\" />";
							print "<img src=\"../pics/cronicas_pics/$cronicas->cartell\" height=\"200\" /><br />";
							print "<p class=\"titol\">Croncierto: $cronicas->titol</p><br />";

							print "</fieldset>";

							print "</form></div>";
							break;
						case ('del'):
							print '<div class="noticia_curta">';
							print "<form action=\"home_cp.php?sec=mediacronicas&action=del&tasca=del&id=$cronicas->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
							print '<fieldset><legend class="white">Id: ' . $cronicas->id . ' - Fecha: ' . $cronicas->dia . ' / ' . $cronicas->mes . ' / ' . $cronicas->anydata . '</legend>';
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";

							print 'Eliminar';

							print "\" />";

							print "<img src=\"../pics/cronicas_pics/$cronicas->cartell\" height=\"200\" /><br />";
							print "<p class=\"titol\">Croncierto: $cronicas->titol</p><br />";
							print "</fieldset>";

							print "</form></div>";
							break;
						case ('edit_del'):
							print '<div class="noticia_curta">';
							print '<fieldset><legend class="white">Id: ' . $cronicas->id . ' - Fecha: ' . $cronicas->dia . ' / ' . $cronicas->mes . ' / ' . $cronicas->anydata . '</legend>';
							print "<form action=\"home_cp.php?sec=cronicas&action=edit&tasca=edit&id=$cronicas->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";
							print 'Editar';
							print "\" /></form>";
							print "<form action=\"home_cp.php?sec=cronicas&action=del&tasca=del&id=$cronicas->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";
							print 'Eliminar';
							print "\" /></form>";

							print "<img src=\"../pics/cronicas_pics/$cronicas->cartell\" height=\"200\" /><br />";
							print "<p class=\"titol\">Croncierto: $cronicas->titol</p><br />";

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
				<a class="linkk" href="home_cp.php?sec=cronicas&action=edit&punter=1"><img class="ico_navegador"
						src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
				<?php
			}
			if ($punter != 1) {
				$punter_dir = $punter - 10;
				print '<a class="linkk" href="home_cp.php?sec=cronicas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
			}

			if ($numero >= ($punter + 10)) {
				$punter_dir = $punter + 10;
				print '<a class="linkk" href="home_cp.php?sec=cronicas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = ((number_format(($numero / $quantitat), 0) * $quantitat) + 1) - 10;
				print '<a class="linkk" href="home_cp.php?sec=cronicas&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
			}
			?>
		</div>
		<?php
	}
}
?>