<?php

class cp_colaboradors
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

	public function recull_parametres($formulari, $colaborador) /* Mira si hi ha un formulari enviat i recull parametres */
	{
		if ($_POST['enviat'] == 'si') {
			$this->formulari_ok = TRUE;
			if ($_POST['id'] != '') {
				$colaborador->id = trim($_POST['id']);
			}
			$colaborador->nom = htmlspecialchars(trim($_POST['nom']));
			if ($colaborador->nom == '') {
				$this->error = $this->error . 'No se ha rellenado el nombre.<br />';
				$this->formulari_ok = FALSE;
			}

			$colaborador->carreg_es = htmlspecialchars(trim($_POST['carreg_es']));
			$colaborador->carreg_cat = htmlspecialchars(trim($_POST['carreg_cat']));

			$colaborador->ruta = $_POST['foto_antiga'];



			$colaborador->mail = ($_POST['email']);
			if ($colaborador->mail != '') {
				if (!(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $colaborador->mail))) {
					$this->error = $this->error . 'El e-mail no es correcto.<br />';
					$this->formulari_ok = FALSE;
				}
			}

			$colaborador->tipus = ($_POST['tipus']);
			$colaborador->actiu = ($_POST['actiu']);

			$colaborador->bio_es = ($_POST['bio_es']);
			if ($colaborador->bio_es == '') {
				$this->error = $this->error . 'No se ha rellenado la biografía en castellano.<br />';
				$this->formulari_ok = FALSE;
			}

			$colaborador->bio_cat = ($_POST['bio_cat']);
			if ($colaborador->bio_cat == '') {
				$this->error = $this->error . 'No se ha rellenado la biografía en catalán.<br />';
				$this->formulari_ok = FALSE;
			}
			/* recollir imatge */
			if (isset($_FILES['foto'])) {
				if ($_FILES['foto']['error'] > 0)
				/* Comprovacio erros al pujar */{
					switch ($_FILES['foto']['error']) {
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
							$this->error = $this->error . 'Error al subir el archivo ' . $_FILES['foto'] . '.<br />';
							$this->formulari_ok = FALSE;
							break;
					}
				} else {
					$ext = '';
					if (stristr($_FILES['foto']['name'], '.jpg') != FALSE)
						$ext = '.jpg';
					if (stristr($_FILES['foto']['name'], '.webp') != FALSE)
						$ext = '.webp';
					if (stristr($_FILES['foto']['name'], '.jpeg') != FALSE)
						$ext = '.jpeg';
					if (stristr($_FILES['foto']['name'], '.gif') != FALSE)
						$ext = '.gif';
					if (stristr($_FILES['foto']['name'], '.png') != FALSE)
						$ext = '.png';
					if ($ext == '') {
						$this->error = $this->error . 'El archivo no es una imagen de formato válido.<br />';
						$this->formulari_ok = FALSE;
					} else {
						$directori = '../pics/staff/' . $_FILES['foto']['name'];
						if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
							if (!move_uploaded_file($_FILES['foto']['tmp_name'], $directori)) {
								$this->error = $this->error . 'Error al subir la imagen a su carpeta.<br />';
								$this->formulari_ok = FALSE;
							} else {
								$colaborador->ruta = $_FILES['foto']['name'];
							}
						} else {
							$this->error = $this->error . 'Error al subir la imagen.<br />';
							$this->formulari_ok = FALSE;
						}
					}
				}
			}
		}
		return ($this->formulari_ok);
	}


	public function introduir($bs, $colaborador, $logica_id)
	{

		$colaborador->nom = addslashes($colaborador->nom);
		$colaborador->mail = addslashes($colaborador->mail);
		$colaborador->bio_es = addslashes($colaborador->bio_es);
		$colaborador->bio_cat = addslashes($colaborador->bio_cat);
		$colaborador->carreg_es = addslashes($colaborador->carreg_es);
		$colaborador->carreg_cat = addslashes($colaborador->carreg_cat);



		if ($logica_id) {
			$query1 = "update colaboradors set nom='" . $colaborador->nom . "', mail='" . $colaborador->mail . "', tipus='" . $colaborador->tipus . "', actiu='" . $colaborador->actiu . "', bio_cat='" . $colaborador->bio_cat . "', ruta='" . $colaborador->ruta . "', carreg_es='" . $colaborador->carreg_es . "', carreg_cat='" . $colaborador->carreg_cat . "', bio_es='" . $colaborador->bio_es . "' where idcolaboradors=" . $colaborador->id . "";
		} else {
			$query1 = "insert into colaboradors (nom, mail, tipus, actiu, ruta, bio_es, bio_cat, carreg_es, carreg_cat) values ('" . $colaborador->nom . "', '" . $colaborador->mail . "', '" . $colaborador->tipus . "', '" . $colaborador->actiu . "', '" . $colaborador->ruta . "', '" . $colaborador->bio_es . "', '" . $colaborador->bio_cat . "', '" . $colaborador->carreg_es . "', '" . $colaborador->carreg_cat . "')";

		}
		print $query1;
		$this->resultat_consulta = $bs->query($query1);
		if ($this->resultat_consulta) {
			print '<p class="terminal">¡¡colaborador añadido!!</p>';
		} else {
			print '<p class="terminal">Error</p>';
		}
	}

	public function inicialitzar_noticia($colaborador) /* Inicialitza l'objecte*/
	{
		$colaborador->reset_noticia();
	}

	public function formulari($colaborador)
	{
		print "<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
		print "<input type=\"hidden\" name=\"id\" value=\"$colaborador->id\" \>\n";


		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';


		print '<p class="contingut">Nombre: <br />';

		print '<br /><input class="texte_form" type="text" name="nom" maxlength="1000" value="' . $colaborador->nom . '" />';
		print '</p>';

		print '<p class="contingut">E-mail: <br />';
		print '<br /><input class="texte_form" type="text" name="email" maxlength="1000" value="' . $colaborador->mail . '" />';
		print '</p>';

		print '<p class="contingut">Categoría
			<select name="tipus">';

		switch ($colaborador->tipus) {
			case '1':
				print '<option value="1" selected="selected">Responsable</option>
					<option value="2">Staff</option>
					<option value="3">Redactor</option>
                    <option value="4">Colaborador</option>';
				break;
			case '2':
				print '<option value="1">Responsable</option>
					<option value="2" selected="selected">Consejo de Redacción - Staff</option>
					<option value="3">Redactor</option>
                    <option value="4">Colaborador</option>';
				break;
			case '3':
				print '<option value="1">Responsable</option>
					<option value="2">Consell de Redacció - Staff</option>
					<option value="3" selected="selected">Redactor</option>
                    <option value="4">Colaborador</option>';
				break;
			case '4':
				print '<option value="1">Responsable</option>
					<option value="2">Consejo de Redacción - Staff</option>
					<option value="3">Redactor</option>
                    <option value="4" selected="selected">Colaborador</option>';
				break;
			default:
				print '<option value="1">Responsable</option>
					<option value="2">Consell de Redacció - Staff</option>
					<option value="3">Redactor</option>
                    <option value="4">Colaborador</option>';
				break;
		}

		print '</select></p>';

		print '<p class="contingut">Cargo ES: <br />';
		print '<br /><input class="titol_form" type="text" name="carreg_es" maxlength="1000" value="' . $colaborador->carreg_es . '" />';
		print '</p>';

		print '<p class="contingut">Cargo CAT: <br />';
		print '<br /><input class="titol_form" type="text" name="carreg_cat" maxlength="1000" value="' . $colaborador->carreg_cat . '" />';
		print '</p>';


		print '<p class="contingut">Activo:
			<select name="actiu">';

		switch ($colaborador->actiu) {
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

		print '<p class="contingut">Biografía ES:<br /><br />
			<textarea class="texte_form" name="bio_es">' . $colaborador->bio_es . '</textarea></p>';

		print '<p class="contingut">Biografía CAT:<br /><br />
			<textarea class="texte_form" name="bio_cat">' . $colaborador->bio_cat . '</textarea></p>';

		print '<p class="contingut">Imagen:<br /><br />';

		if (($colaborador->ruta != '') && (file_exists('../pics/staff/' . $colaborador->ruta))) {
			print '<img src="../pics/staff/' . $colaborador->ruta . '" width="200" /><br />';
			print "<input type=\"hidden\" name=\"foto_antiga\" value=\"$colaborador->ruta\" \>\n";
		}

		print '<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />';
		print '<input type="file" name="foto" id="foto"/><br />';
		print '</p>';

		print "<input type=\"submit";
		print "\" value=\"";

		print 'Enviar';

		print "\" /></fieldset>";

		print "</form>\n";

	}

	public function consulta_colaboradors($basedades)
	/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */


		/* Recupera les 10 primeres ID */
		$query = "select idcolaboradors, nom, mail, tipus, actiu from colaboradors order by idcolaboradors asc";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la id de los colaboradors a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
				/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */

			}
		}

	}

	public function extreu_dades_colaborador_per_id($bd, $colaborador)
	/* Extreu dades d'una unica noticia */
	{
		$query = "select nom, mail, tipus, actiu, ruta, bio_es, bio_cat, carreg_es, carreg_cat from colaboradors where idcolaboradors = " . $colaborador->id;

		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer el colaborador</p>';
		} else {
			$resultat = $this->resultat_consulta->fetch_assoc();
			$colaborador->mail = $resultat['mail'];
			$colaborador->nom = $resultat['nom'];
			$colaborador->tipus = $resultat['tipus'];
			$colaborador->actiu = $resultat['actiu'];
			$colaborador->ruta = $resultat['ruta'];
			$colaborador->bio_es = $resultat['bio_es'];
			$colaborador->bio_cat = $resultat['bio_cat'];
			$colaborador->carreg_es = $resultat['carreg_es'];
			$colaborador->carreg_cat = $resultat['carreg_cat'];
		}
	}

	public function eliminar_registre($bd, $id)
	{
		$query = "delete from colaboradors where idcolaboradors = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">Registro borrado</p>';
		} else {
			print '<p class="terminal">Delete de colaboradors fallido</p>';
		}


	}
	public function presentar_colaboradors_formulari($bd, $tasca, $colaborador)
	/* tenint l'objecte de la consulta les posa a pantalla */
	{

		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			$colaborador->id = $row['idcolaboradors'];
			$colaborador->nom = $row['nom'];
			$colaborador->mail = $row['mail'];
			$colaborador->tipus = $row['tipus'];
			$colaborador->actiu = $row['actiu'];
			switch ($tasca) {
				case ('editar'):
					print '<div class="noticia_curta">';
					print "<form action=\"home_cp.php?sec=colaboradores&action=edit&tasca=edit&id=$colaborador->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
							<p class=\"form_data\">";
					print '<fieldset><legend class="white">Id: ' . $colaborador->id . '</legend>';
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";

					print 'Editar';

					print "\" />";
					print "<p class=\"titol\">Colaborador: $colaborador->nom<br />
                        E-mail: $colaborador->mail<br />
                        Tipus: ";
					switch ($colaborador->tipus) {
						case '1':
							print 'Responsable';
							break;
						case '2':
							print 'Consejo de Redacción - Staff';
							break;
						case '3':
							print 'Redactor';
							break;
						case '4':
							print 'Colaborador';
							break;
					}
					print " <br />Actiu: ";
					switch ($colaborador->actiu) {
						case '1':
							print 'Si';
							break;
						case '2':
							print 'No';
							break;
					}
					print " <br />
                        </p><br />";
					print "</fieldset>";

					print "</form></div>";
					break;
				case ('del'):
					print '<div class="noticia_curta">';
					print "<form action=\"home_cp.php?sec=colaboradores&action=del&tasca=del&id=$colaborador->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
							<p class=\"form_data\">";
					print '<fieldset><legend class="white">Id: ' . $colaborador->id . '</legend>';
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";

					print 'Eliminar';

					print "\" />";

					print "<p class=\"titol\">Colaborador: $colaborador->nom<br />
                        E-mail: $colaborador->mail<br />
                        Tipus: ";
					switch ($colaborador->tipus) {
						case '1':
							print 'Responsable';
							break;
						case '2':
							print 'Consell de Redacció - Staff';
							break;
						case '3':
							print 'Redactor';
							break;
						case '4':
							print 'Colaborador';
							break;
					}
					print " <br />Actiu: ";
					switch ($colaborador->actiu) {
						case '1':
							print 'Si';
							break;
						case '2':
							print 'No';
							break;
					}
					print " <br />
                        </p><br />";
					print "</fieldset>";

					print "</form></div>";
					break;
				case ('edit_del'):
					print '<div class="noticia_curta">';
					print '<fieldset><legend class="white">Id: ' . $colaborador->id . '</legend>';
					print "<form action=\"home_cp.php?sec=colaboradors&action=edit&tasca=edit&id=$colaborador->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";
					print 'Editar';
					print "\" /></form>";
					print "<form action=\"home_cp.php?sec=colaboradors&action=del&tasca=del&id=$colaborador->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";
					print 'Eliminar';
					print "\" /></form>";

					print "<p class=\"titol\">Colaborador: $colaborador->nom<br />
                        E-mail: $colaborador->mail<br />
                        Tipus: ";
					switch ($colaborador->tipus) {
						case '1':
							print 'Responsable';
							break;
						case '2':
							print 'Consell de Redacció - Staff';
							break;
						case '3':
							print 'Redactor';
							break;
						case '4':
							print 'Colaborador';
							break;
					}
					print " <br />Actiu: ";
					switch ($colaborador->actiu) {
						case '1':
							print 'Si';
							break;
						case '2':
							print 'No';
							break;
					}
					print " <br />
                        </p><br />";
					print "</fieldset>";
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

			<?php if ($punter != 1) {
				?>
				<a class="linkk" href="index_cp.php?sec=colaboradors&action=edit&punter=1"><img class="ico_navegador"
						src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
				<?php
			}
			if ($punter != 1) {
				$punter_dir = $punter - 10;
				print '<a class="linkk" href="index_cp.php?sec=colaboradors&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
			}

			if ($numero >= ($punter + 10)) {
				$punter_dir = $punter + 10;
				print '<a class="linkk" href="index_cp.php?sec=colaboradors&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = ((number_format(($numero / $quantitat), 0) * $quantitat) + 1) - 10;
				print '<a class="linkk" href="index_cp.php?sec=colaboradors&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
			}
			?>
		</div>
		<?php
	}
}
?>