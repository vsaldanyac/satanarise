<?php
class cp_users
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

	public function recull_parametres($formulari, $user) /* Mira si hi ha un formulari enviat i recull parametres */
	{
		if ($_POST['enviat'] == 'si') {
			$this->formulari_ok = TRUE;
			if ($_POST['id'] != '') {
				$user->id = trim($_POST['id']);
			}
			$user->user = htmlspecialchars(trim($_POST['user']));
			if ($user->user == '') {
				$this->error = $this->error . 'No se ha rellenado el usuario.<br />';
				$this->formulari_ok = FALSE;
			}
			$user->pass = ($_POST['pass']);
			if ($user->pass == '') {
				$this->error = $this->error . 'No se ha rellenado la contraseña.<br />';
				$this->formulari_ok = FALSE;
			}
			$user->email = ($_POST['email']);
			if ($user->email == '') {
				$this->error = $this->error . 'No se ha rellenado el correo.<br />';
				$this->formulari_ok = FALSE;
			}
		}
		return ($this->formulari_ok);
	}


	public function introduir($bs, $user, $logica_id)
	{
		$user->user = addslashes($user->user);
		$user->email = addslashes($user->email);
		$user->pass = addslashes($user->pass);
		$user->pass = sha1($user->pass);

		if ($logica_id) {
			$query1 = "update users set name='" . $user->user . "', pass='" . $user->pass . "', mail='" . $user->email . "' where id_user=" . $user->id . "";
		} else {
			$query1 = "insert into users (name, pass, mail) values ('" . $user->user . "', '" . $user->pass . "', '" . $user->email . "')";

		}
		$this->resultat_consulta = $bs->query($query1);
		if ($this->resultat_consulta) {
			print '<p class="terminal">¡¡Usuario añadido!!</p>';
		} else {
			print '<p class="terminal">Error</p>';
		}
	}

	public function inicialitzar_noticia($user) /* Inicialitza l'objecte*/
	{

		$user->reset_noticia();



	}

	public function formulari($user)
	{
		print "<form action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
		print "<input type=\"hidden\" name=\"id\" value=\"$user->id\" \>\n";


		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';


		print '<p class="contingut">Usuario<br />';

		print '<br /><input class="texte_form" type="text" name="user" maxlength="1000" value="' . $user->user . '" />';
		print '</p>';

		print '<p class="contingut">Contraseña<br />';
		print '<br /><input class="texte_form" type="text" name="pass" maxlength="1000" value="' . $user->pass . '" />';
		print '</p>';

		print '<p class="contingut">Correo<br />';
		print '<br /><input class="texte_form" type="text" name="email" maxlength="1000" value="' . $user->email . '" />';
		print '</p>';


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
		$query = "select id_user, name from users order by id_user asc";

		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer la id de los usuarios a mostrar.</p>';
		} else {

			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
				/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */

			}
		}

	}

	public function extreu_dades_noticia_per_id($bd, $user)
	/* Extreu dades d'una unica noticia */
	{
		$query = "select name, mail from users where id_user = " . $user->id;

		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer el usuario</p>';
		} else {
			$resultat = $this->resultat_consulta->fetch_assoc();
			$user->email = $resultat['mail'];
			$user->user = $resultat['name'];
		}
	}

	public function eliminar_registre($bd, $id)
	{
		$query = "select name from users where id_user = '" . $id . "'";
		$this->resultat_consulta = $bd->query($query);
		$resultat = $this->resultat_consulta->fetch_assoc();
		$name = $resultat['name'];
		if ($name != $_SESSION['valid_user']) {
			$query = "delete from users where id_user = '" . $id . "'";
			$this->resultat_consulta = $bd->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">Registro borrado</p>';
			} else {
				print '<p class="terminal">Delete de users fallido</p>';
			}
		} else {
			print '<p class="terminal">No puedes eliminarte a ti mismo.</p>';
		}

	}
	public function presentar_noticies_formulari($bd, $tasca, $user)
	/* tenint l'objecte de la consulta les posa a pantalla */
	{
		print $this->numero_resultats;
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			$user->id = $row['id_user'];
			$user->user = $row['name'];
			switch ($tasca) {
				case ('editar'):
					print '<div class="noticia_curta">';
					print "<form action=\"home_cp.php?sec=usuarios&action=edit&tasca=edit&id=$user->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
							<p class=\"form_data\">";
					print '<fieldset><legend class="white">Id: ' . $user->id . '</legend>';
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";

					print 'Editar';

					print "\" />";
					print "<p class=\"titol\">Usuario: $user->user</p><br />";
					print "</fieldset>";

					print "</form></div>";
					break;
				case ('del'):
					print '<div class="noticia_curta">';
					print "<form action=\"home_cp.php?sec=usuarios&action=del&tasca=del&id=$user->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
							<p class=\"form_data\">";
					print '<fieldset><legend class="white">Id: ' . $user->id . '</legend>';
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";

					print 'Eliminar';

					print "\" />";

					print "<p class=\"titol\">Usuario: $user->user</p><br />";
					print "</fieldset>";

					print "</form></div>";
					break;
				case ('edit_del'):
					print '<div class="noticia_curta">';
					print '<fieldset><legend class="white">Id: ' . $user->id . '</legend>';
					print "<form action=\"home_cp.php?sec=usuarios&action=edit&tasca=edit&id=$user->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";
					print 'Editar';
					print "\" /></form>";
					print "<form action=\"home_cp.php?sec=usuarios&action=del&tasca=del&id=$user->id&formulari=TRUE\" method=\"post\">";
					print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
					print "<input class=\"esq\" type=\"submit";
					print "\" value=\"";
					print 'Eliminar';
					print "\" /></form>";

					print "<p class=\"titol\">Usuario: $user->user</p><br />";
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
				<a class="linkk" href="index_cp.php?sec=usuarios&action=edit&punter=1"><img class="ico_navegador"
						src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
				<?php
			}
			if ($punter != 1) {
				$punter_dir = $punter - 10;
				print '<a class="linkk" href="index_cp.php?sec=usuarios&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
			}

			if ($numero >= ($punter + 10)) {
				$punter_dir = $punter + 10;
				print '<a class="linkk" href="index_cp.php?sec=usuarios&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = ((number_format(($numero / $quantitat), 0) * $quantitat) + 1) - 10;
				print '<a class="linkk" href="index_cp.php?sec=usuarios&action=' . $action . '&punter=' . $punter_dir . '"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
			}
			?>
		</div>
		<?php
	}
}
?>