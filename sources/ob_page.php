<?php
class ob_page
{
	public $leng; /* idioma ES o EN */
	public $first_top; /* codi de capçalera */
	public $css; /* array de css */
	public $scripts; /* array de scripts */
	public $section; /* seccio on estem */
	public $title; /* titol de la pagina */
	public $description; /* descripció de la plana */
	public $words; /* paraules claus */
	public $punter; /* variables de control de noticies al index */
	public $quantitat_noticies;
	public $quantitat_concerts_entrada;
	public $quantitat_concerts_data;
	public $id;
	public $image_main;

	/* noticies */
	public $noticia; /* parametre de noticia */
	public $noticia_traduida; /* Titol de la noticia traduida */
	public $traduccio; /* control si s'ha de traduir el contingut o no*/
	public $noticia_titol;
	public $noticia_descripcio;
	/* concerts */
	public $concert_tipus; /* Controla si es mostra la plana normal, entrades, entrada o agenda */
	public $concerts_titol; /* titol per la pagina */
	/* reviews */
	public $review_tipus; /* Controla si es mostra la plana normal, entrades, entrada o agenda */
	public $review_titol; /* titol per la pagina */
	public $review_descripcio; /* descripció per la pagina */
	public $quantitat_reviews;

	/* croniques */
	public $cronica_tipus; /* Controla si es mostra la plana d'entrades o entrada*/
	public $cronica_titol; /* titol per la pagina */
	public $cronica_descripcio; /* descripció per la pagina */
	public $cronica_entrevistes;
	public $cronica_traducida;
	public $quantitat_croniques;

	/* entrevistes */
	public $entrevista_tipus; /* Controla si es mostra la plana entrades o entrada */
	public $entrevista_titol; /* titol per la pagina */
	public $entrevista_descripcio; /* descripció per la pagina */
	public $quantitat_entrevistes;
	public $entrevista_traducida;

	/* opinio */
	public $opinio_tipus; /* Controla si es mostra la plana entrades o entrada */
	public $opinio_titol; /* titol per la pagina */
	public $opinio_descripcio; /* descripció per la pagina */
	public $quantitat_opinio;
	public $opinio_traducida;
	/* carta */
	public $carta_tipus; /* Controla si es mostra la plana entrades o entrada */
	public $carta_titol; /* titol per la pagina */
	public $carta_descripcio; /* descripció per la pagina */
	public $quantitat_carta;
	public $carta_traducida;
	/* preferits */
	public $preferits_tipus; /* Controla si es mostra la plana normal, entrades, entrada o agenda */
	public $preferits_titol; /* titol per la pagina */
	public $preferits_descripcio; /* descripció per la pagina */
	public $preferits_reviews;
	/* Concursos */
	public $concurs;

	/* Pagines extra */
	public $pagina;

	public function __set($name, $value)
	{
		$this->$name = $value;
	}

	public function __get($name)
	{
		return $this->$name;
	}

	public function print_metas()
	{
		print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' .
			"\n" .
			'<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />' .
			"\n" .
			'<meta name="google-site-verification" content="3cpdckPZBddxzniOJ2ryh-yFVqQwxRmw4kuu2TuCaLc" />' .
			"\n" .
			'<meta property="og:type" content="Metal webzine" />' .
			"\n" .
			'<meta property="og:url" content="http://' .
			$_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI'] .
			'" />';
		'<meta property="og:site_name" content="Satan Arise"/>' .
			'<meta property="fb:admins" content="1577671298,1527691405" />
			<meta property="og:description" content="' .
			$this->description .
			'"
			<meta name="keywords" content="Metal, reviews, críticas, entrevistas, noticias, power, viking, death, heavy, trash, black, gothic, gotico, progresive, progresivo" />
			<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />' .
			"\n";
	}

	public function __construct()
	{
		/* inicialitza l'objecte */
		$this->css = [
			'<link type="text/css" rel="stylesheet" media="all" href="css/main.css" />',
			'<link type="text/css" rel="stylesheet" media="all" href="css/index.css" />',
			'<link type="text/css" rel="stylesheet" media="all" href="css/iframe.css" />',
			'<link type="text/css" rel="stylesheet" media="all" href="css/responsive.css" />',
		];
		$this->words =
			'Metal, reviews, críticas, entrevistas, noticias, power, viking, death, heavy, trash, black, gothic, gotico, progresive, progresivo';
		$this->scripts = [
			'<script type="text/javascript" src="css/responsive-menu.js"></script>'
		];
		$this->punter = 1;
		$this->quantitat = 36;
		$this->quantitat_concerts_entrada = 20;
		$this->quantitat_concerts_data = 25;
		$this->quantitat_reviews = 20;
		$this->quantitat_croniques = 10;
		$this->quantitat_entrevistes = 10;
		$this->quantitat_opinio = 10;
		$this->quantitat_carta = 10;
		$this->quantitat_preferits = 10;
		$this->noticia = '';
		$this->id = '';
		$this->traduccio = true;
		$this->noticia_traduida = '';
		$this->entrevista_traducida = '';
		$this->opinio_traducida = '';
		$this->carta_traducida = '';
		$this->preferits_traducida = '';
		$this->cronica_traducida = '';
		$this->concerts_titol = '';
		$this->image_main = 'pics/sa_negre.jpg';
	}

