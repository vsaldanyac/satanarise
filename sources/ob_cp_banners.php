<?php
class cp_banner
{

	public $formulari_ok; /* control dels formularis */
	public $tipo; /* 700 o 100 */
	public $img;
	public $link;
	public $texte;
	public $datafi; /* format yyyymmdd */
	public $dia;
	public $mes;
	public $any;
	public $warn_small_dims;
	public $needs_dim_confirm;
	public $error;
	public $resultat_consulta;
	public $resultat_consulta2;
	public $numero_resultats;
	public $id;



	public function __construct()
	{
		$this->formulari_ok = FALSE;
		$this->error = 'Error: ';
		$this->warn_small_dims = array();
		$this->needs_dim_confirm = FALSE;
	}

	public function recull_parametres($formulari) /* Mira si hi ha un formulari enviat i recull parametres */
	{
		if ($formulari['enviat'] == 'si') {
			$this->formulari_ok = TRUE;
			$this->tipo = trim($formulari['tipo']);
			$this->link = htmlspecialchars(trim($formulari['link']));
			$this->texte = htmlspecialchars(trim($formulari['texte']));

			$this->dia = $formulari['dia'];
			$this->mes = $formulari['mes'];
			$this->any = $formulari['any'];
			if ($this->mes < 10)
				$this->mes = '0' . $this->mes;
			if ($this->dia < 10)
				$this->dia = '0' . $this->dia;
			$this->datafi = $this->any . $this->mes . $this->dia;

			$time_file = str_replace(array('-', ' ', ':'), '', date('Y-m-d H:i:s'));

			if ($_FILES['fitxer_img']['error'] > 0)
			/* Comprovacio erros al pujar */{
				switch ($_FILES['fitxer_img']['error']) {
					case 1:
					case 2:
						$this->error = $this->error . 'El archivo excede del tamaño máximo.<br />';
						$this->formulari_ok = FALSE;
						break;
					case 4:
						/* no s'ha enviat cap fitxer nou */
						break;
					default:
						$this->error = $this->error . 'Error al subir la imagen.<br />';
						$this->formulari_ok = FALSE;
						break;
				}
				if (isset($_POST['img_off'])) {
					$this->img = $_POST['img_off'];
				}
			} else {
				$ext = '';
				$nom_arxiu = $_FILES['fitxer_img']['name'];
				if (stristr($nom_arxiu, '.webp') != FALSE)
					$ext = '.webp';
				if (stristr($nom_arxiu, '.jpg') != FALSE)
					$ext = '.jpg';
				if (stristr($nom_arxiu, '.jpeg') != FALSE)
					$ext = '.jpeg';
				if (stristr($nom_arxiu, '.gif') != FALSE)
					$ext = '.gif';
				if (stristr($nom_arxiu, '.png') != FALSE)
					$ext = '.png';
				if ($ext == '') {
					$this->error = $this->error . 'El archivo no es una imagen.<br />';
					$this->formulari_ok = FALSE;
				} else {
					$nom_final = $time_file . $ext;
					$directori = '../pics/banner/' . $nom_final;
					if (is_uploaded_file($_FILES['fitxer_img']['tmp_name'])) {
						if (!move_uploaded_file($_FILES['fitxer_img']['tmp_name'], $directori)) {
							$this->error = $this->error . 'Error al subir la imagen a su carpeta.<br />';
							$this->formulari_ok = FALSE;
						} else {
							$this->img = $nom_final;
							$img_info = @getimagesize($directori);
							if ($img_info !== FALSE) {
								$orig_w = $img_info[0];
								$orig_h = $img_info[1];
								if ($this->tipo == '700') {
									$dims_ok = (($orig_w == 700) && ($orig_h == 100));
									$requerit = '700x100px';
								} else {
									$dims_ok = ($orig_h == 100);
									$requerit = 'cualquier ancho x 100px de alto';
								}
								if (!$dims_ok) {
									if ((!isset($_POST['confirm_small_img'])) || ($_POST['confirm_small_img'] !== 'si')) {
										$this->warn_small_dims[] = 'La imagen mide ' . $orig_w . 'x' . $orig_h . 'px y se requiere ' . $requerit . '.';
										$this->needs_dim_confirm = TRUE;
										$this->formulari_ok = FALSE;
									}
								}
							}
						}
					} else {
						$this->error = $this->error . 'Error al subir la imagen.<br />';
						$this->formulari_ok = FALSE;
					}
				}
			}
		}
		return ($this->formulari_ok);
	}