	public function print_heads()
	{
		$this->first_top =
			"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//ES\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n";
		print $this->first_top;
		print '<meta name="description" content="' .
			$this->description .
			'"  />';
		$this->print_metas();
		$this->print_css();
		$this->print_scripts();
		print '<title>' . $this->title . '</title>' . "\n";
		print '<meta property="og:title" content="' . $this->title . '"/>';
		print '<meta property="og:image" content="http://www.satanarise.com/' .
			$this->image_main .
			'" />';
	}

	public function print_scripts()
	{
		/* Imprimeix tots els scripts de $scripts */
		if (isset($this->scripts)) {
			if (isset($this->scripts)) {
				$x = count($this->scripts) - 1;

				while ($x >= 0) {
					print $this->scripts[$x] . "\n";
					$x = $x - 1;
				}
			}
		}
	}

	public function add_scripts($scripts)
	{
		$this->scripts[] = $scripts;
	}

	public function add_css($css)
	{
		$this->css[] = $css;
	}

	public function print_css()
	{
		/* Imprimeix tots els css de $css */
		$x = count($this->css) - 1;

		while ($x >= 0) {
			print $this->css[$x] . "\n";
			$x = $x - 1;
		}
	}

	public function get_param($param, $bd)
	{
		if (isset($param['ln'])) {
			/* pilla idioma, sino esta declarat angles */
			if ($param['ln'] == 'ES' || $param['ln'] == 'CAT') {
				$this->leng = $param['ln'];
			}
		} else {
			$this->leng = 'ES';
		}
		/* control de seccio, si la seccio del parametre no existeix en funcio de l'idioma sera news o noticias */
		if (isset($param['sec'])) {
			$this->section = $param['sec'];
		} else {
			if ($this->leng == 'CAT') {
				$this->section = 'inici';
			} else {
				$this->section = 'inicio';
			}
		}
		if (
			$this->leng == 'CAT' &&
			($this->section != 'inici' &&
				$this->section != 'critiques' &&
				$this->section != 'noticies' &&
				$this->section != 'concerts' &&
				$this->section != 'croniques' &&
				$this->section != 'entrevistes' &&
				$this->section != 'entrevistesn' &&
				$this->section != 'opinio' &&
				$this->section != 'contacte' &&
				$this->section != 'pagina' &&
				$this->section != 'concurs' &&
				$this->section != 'carteslector' &&
				$this->section != 'preferits' &&
				$this->section != 'link')
		) {
			$this->section = 'inici';
		}
		if (
			$this->leng == 'ES' &&
			($this->section != 'inicio' &&
				$this->section != 'criticas' &&
				$this->section != 'noticias' &&
				$this->section != 'conciertos' &&
				$this->section != 'cronicas' &&
				$this->section != 'entrevistas' &&
				$this->section != 'entrevistasn' &&
				$this->section != 'opinion' &&
				$this->section != 'contacto' &&
				$this->section != 'pagina' &&
				$this->section != 'concurso' &&
				$this->section != 'cartaslector' &&
				$this->section != 'preferidos' &&
				$this->section != 'link')
		) {
			$this->section = 'inicio';
		}
		if (isset($param['pnt'])) {
			$this->punter = $param['pnt'];
			if (!is_numeric($this->punter)) {
				$this->punter = 1;
			}
		}

		if ($this->section == 'noticias' || $this->section == 'noticies') {
			/* parametres de la seccio noticies */
			if (isset($param['noticia'])) {
				$this->noticia = urldecode($param['noticia']);
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
			}
			if ($this->id != '' && $this->noticia != '') {
				/* veure si hi ha traducció */
				switch ($this->leng) {
					case 'ES':
						$idioma = 'CAT';
						break;
					case 'CAT':
						$idioma = 'ES';
						break;
				}
				$bd->conectar();
				$query =
					'select Title from newscontent where idNews = ' .
					$this->id .
					" and Idioma='" .
					$idioma .
					"'";
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					if ($resultat->num_rows == 1) {
						$row = $resultat->fetch_assoc();
						$this->noticia_traduida = $row['Title'];
					} else {
						$this->traduccio = false;
					}
				} else {
					$this->traduccio = false;
				}
				/* preparar metas noticies */
				$query =
					'select Title, Body from newscontent where idNews = ' .
					$this->id .
					" and Idioma='" .
					$this->leng .
					"'";
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					if ($resultat->num_rows == 1) {
						$row = $resultat->fetch_assoc();
						$this->noticia_titol = $row['Title'];
						$this->noticia_descripcio = substr(
							$row['Body'],
							0,
							200
						);
					}
				}
				$query =
					'select ruta from newsdata where idNews = ' .
					$this->id .
					' and orden=1 and tipo=1';
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					if ($resultat->num_rows == 1) {
						$row = $resultat->fetch_assoc();
						$this->image_main = $row['ruta'];
					}
				}
				$bd->desconectar();
			}
		}
		if ($this->section == 'concurs' || $this->section == 'concurso') {
			if (isset($param['tit'])) {
				$this->concurs = $param['tit'];
			}
		}
		if ($this->section == 'pagina') {
			if (isset($param['tit'])) {
				$this->pagina = $param['tit'];
			}
		}
		if ($this->section == 'conciertos' || $this->section == 'concerts') {
			/* parametres de la secció concerts */
			if (isset($param['type'])) {
				$this->concert_tipus = $param['type'];
			} else {
				$this->concert_tipus = 'normal';
			}
			if (
				$this->concert_tipus != 'normal' &&
				$this->concert_tipus != 'entrada' &&
				$this->concert_tipus != 'entradas' &&
				$this->concert_tipus != 'agenda'
			) {
				$this->concert_tipus = 'normal';
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
				$bd->conectar();
				$query =
					'select concerts.tipus, concerts.cartell, concerts.Nom, concertsgrups.Grup from concerts, concertsgrups where concerts.idGig = ' .
					$this->id .
					' and concertsgrups.idGig = ' .
					$this->id .
					' order by ordre';
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					$num_resultats = $resultat->num_rows;
					$row = $resultat->fetch_assoc();
					$this->image_main = 'pics/conc/' . $row['cartell'];
					switch ($row['tipus']) {
						case 1:
							if ($row['Nom'] == '') {
								$this->concerts_titol = $row['Grup'];
								for ($i = 1; $i < $num_resultats; $i++) {
									$row = $resultat->fetch_assoc();
									$this->concerts_titol =
										$this->concerts_titol .
										' + ' .
										$row['Grup'];
								}
							} else {
								$this->concerts_titol = $row['Nom'];
							}
							break;
						case 2:
							$this->concerts_titol = $row['Nom'];
							break;
						case 3:
							$this->concerts_titol = $row['Nom'];
							break;
					}
				}
				$bd->desconectar();
			}
		}
		if ($this->section == 'criticas' || $this->section == 'critiques') {
			/* parametres de la secció concerts */
			if (isset($param['type'])) {
				$this->reviews_tipus = $param['type'];
			} else {
				$this->reviews_tipus = 'main';
			}
			if (
				$this->reviews_tipus != 'main' &&
				$this->reviews_tipus != 'entrada' &&
				$this->reviews_tipus != 'all'
			) {
				$this->reviews_tipus = 'main';
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
				$bd->conectar();
				if ($this->leng == 'ES') {
					$query =
						'select banda, disc, any, texte_es, portada from reviews where idreviews = ' .
						$this->id;
				} else {
					$query =
						'select banda, disc, any, texte_cat, portada from reviews where idreviews = ' .
						$this->id;
				}
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					$num_resultats = $resultat->num_rows;
					$row = $resultat->fetch_assoc();
					$this->review_titol =
						'Crítica de ' .
						$row['disc'] .
						' de ' .
						$row['banda'] .
						' (' .
						$row['any'] .
						')';
					if ($this->leng == 'ES') {
						$this->review_descripcio = substr(
							$row['texte_es'],
							0,
							200
						);
					} else {
						$this->review_descripcio = substr(
							$row['texte_cat'],
							0,
							200
						);
					}
					$this->image_main = 'pics/covers/' . $row['portada'];
				}
				$bd->desconectar();
			} else {
				if ($this->leng == 'ES') {
					$this->review_descripcio = 'Últimas críticas / reviews';
					$this->review_titol = 'Novedades';
				} else {
					$this->review_descripcio = 'Darreres crítiques / reviews';
					$this->review_titol = 'Novetats';
				}
			}
		}
		if ($this->section == 'preferidos' || $this->section == 'preferits') {
			/* parametres de la secció concerts */
			if ($this->leng == 'ES') {
				$this->review_descripcio =
					'Els musics diuen quins discos son els seus preferits';
				$this->review_titol = 'Preferits';
			} else {
				$this->review_descripcio =
					'Los músicos opinan sobre sus discos favoritos';
				$this->review_titol = 'Preferidos';
			}
		}

		if (
			$this->section == 'entrevistas' ||
			$this->section == 'entrevistes'
		) {
			/* parametres de la secció concerts */
			if (isset($param['type'])) {
				$this->entrevista_tipus = $param['type'];
			} else {
				$this->entrevista_tipus = 'main';
			}
			if (
				$this->entrevista_tipus != 'main' &&
				$this->entrevista_tipus != 'entrada'
			) {
				$this->entrevista_tipus = 'main';
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
				$bd->conectar();
				if ($this->leng == 'ES') {
					$query =
						'select idioma, banda, titol_es from entrevistes where identrevistes = ' .
						$this->id;
				} else {
					$query =
						'select idioma, banda, titol_cat from entrevistes where identrevistes = ' .
						$this->id;
				}
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					$num_resultats = $resultat->num_rows;
					$row = $resultat->fetch_assoc();
					$idioma_ent = $row['idioma'];
					if ($this->leng == 'ES') {
						$this->entrevista_titol =
							'Entrevista con ' . $row['banda'];
						$this->entrevista_descripcio = substr(
							$row['titol_es'],
							0,
							200
						);
					} else {
						$this->entrevista_titol =
							'Entrevista amb ' . $row['banda'];
						$this->entrevista_descripcio = substr(
							$row['titol_cat'],
							0,
							200
						);
					}
					$query =
						'select ruta from entrevistesdata where identrevistes=' .
						$this->id .
						' and tipus=1 and ordre=1';
					$resultat = $bd->bd->query($query);
					if ($resultat != false) {
						$row = $resultat->fetch_assoc();
						$this->image_main =
							'pics/entrevistes_pics/' . $row['ruta'];
					}
					if ($idioma_ent != 'BOTH') {
						$this->traduccio = false;
					}
				}
				$bd->desconectar();
			} else {
				if ($this->leng == 'ES') {
					$this->entrevista_descripcio = 'Últimas entrevistas';
					$this->entrevista_titol = 'Entrevistas';
				} else {
					$this->entrevista_descripcio = 'Darreres entrevistes';
					$this->entrevista_titol = 'Entrevistes';
				}
			}
		}
		if (
			$this->section == 'entrevistasn' ||
			$this->section == 'entrevistesn'
		) {
			/* parametres de la secció concerts */
			if (isset($param['type'])) {
				$this->entrevista_tipus = $param['type'];
			} else {
				$this->entrevista_tipus = 'main';
			}
			if (
				$this->entrevista_tipus != 'main' &&
				$this->entrevista_tipus != 'entrada'
			) {
				$this->entrevista_tipus = 'main';
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
				$bd->conectar();
				if ($this->leng == 'ES') {
					$query =
						'select idioma, banda, titol_es from entrevnews where identrevistes = ' .
						$this->id;
				} else {
					$query =
						'select idioma, banda, titol_cat from entrevinews where identrevistes = ' .
						$this->id;
				}
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					$num_resultats = $resultat->num_rows;
					$row = $resultat->fetch_assoc();
					$idioma_ent = $row['idioma'];
					if ($this->leng == 'ES') {
						$this->entrevista_titol =
							'Entrevista con ' . $row['banda'];
						$this->entrevista_descripcio = substr(
							$row['titol_es'],
							0,
							200
						);
					} else {
						$this->entrevista_titol =
							'Entrevista amb ' . $row['banda'];
						$this->entrevista_descripcio = substr(
							$row['titol_cat'],
							0,
							200
						);
					}
					$query =
						'select ruta from entrevnewsdata where identrevistes=' .
						$this->id .
						' and tipus=1 and ordre=1';
					$resultat = $bd->bd->query($query);
					if ($resultat != false) {
						$row = $resultat->fetch_assoc();
						$this->image_main =
							'pics/entrevistes_news_pics/' . $row['ruta'];
					}
					if ($idioma_ent != 'BOTH') {
						$this->traduccio = false;
					}
				}
				$bd->desconectar();
			} else {
				if ($this->leng == 'ES') {
					$this->entrevista_descripcio = 'Últimas entrevistas';
					$this->entrevista_titol = 'Entrevistas';
				} else {
					$this->entrevista_descripcio = 'Darreres entrevistes';
					$this->entrevista_titol = 'Entrevistes';
				}
			}
		}

		if ($this->section == 'opinion' || $this->section == 'opinio') {
			/* parametres de la secció concerts */
			if (isset($param['type'])) {
				$this->opinio_tipus = $param['type'];
			} else {
				$this->opinio_tipus = 'main';
			}
			if (
				$this->opinio_tipus != 'main' &&
				$this->opinio_tipus != 'entrada'
			) {
				$this->opinio_tipus = 'main';
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
				$bd->conectar();
				if ($this->leng == 'ES') {
					$query =
						'select idioma, titol_es, texte_es, ruta from opinio where idopinio = ' .
						$this->id;
				} else {
					$query =
						'select idioma, titol_cat, texte_cat, ruta from opinio where idopinio = ' .
						$this->id;
				}
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					$num_resultats = $resultat->num_rows;
					$row = $resultat->fetch_assoc();
					$idioma_ent = $row['idioma'];
					$img = $row['ruta'];
					if ($img != '') {
						$this->image_main = 'pics/opinio_pics/' . $row['ruta'];
					}
					if ($this->leng == 'ES') {
						$this->opinio_titol = $row['titol_es'];
						$this->opinio_descripcio = substr(
							$row['texte_es'],
							0,
							200
						);
					} else {
						$this->opinio_titol = $row['titol_cat'];
						$this->opinio_descripcio = substr(
							$row['texte_cat'],
							0,
							200
						);
					}
					if ($idioma_ent != 'BOTH') {
						$this->traduccio = false;
					}
				}
				$bd->desconectar();
			} else {
				if ($this->leng == 'ES') {
					$this->opinio_descripcio = 'Últimos reports';
					$this->opinio_titol = 'Metal Report';
				} else {
					$this->opinio_descripcio = 'Darrers reports';
					$this->opinio_titol = "Metal Report";
				}
			}
		}
		if (
			$this->section == 'carteslector' ||
			$this->section == 'cartaslector'
		) {
			/* parametres de la secció concerts */
			if (isset($param['type'])) {
				$this->carta_tipus = $param['type'];
			} else {
				$this->carta_tipus = 'main';
			}
			if (
				$this->carta_tipus != 'main' &&
				$this->carta_tipus != 'entrada'
			) {
				$this->carta_tipus = 'main';
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
				$bd->conectar();
				if ($this->leng == 'ES') {
					$query =
						'select idioma, titol_es, texte_es from carta where idcarta = ' .
						$this->id;
				} else {
					$query =
						'select idioma, titol_cat, texte_cat from carta where idcarta = ' .
						$this->id;
				}

				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					$num_resultats = $resultat->num_rows;
					$row = $resultat->fetch_assoc();
					$idioma_ent = $row['idioma'];
					if ($this->leng == 'ES') {
						$this->carta_titol = $row['titol_es'];
						$this->carta_descripcio = substr(
							$row['texte_es'],
							0,
							200
						);
					} else {
						$this->carta_titol = $row['titol_cat'];
						$this->carta_descripcio = substr(
							$row['texte_cat'],
							0,
							200
						);
					}
					if ($idioma_ent != 'BOTH') {
						$this->traduccio = false;
					}
				}
				$bd->desconectar();
			} else {
				if ($this->leng == 'ES') {
					$this->carta_descripcio = 'Últimas cartas del lector';
					$this->carta_titol = 'Cartas Del Lector';
				} else {
					$this->carta_descripcio = 'Darreres cartes del lector';
					$this->carta_titol = 'Cartes Del Lector';
				}
			}
		}

		if ($this->section == 'cronicas' || $this->section == 'croniques') {
			/* parametres de la secció concerts */
			if (isset($param['type'])) {
				$this->cronica_tipus = $param['type'];
			} else {
				$this->cronica_tipus = 'main';
			}
			if (
				$this->cronica_tipus != 'main' &&
				$this->cronica_tipus != 'entrada'
			) {
				$this->cronica_tipus = 'main';
			}
			if (isset($param['id'])) {
				$this->id = $param['id'];
				$bd->conectar();
				if ($this->leng == 'ES') {
					$query =
						'select idioma, titol, cartell, intro_es from cronicas where idcronicas = ' .
						$this->id;
				} else {
					$query =
						'select idioma, titol, cartell, intro_cat from cronicas where idcronicas = ' .
						$this->id;
				}
				$resultat = $bd->bd->query($query);
				if ($resultat != false) {
					$num_resultats = $resultat->num_rows;
					$row = $resultat->fetch_assoc();
					$idioma_ent = $row['idioma'];
					if ($this->leng == 'ES') {
						$this->cronica_titol = 'Crónica de ' . $row['titol'];
						$this->cronica_descripcio = substr(
							$row['intro_es'],
							0,
							200
						);
					} else {
						$this->cronica_titol = 'Crónica de ' . $row['titol'];
						$this->cronica_descripcio = substr(
							$row['intro_cat'],
							0,
							200
						);
					}
					$this->image_main = 'pics/cronicas_pics/' . $row['cartell'];
				}
				if ($idioma_ent != 'BOTH') {
					$this->traduccio = false;
				}

				$bd->desconectar();
			} else {
				if ($this->leng == 'ES') {
					$this->cronica_descripcio = 'Últimas crónicas';
					$this->cronica_titol = 'Crónicas';
				} else {
					$this->cronica_descripcio = 'Darreres cróniques';
					$this->cronica_titol = 'Cróniques';
				}
			}
		}
		if ($this->section == 'link') {
			if (isset($param['id'])) {
				$id = $param['id'];
			}
			$query = "select contador, link from banners where id = $id";
			$bd->conectar();
			$resultat = $bd->bd->query($query);
			if ($resultat != false) {
				$num_resultats = $resultat->num_rows;
				$row = $resultat->fetch_assoc();
				$visita = $row['contador'];
				$visita++;
				$link = $row['link'];
				$query = "update banners set contador=$visita where id=$id";
				$resultat = $bd->bd->query($query);
				header("Location: $link");
			}
			$bd->desconectar();
		}
	}

	public function translate_url($url)
	{
		if (strstr($url, 'ES') == false && strstr($url, 'CAT') == false) {
			$url = 'index.php?ln=ES&sec=inicio';
		} else {
			if ($this->leng == 'ES') {
				$url = str_replace('ES', 'CAT', $url);
				$url = str_replace('inicio', 'inici', $url);
				$url = str_replace('noticias', 'noticies', $url);
				$url = str_replace('criticas', 'critiques', $url);
				$url = str_replace('conciertos', 'concerts', $url);
				$url = str_replace('cronicas', 'croniques', $url);
				$url = str_replace('entrevistas', 'entrevistes', $url);
				$url = str_replace('contacto', 'contacte', $url);
				$url = str_replace('concurso', 'concurs', $url);
				$url = str_replace('opinion', 'opinio', $url);
				$url = str_replace('cartaslector', 'carteslector', $url);
				$url = str_replace('preferidos', 'preferits', $url);
			} else {
				$url = str_replace('CAT', 'ES', $url);
				$url = str_replace('inici', 'inicio', $url);
				$url = str_replace('noticies', 'noticias', $url);
				$url = str_replace('critiques', 'criticas', $url);
				$url = str_replace('concerts', 'conciertos', $url);
				$url = str_replace('croniques', 'cronicas', $url);
				$url = str_replace('entrevistes', 'entrevistas', $url);
				$url = str_replace('contacte', 'contacto', $url);
				$url = str_replace('concurs', 'concurso', $url);
				$url = str_replace('opinio', 'opionion', $url);
				$url = str_replace('carteslector', 'cartaslector', $url);
				$url = str_replace('preferits', 'preferidos', $url);
			}
			if (
				($this->section == 'noticias' ||
					$this->section == 'noticies') &&
				$this->noticia_traduida != ''
			) {
				$this->noticia_traduida = urlencode($this->noticia_traduida);
				$url = str_replace(
					urlencode($this->noticia),
					$this->noticia_traduida,
					$url
				);
			}
		}
		return $url;
	}

	public function navegador($numero, $quantitat)
	{
		print '<div class="navegador">';
		if ($this->punter != 1) {
			print '<a class="linkk" href="index.php?ln=' .
				$this->leng .
				'&sec=' .
				$this->section;
			if (
				$this->section == 'concerts' ||
				$this->section == 'conciertos'
			) {
				print '&type=' . $this->concert_tipus;
			}
			if ($this->section == 'crticas' || $this->section == 'critiques') {
				print '&type=' . $this->review_tipus;
			}
			if (
				$this->section == 'entrevistas' ||
				$this->section == 'entrevistes'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if (
				$this->section == 'entrevistas' ||
				$this->section == 'entrevistesn'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if ($this->section == 'cronicas' || $this->section == 'croniques') {
				print '&type=' . $this->cronica_tipus;
			}
			if ($this->section == 'opinion' || $this->section == 'opinio') {
				print '&type=' . $this->opinio_tipus;
			}
			if (
				$this->section == 'carteslector' ||
				$this->section == 'cartaslector'
			) {
				print '&type=' . $this->carta_tipus;
			}
			if (
				$this->section == 'preferits' ||
				$this->section == 'preferidos'
			) {
				print '&type=' . $this->preferidos_tipus;
			}
			print '&pnt=1"><img class="iconavegador" src="pics/containers/max_prev_w.jpg" width="45" height="23" /></a>';
		}
		if ($this->punter != 1 && $numero > $quantitat) {
			$punter_dir = $this->punter - $quantitat;
			print '<a class="linkk" href="index.php?ln=' .
				$this->leng .
				'&sec=' .
				$this->section;
			if (
				$this->section == 'concerts' ||
				$this->section == 'conciertos'
			) {
				print '&type=' . $this->concert_tipus;
			}
			if ($this->section == 'crticas' || $this->section == 'critiques') {
				print '&type=' . $this->review_tipus;
			}
			if (
				$this->section == 'entrevistas' ||
				$this->section == 'entrevistes'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if (
				$this->section == 'entrevistasn' ||
				$this->section == 'entrevistesn'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if ($this->section == 'cronicas' || $this->section == 'croniques') {
				print '&type=' . $this->cronica_tipus;
			}
			if ($this->section == 'opinion' || $this->section == 'opinio') {
				print '&type=' . $this->opinion_tipus;
			}
			if (
				$this->section == 'cartaslector' ||
				$this->section == 'carteslector'
			) {
				print '&type=' . $this->carta_tipus;
			}
			if (
				$this->section == 'preferidos' ||
				$this->section == 'preferits'
			) {
				print '&type=' . $this->preferits_tipus;
			}
			print '&pnt=' .
				$punter_dir .
				'"><img class="iconavegador" src="pics/containers/prev_w.jpg" width="30" height="23" /></a>';
		}

		if ($numero >= $this->punter + $quantitat) {
			$punter_dir = $this->punter + $quantitat;
			print '<a class="linkk" href="index.php?ln=' .
				$this->leng .
				'&sec=' .
				$this->section;
			if (
				$this->section == 'concerts' ||
				$this->section == 'conciertos'
			) {
				print '&type=' . $this->concert_tipus;
			}
			if ($this->section == 'crticas' || $this->section == 'critiques') {
				print '&type=' . $this->review_tipus;
			}
			if (
				$this->section == 'entrevistas' ||
				$this->section == 'entrevistes'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if (
				$this->section == 'entrevistasn' ||
				$this->section == 'entrevistesn'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if ($this->section == 'cronicas' || $this->section == 'croniques') {
				print '&type=' . $this->cronica_tipus;
			}
			if ($this->section == 'opinion' || $this->section == 'opinio') {
				print '&type=' . $this->opinion_tipus;
			}
			if (
				$this->section == 'carteslector' ||
				$this->section == 'cartaslector'
			) {
				print '&type=' . $this->carta_tipus;
			}

			print '&pnt=' .
				$punter_dir .
				'"><img class="iconavegador" src="pics/containers/next_w.jpg" width="30" height="23" /></a>';
		}

		if ($numero >= $this->punter + $quantitat) {
			$punter_dir =
				number_format($numero / $quantitat, 0) * $quantitat +
				1 -
				$quantitat;
			print '<a class="linkk" href="index.php?ln=' .
				$this->leng .
				'&sec=' .
				$this->section;
			if (
				$this->section == 'concerts' ||
				$this->section == 'conciertos'
			) {
				print '&type=' . $this->concert_tipus;
			}
			if ($this->section == 'crticas' || $this->section == 'critiques') {
				print '&type=' . $this->review_tipus;
			}
			if (
				$this->section == 'entrevistas' ||
				$this->section == 'entrevistes'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if (
				$this->section == 'entrevistasn' ||
				$this->section == 'entrevistesn'
			) {
				print '&type=' . $this->entrevista_tipus;
			}
			if ($this->section == 'croniques' || $this->section == 'cronicas') {
				print '&type=' . $this->cronica_tipus;
			}
			if ($this->section == 'opinion' || $this->section == 'opinio') {
				print '&type=' . $this->opinion_tipus;
			}
			if (
				$this->section == 'carteslector' ||
				$this->section == 'cartaslector'
			) {
				print '&type=' . $this->carta_tipus;
			}

			print '&pnt=' .
				$punter_dir .
				'"><img class="iconavegador" src="pics/containers/max_next_w.jpg" width="45" height="23" /></a>';
		}
		print '</div>';
	}
}

class banner_700
{
	public $banners; /*Array de banners ruta, enllaç, tit, target */
	public $total_banners; /*numero de banners */
	public $publicar; /* control de banners publicats */

	public function __construct()
	{
		/* inicialitza l'objecte */
		//$this->banners[0]=array('ruta'=>'pics/banner/mitago.gif','link'=>'https://www.facebook.com/mitagoficial','title'=>"Mitago Folk Band",'target'=>'_new'); /*Inici 11Febrer16*/
		//$this->banners[1]=array('ruta'=>'pics/banner/Bannerreaktion.jpg','link'=>'https://www.facebook.com/Reaktion-Metal-Band-336617996462626/','title'=>"Reaktion",'target'=>'_new');
		//$this->banners[2]=array('ruta'=>'pics/banner/bp.jpg','link'=>'https://www.facebook.com/javicansecoficial','title'=>"Bajo Presion",'target'=>'_new');    /*Inici 22Març16*/
		//$this->banners[3]=array('ruta'=>'pics/banner/kivents.gif','link'=>'https://kivents.com/','title'=>"Kivents",'target'=>'_new');    /*Inici 10Maig16*/
		//$this->banners[4]=array('ruta'=>'pics/banner/aerial.gif','link'=>'http://www.aerialblacked.com/','title'=>"Aerial Blacked",'target'=>'_new');    /*Inici 14Maig16*/
		//$this->banners[5]=array('ruta'=>'pics/banner/bvanner_hard.jpg','link'=>'http://www.satanarise.com/index.php?ln=ES&sec=concurso&tit=hardbuds','title'=>"Concurso Hard Buds",'target'=>'_new');

		//$this->total_banners=count($this->banners);
		//shuffle($this->banners);
		//$this->publicar=0;
	}
	public function omplir($bd)
	{
		$query =
			'select id, img, link, texte, datafi from banners where tipo = 700';
		$resultat_consulta = $bd->query($query);
		if ($resultat_consulta != false) {
			$numero_resultats = $resultat_consulta->num_rows;
			if ($numero_resultats > 0) {
				for ($x = 0; $x < $numero_resultats; $x++) {
					$resultat = $resultat_consulta->fetch_assoc();
					if ($resultat['datafi'] > date('Ymd')) {
						$this->banners[$x] = [
							'ruta' => $resultat['img'],
							'link' => $resultat['link'],
							'title' => $resultat['texte'],
							'id' => $resultat['id'],
							'target' => '_new',
						];
					}
				}
			}
		}
		$this->total_banners = count($this->banners);
		shuffle($this->banners);
		$this->publicar = 0;
	}
	public function visualitzar()
	{
		print '<a class="linkk" target="' .
			$this->banners[$this->publicar]['target'] .
			'" href="index.php?ln=ES&sec=link&id=' .
			$this->banners[$this->publicar]['id'] .
			'" tittle="' .
			$this->banners[$this->publicar]['title'] .
			'" ><img src="pics/banner/' .
			$this->banners[$this->publicar]['ruta'] .
			'" width="700" height="100" alt="' .
			$this->banners[$this->publicar]['title'] .
			'" /></a><br /><br />';

			$this->publicar++;
			if ($this->publicar == $this->total_banners) {
				$this->publicar = 0;
			}
			print '<a class="linkk" target="' .
			$this->banners[$this->publicar]['target'] .
			'" href="index.php?ln=ES&sec=link&id=' .
			$this->banners[$this->publicar]['id'] .
			'" tittle="' .
			$this->banners[$this->publicar]['title'] .
			'" ><img src="pics/banner/' .
			$this->banners[$this->publicar]['ruta'] .
			'" width="700" height="100" alt="' .
			$this->banners[$this->publicar]['title'] .
			'" /></a>';
			$this->publicar++;
			if ($this->publicar == $this->total_banners) {
				$this->publicar = 0;
			}
	}
}
class banner_100
{
	public $banners; /*Array de banners ruta, enllaç, tit, target */

	public function __construct()
	{
		/* inicialitza l'objecte */
		//$this->banners[0]=array('ruta'=>'pics/banner/satanarise.gif','link'=>'http://www.satanarise.com/index.php?ln=ES&sec=contacto','title'=>"Satan Arise",'target'=>'_new');
		//$this->banners[1]=array('ruta'=>'pics/banner/satansh.gif','link'=>'https://www.facebook.com/shphotobcn','title'=>"SH Photography",'target'=>'_new');
		//$this->banners[2]=array('ruta'=>'pics/banner/banner_hb.jpg','link'=>'https://play.spotify.com/album/4zHJzSGxkBbGqCpX41FqsD?play=true&utm_source=open.spotify.com&utm_medium=open','title'=>"Hard Buds",'target'=>'_new');

		//$this->total_banners=count($this->banners);
		//shuffle($this->banners);
	}
	public function omplir($bd)
	{
		$query =
			'select id, img, link, texte, datafi from banners where tipo = 100';
		$resultat_consulta = $bd->query($query);
		if ($resultat_consulta != false) {
			$numero_resultats = $resultat_consulta->num_rows;
			if ($numero_resultats > 0) {
				for ($x = 0; $x < $numero_resultats; $x++) {
					$resultat = $resultat_consulta->fetch_assoc();
					if ($resultat['datafi'] > date('Ymd')) {
						$this->banners[$x] = [
							'ruta' => $resultat['img'],
							'link' => $resultat['link'],
							'title' => $resultat['texte'],
							'id' => $resultat['id'],
							'target' => '_new',
						];
					}
				}
			}
		}
		if (!empty($this->banners)) {
			shuffle($this->banners);
		}
	}

	public function visualitzar()
	{
		$total = (isset($this->banners) && is_array($this->banners)) ? count($this->banners) : 0;
		
		for ($i = 0; $i < $total; $i++) {
			print '<a class="linkk" target="' .
				$this->banners[$i]['target'] .
				'" href="index.php?ln=ES&sec=link&id=' .
				$this->banners[$i]['id'] .
				'" tittle="' .
				$this->banners[$i]['title'] .
				'" ><img src="pics/banner/' .
				$this->banners[$i]['ruta'] .
				'" width="100" alt="' .
				$this->banners[$i]['title'] .
				'" /></a><br /><br />';
		}
	}
}
?>