	public function validar_entrada()
	{
		if (($this->tipo != '700') && ($this->tipo != '100')) {
			$this->formulari_ok = FALSE;
			$this->error = $this->error . 'Tipo de banner no válido ';
		}
		if ((!isset($this->img)) || ($this->img == '')) {
			$this->formulari_ok = FALSE;
			$this->error = $this->error . 'Falta la imagen ';
		}
		if ($this->link == '') {
			$this->formulari_ok = FALSE;
			$this->error = $this->error . 'Falta el link ';
		}
		if ($this->texte == '') {
			$this->formulari_ok = FALSE;
			$this->error = $this->error . 'Falta el texto ';
		}
		return ($this->formulari_ok);
	}

	public function introduir($bs, $logica_id, $id)
	{
		$this->link = addslashes($this->link);
		$this->texte = addslashes($this->texte);
		$this->img = addslashes($this->img);

		if ($logica_id) {
			$query = "update banners set tipo='" . $this->tipo . "', img='" . $this->img . "', link='" . $this->link . "', texte='" . $this->texte . "', datafi='" . $this->datafi . "' where id='" . $id . "'";
		} else {
			$query = "insert into banners (tipo, img, link, texte, datafi, contador) values ('" . $this->tipo . "', '" . $this->img . "', '" . $this->link . "', '" . $this->texte . "', '" . $this->datafi . "', 0)";
		}
		$this->resultat_consulta = $bs->query($query);
		if ($this->resultat_consulta) {
			print '<p class="terminal">¡¡Banner guardado correctamente!!</p>';
		} else {
			print '<p class="terminal">Error, el banner no ha podido ser guardado: ' . $bs->error . '</p>';
		}
	}

	public function inicialitzar_banner() /* Inicialitza l'objecte */
	{
		$this->tipo = '700';
		$this->img = '';
		$this->link = '';
		$this->texte = '';
		$this->datafi = '';
		$this->dia = '--';
		$this->mes = '--';
		$this->any = '--';
	}

	public function formulari()
	{
		print "<form id=\"form_banner\" action=\"" . $_SERVER['REQUEST_URI'] . "\" method=\"post\" enctype=\"multipart/form-data\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
		print "<input type=\"hidden\" name=\"confirm_small_img\" id=\"confirm_small_img\" value=\"no\" \>\n";
		print '<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />';

		print "<p class=\"form_data\">";
		print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';

		print '<p class="contingut">Tipo de banner
			<select name="tipo">';
		switch ($this->tipo) {
			case '100':
				print '<option value="700">Tipo 700 (700x100 px)</option>
					<option value="100" selected="selected">Tipo 100 (ancho libre x 100 px alto)</option>';
				break;
			default:
				print '<option value="700" selected="selected">Tipo 700 (700x100 px)</option>
					<option value="100">Tipo 100 (ancho libre x 100 px alto)</option>';
				break;
		}
		print '</select></p>';

		print '<p class="contingut">Imagen<br /><br />';
		if (($this->img != '') && (isset($this->img))) {
			print '<img src="../pics/banner/' . $this->img . '" style="max-width:700px;" /><br />';
			print "<input type=\"hidden\" name=\"img_off\" value=\"$this->img\" \>\n";
		}
		print '<input type="file" name="fitxer_img" id="fitxer_img"/><br />';
		print '<span class="contingut">El tipo 700 debe medir exactamente 700x100px. El tipo 100 puede tener cualquier ancho, pero debe medir 100px de alto.</span>';
		print '</p>';

		print '<p class="contingut">Link<br /><br /><input class="titol_form" type="text" name="link" maxlength="256" value="' . $this->link . '" /></p>';

		print '<p class="contingut">Texto<br /><br /><input class="titol_form" type="text" name="texte" maxlength="256" value="' . $this->texte . '" /></p>';

		print '<p class="contingut">Fecha fin (a partir de esta fecha el banner deja de mostrarse)<br /><br />';

		print 'Día <select name="dia">';
		for ($y = 1; $y <= 31; $y++) {
			if ($this->dia == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Mes <select name="mes">';
		for ($y = 1; $y <= 12; $y++) {
			if ($this->mes == $y) {
				print '<option selected="selected" value="' . $y . '">' . $y . '</option>';
			} else {
				print '<option value="' . $y . '">' . $y . '</option>';
			}
		}
		print '</select>';

		print 'Año <select name="any">';
		$any_actual = date('Y');
		for ($y = $any_actual; $y <= ($any_actual + 5); $y++) {
			if ($this->any == $y) {
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
		print "\" /></fieldset>";

		print "</form>\n";
	}

	public function consulta_banners($basedades, $desde, $quantitat)
	/* consulta banners a la bbdd a partir de la conexió, el numero d'inici de la consulta i la quantitat a mostrar */
	{
		$inici = $desde - 1;
		$query = "select id from banners order by datafi desc limit " . $inici . ", " . $quantitat . " ";
		$this->resultat_consulta = $basedades->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer los banners a mostrar.</p>';
		} else {
			$this->numero_resultats = $this->resultat_consulta->num_rows;
			if ($this->numero_resultats == 0) {
				print '<p class="terminal">No hay resultados que mostrar</p>';
			}
		}
	}

	public function extreu_dades_banner_per_id($bd, $id)
	/* Extreu dades d'un unic banner */
	{
		$query = "select * from banners where id = " . $id;
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta == FALSE) {
			print '<p class="terminal">Error al extraer el banner</p>';
		} else {
			$resultat = $this->resultat_consulta->fetch_assoc();
			$this->id = $resultat['id'];
			$this->tipo = $resultat['tipo'];
			$this->img = $resultat['img'];
			$this->link = $resultat['link'];
			$this->texte = $resultat['texte'];
			$this->datafi = $resultat['datafi'];
			$this->any = substr($this->datafi, 0, 4);
			$this->mes = substr($this->datafi, 4, 2);
			$this->dia = substr($this->datafi, 6, 2);
		}
	}

	public function presentar_banners_formulari($bd, $tasca)
	/* tenint l'objecte de la consulta les posa a pantalla */
	{
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$row = $this->resultat_consulta->fetch_assoc();
			$this->id = $row['id'];
			$query = "select * from banners where id=" . $this->id;
			$this->resultat_consulta2 = $bd->query($query);
			if (!$this->resultat_consulta2 == FALSE) {
				if (($this->resultat_consulta2->num_rows) == 1) {
					$r = $this->resultat_consulta2->fetch_assoc();
					$this->tipo = $r['tipo'];
					$this->img = $r['img'];
					$this->link = $r['link'];
					$this->texte = $r['texte'];
					$this->datafi = $r['datafi'];
					$any = substr($this->datafi, 0, 4);
					$mes = substr($this->datafi, 4, 2);
					$dia = substr($this->datafi, 6, 2);
					$estat = ($this->datafi > date('Ymd')) ? 'Activo' : 'Caducado';

					print '<div class="noticia_curta">';
					switch ($tasca) {
						case ('editar'):
							print "<form action=\"home_cp.php?sec=banners&action=edit&tasca=edit&id=$this->id&formulari=TRUE\" method=\"post\">";
							print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
							print '<fieldset><legend class="white">Tipo: ' . $this->tipo . ' - Caduca: ' . $dia . '/' . $mes . '/' . $any . ' (' . $estat . ')</legend>';
							print "<input class=\"esq\" type=\"submit";
							print "\" value=\"";
							print 'Editar';
							print "\" />";
							print '<br /><img src="../pics/banner/' . $this->img . '" style="max-width:350px;" /><br />';
							print "<p class=\"titol\">Texto: $this->texte</p><br />";
							print "<p class=\"titol\">Link: $this->link</p>";
							print "</fieldset>";
							print "</form></div>";
							break;
					}
				}
			}
		}
	}

	public function navegador_entrades($numero, $punter, $quantitat, $action)
	/* controla fletxes de navegacio per presentar banners */
	{
		?>
		<div class="navegador">

			<?php
			if ($punter != 1) {
				?>
				<a class="linkk" href="home_cp.php?sec=banners&action=edit&punter=1">
					<img class="ico_navegador" src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
				<?php
			}
			if ($punter != 1) {
				$punter_dir = $punter - 10;
				print '<a class="linkk" href="home_cp.php?sec=banners&action=' . $action . '&punter=' . $punter_dir . '">
						<img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = $punter + 10;
				print '<a class="linkk" href="home_cp.php?sec=banners&action=' . $action . '&punter=' . $punter_dir . '">
						<img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
			}
			if ($numero >= ($punter + 10)) {
				$punter_dir = ((number_format(($numero / $quantitat), 0) * $quantitat) + 1) - 10;
				print '<a class="linkk" href="home_cp.php?sec=banners&action=' . $action . '&punter=' . $punter_dir . '">
						<img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
			}
			?>
		</div>
		<?php
	}
}
?>
