<?php

class ob_conciertos_web
{

	public $id;
	public $resultat_consulta;
	public $resultat_consulta2;
	public $numero_resultats;
	public $noticia_individual;
	public $concert_data;
	public $dades;
	public function __construct()
	{
		$this->id = '';
		$this->numero_resultats = 0;
		$this->punter = 1;
		$this->quantitat = 10;
		$this->noticia_individual = FALSE;
	}
	public function __get($nom) /* crea parametres */
	{
		return $this->$nom;
	}

	public function __set($nom, $valor) /* asigna valors al parametre */
	{
		return $this->$nom = $valor;
	}


	public function extreure_concerts_per_data_entrada($bd, $punter, $quantitat, $tipo)
	/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
		if ($tipo == 'normal') {
			$inici = 0;
			$quantitat = 15;
		} else {
			$inici = $punter - 1;
		}
		$query = "select idGig, Nom, cartell, num_concerts, num_bandes, dateIn, tipus from concerts order by dateIn desc limit " . $inici . ", " . $quantitat;
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta != FALSE) {
			$this->numero_resultats = $this->resultat_consulta->num_rows;
		}
	}

	public function mostrar_resultats_per_data_entrada($bd, $tipo, $page)
	{
		$this->concert_data = new concert_entrades;
		for ($i = 0; $i < $this->numero_resultats; $i++) {
			$this->concert_data->reset_data();
			$resultat = $this->resultat_consulta->fetch_assoc();
			$this->concert_data->id = $resultat['idGig'];
			$this->concert_data->num_concerts = $resultat['num_concerts'];
			$this->concert_data->num_bandes = $resultat['num_bandes'];
			$this->concert_data->dateIn = $resultat['dateIn'];
			$this->concert_data->tipus = $resultat['tipus'];
			$this->concert_data->nom = $resultat['Nom'];
			$this->concert_data->cartell = $resultat['cartell'];
			switch ($this->concert_data->tipus) {
				case '1':
					/* Concierto único*/
					$query = "select idConcert, localitat, sala, dateConcert from concertsdata where concertsdata.idGig = '" . $this->concert_data->id . "'";
					$resultat_consulta2 = $bd->query($query);
					if ($this->resultat_consulta != FALSE) {
						$resultat2 = $resultat_consulta2->fetch_assoc();
						$this->concert_data->sala = $resultat2['sala'];
						$this->concert_data->localitat = $resultat2['localitat'];
						$this->concert_data->id_concert = $resultat2['idConcert'];
						$this->concert_data->dateConcert = $resultat2['dateConcert'];
						$query = "select Grup from concertsgrups where idConcert = '" . $this->concert_data->id_concert . "' order by ordre";
						$resultat_consulta2 = $bd->query($query);
						if ($this->resultat_consulta != FALSE) {
							$numero_resultats = $resultat_consulta2->num_rows;
							for ($y = 0; $y < $numero_resultats; $y++) {
								$resultat2 = $resultat_consulta2->fetch_assoc();
								if ($this->concert_data->grups != '') {
									$this->concert_data->grups = $this->concert_data->grups . ' + ' . $resultat2['Grup'];
								} else {
									$this->concert_data->grups = $resultat2['Grup'];
								}
							}
						}
					}
					$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
					print '<a class="linkk" href="index.php?ln=' . $page->leng . '&sec=' . $page->section . '&type=entrada&id=' . $this->concert_data->id . '" title="';
					switch ($page->leng) {
						case 'ES':
							print 'Concierto de ';
							break;
						case 'CAT':
							print 'Concert de ';
							break;
					}
					print $this->concert_data->grups . ' ' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')">';
					switch ($page->concert_tipus) {
						case 'normal':
							print '<div class="entrada_concert">';
							break;
						case 'entradas':
							print '<div class="entrada_concert_ample">';
							break;
					}
					$tamany = array();
					$tamany = getimagesize('pics/conc/' . $this->concert_data->cartell);
					/* Es mesuren les proporcions a 154 alçada */

					$ample = floor((150 * $tamany[0]) / $tamany[1]);
					if ($ample > 106) {
						/* mes ample me alt */
						$tam_imp = 'width="106"';
					} else {
						/* mes alt que llarg */
						$tam_imp = 'height="150"';
					}
					print '<img src="pics/conc/' . $this->concert_data->cartell . '" ' . $tam_imp . ' alt="' . $this->concert_data->grups . '" />';
					$this->concert_data->dataIn = $this->timestamp_a_data($this->concert_data->dateIn);
					print '<div class="data_con">' . $this->concert_data->dataIn . '</div>';
					print '<h1>';
					if ($this->concert_data->nom != '') {
						print $this->concert_data->nom . ' <br />';
					}
					print $this->concert_data->grups . '</h1>';
					print '<p>' . $this->concert_data->data . '<br />' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')</p>';
					print '</div></a>';
					break;
				case '2':
					/* Gira */
					$query = "select localitat, sala, dateConcert, cartell_concert from concertsdata where concertsdata.idGig = '" . $this->concert_data->id . "'";
					$resultat_consulta2 = $bd->query($query);
					if ($resultat_consulta2 != FALSE) {
						$numero_resultats = $resultat_consulta2->num_rows;
						$array_dates = array();
						for ($y = 0; $y < $numero_resultats; $y++) {
							$resultat2 = $resultat_consulta2->fetch_assoc();
							$this->concert_data->sala = $resultat2['sala'];
							$this->concert_data->localitat = $resultat2['localitat'];
							$this->concert_data->cartell_concert = $resultat2['cartell_concert'];
							$this->concert_data->dateConcert = $resultat2['dateConcert'];
							$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
							$array_dates[] = $this->concert_data->data . '<br />' . $this->concert_data->sala . '  (' . $this->concert_data->localitat . ')';
						}
					}
					$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
					print '<a class="linkk" href="index.php?ln=' . $page->leng . '&sec=' . $page->section . '&type=entrada&id=' . $this->concert_data->id . '" title="' . $this->concert_data->nom . '">';
					switch ($page->concert_tipus) {
						case 'normal':
							print '<div class="entrada_concert">';
							break;
						case 'entradas':
							print '<div class="entrada_concert_ample">';
							break;
					}
					print '<img src="pics/conc/';
					if ($this->concert_data->cartell != '') {
						$cartell = $this->concert_data->cartell;
					} else {
						$cartell = $this->concert_data->cartell_concert;
					}
					$tamany = array();
					$tamany = getimagesize('pics/conc/' . $cartell);
					/* Es mesuren les proporcions a 154 alçada */

					$ample = floor((150 * $tamany[0]) / $tamany[1]);
					if ($ample > 106) {
						/* mes ample me alt */
						$tam_imp = 'width="106"';
					} else {
						/* mes alt que llarg */
						$tam_imp = 'height="150"';
					}
					print $cartell . '" ' . $tam_imp . ' alt="' . $this->concert_data->nom . '" />';
					$this->concert_data->dataIn = $this->timestamp_a_data($this->concert_data->dateIn);
					print '<div class="data_con">' . $this->concert_data->dataIn . '</div>';

					print '<h1>';
					print $this->concert_data->nom . '</h1><p>';
					for ($y = 0; $y < $numero_resultats; $y++) {
						print $array_dates[$y] . '<br /><br />';
					}

					print '</p></div></a>';
					break;
				case '3':
					/* Festival */
					$query = "select localitat, sala, dateConcert from concertsdata where concertsdata.idGig = '" . $this->concert_data->id . "'";
					$resultat_consulta2 = $bd->query($query);
					if ($resultat_consulta2 != FALSE) {
						$numero_resultats = $resultat_consulta2->num_rows;
						$array_dates = array();
						for ($y = 0; $y < $numero_resultats; $y++) {
							$resultat2 = $resultat_consulta2->fetch_assoc();
							$this->concert_data->sala = $resultat2['sala'];
							$this->concert_data->localitat = $resultat2['localitat'];
							$this->concert_data->dateConcert = $resultat2['dateConcert'];
							$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
							$array_dates[] = $this->concert_data->data . '<br />';
						}
					}
					$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
					print '<a class="linkk" href="index.php?ln=' . $page->leng . '&sec=' . $page->section . '&type=entrada&id=' . $this->concert_data->id . '" title="' . $this->concert_data->nom . '">';
					switch ($page->concert_tipus) {
						case 'normal':
							print '<div class="entrada_concert">';
							break;
						case 'entradas':
							print '<div class="entrada_concert_ample">';
							break;
					}
					$tamany = array();
					$tamany = getimagesize('pics/conc/' . $this->concert_data->cartell);
					/* Es mesuren les proporcions a 154 alçada */

					$ample = floor((150 * $tamany[0]) / $tamany[1]);
					if ($ample > 106) {
						/* mes ample me alt */
						$tam_imp = 'width="106"';
					} else {
						/* mes alt que llarg */
						$tam_imp = 'height="150"';
					}
					print '<img src="pics/conc/' . $this->concert_data->cartell . '" ' . $tam_imp . ' alt="' . $this->concert_data->nom . '" />';
					$this->concert_data->dataIn = $this->timestamp_a_data($this->concert_data->dateIn);
					print '<div class="data_con">' . $this->concert_data->dataIn . '</div>';

					print '<h1>';
					print $this->concert_data->nom . '</h1><p>';
					for ($y = 0; $y < $numero_resultats; $y++) {
						print $array_dates[$y];
					}
					print $this->concert_data->sala . '  (' . $this->concert_data->localitat . ')';

					print '</p></div></a>';
					break;
			}

		}
	}
	public function extreure_concerts_per_data_concert($bd, $punter, $quantitat, $tipo)
	/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
		if ($tipo == 'normal') {
			$inici = 0;
			$quantitat = 25;
		} else {
			$inici = $punter - 1;
		}
		$data_actual = $this->timestamp_actual();
		$data_actual = str_replace(' ', '', str_replace(':', '', str_replace('-', '', $data_actual)));
		$query = "select concerts.idGig, concerts.cartell, concerts.Nom,  concerts.num_bandes, concerts.dateIn, concerts.tipus, concertsdata.idConcert, concertsdata.dateConcert, concertsdata.cartell_concert from concertsdata, concerts where concertsdata.dateConcert >= " . $data_actual . " and concerts.idGig = concertsdata.idGig order by concertsdata.dateConcert asc limit " . $inici . ", " . $quantitat;

		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta != FALSE) {
			$this->numero_resultats = $this->resultat_consulta->num_rows;
		}
	}
	public function mostrar_resultats_per_data_concert_index($bd, $page)
	{
		if ($this->resultat_consulta != FALSE) {
			$this->concert_data = new concert_entrades;
			for ($i = 0; $i < $this->numero_resultats; $i++) {
				$this->concert_data->reset_data();
				$resultat = $this->resultat_consulta->fetch_assoc();
				$this->concert_data->id = $resultat['idGig'];
				$this->concert_data->cartell = $resultat['cartell'];
				$this->concert_data->id_concert = $resultat['idConcert'];
				$this->concert_data->num_bandes = $resultat['num_bandes'];
				$this->concert_data->dateIn = $resultat['dateIn'];
				$this->concert_data->dateConcert = $resultat['dateConcert'];
				$this->concert_data->tipus = $resultat['tipus'];
				$this->concert_data->nom = $resultat['Nom'];

				/* Concierto único*/
				$query = "select localitat, sala, cartell_concert from concertsdata where idConcert = '" . $this->concert_data->id_concert . "'";
				$resultat_consulta2 = $bd->query($query);
				if ($this->resultat_consulta != FALSE) {
					$resultat2 = $resultat_consulta2->fetch_assoc();
					$this->concert_data->sala = $resultat2['sala'];
					$this->concert_data->localitat = $resultat2['localitat'];
					$cartell_especific = $resultat2['cartell_concert'];
					$query = "select Grup from concertsgrups where idConcert = '" . $this->concert_data->id_concert . "' order by ordre";
					$resultat_consulta2 = $bd->query($query);
					if ($this->resultat_consulta != FALSE) {
						$numero_resultats = $resultat_consulta2->num_rows;
						for ($y = 0; $y < $numero_resultats; $y++) {
							$resultat2 = $resultat_consulta2->fetch_assoc();
							if ($this->concert_data->grups != '') {
								$this->concert_data->grups = $this->concert_data->grups . ' + ' . $resultat2['Grup'];
							} else {
								$this->concert_data->grups = $resultat2['Grup'];
							}
						}
					}
				}
				$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
				switch ($page->leng) {
					case 'ES':
						$seccio = 'conciertos';
						break;
					case 'CAT':
						$seccio = 'concerts';
						break;
				}
				print '<a class="linkk" href="index.php?ln=' . $page->leng . '&sec=' . $seccio . '&type=entrada&id=' . $this->concert_data->id . '" title="';
				switch ($page->leng) {
					case 'ES':
						print 'Concierto de ';
						break;
					case 'CAT':
						print 'Concert de ';
						break;
				}
				print $this->concert_data->grups . ' ' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')">';
				$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);

				print '<div class="proper_concert">';
				print '<img src="pics/conc/';
				if ($cartell_especific == '') {
					$cartell = $this->concert_data->cartell;
				} else {
					$cartell = $cartell_especific;
				}
				$tamany = array();
				$tamany = getimagesize('pics/conc/' . $cartell);
				/* Es mesuren les proporcions a 154 alçada */
				$max_h = 154;
				$max_w = 109;
				$ample = floor((154 * $tamany[0]) / $tamany[1]);
				if ($ample > 109) {
					/* mes ample me alt */
					$tam_imp = 'width="109"';
				} else {
					/* mes alt que llarg */
					$tam_imp = 'height="154"';
				}

				print $cartell . '" alt="' . $this->concert_data->grups . ' ' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')" ' . $tam_imp . ' />';
				print '<h1>';
				switch ($this->concert_data->tipus) {
					case '1':
						if ($this->concert_data->nom != '') {
							print $this->concert_data->nom . '</h1>';
						} else {
							print $this->concert_data->grups . '</h1>';
						}
						print '<p>' . $this->concert_data->data . '<br />' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')</p>';

						break;
					case '2':
						print $this->concert_data->grups . '</h1>';
						;
						print '<p>' . $this->concert_data->data . '<br />' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')</p>';

						break;
					case '3':
						if ($this->concert_data->nom != '') {
							print $this->concert_data->nom . '</h1>';
						}

						print '<p>' . $this->concert_data->data . '<br />' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')</p>';
						break;
				}

				print '</div>';


				print '</a>';
			}
		} else {

		}
	}

	public function mostrar_resultats_per_data_concert($bd, $tipo, $page)
	{
		if ($this->resultat_consulta != FALSE) {
			$this->concert_data = new concert_entrades;
			for ($i = 0; $i < $this->numero_resultats; $i++) {
				$this->concert_data->reset_data();
				$resultat = $this->resultat_consulta->fetch_assoc();
				$this->concert_data->id = $resultat['idGig'];
				$this->concert_data->cartell = $resultat['cartell'];
				$this->concert_data->id_concert = $resultat['idConcert'];
				$this->concert_data->num_bandes = $resultat['num_bandes'];
				$this->concert_data->dateIn = $resultat['dateIn'];
				$this->concert_data->dateConcert = $resultat['dateConcert'];
				$this->concert_data->tipus = $resultat['tipus'];
				$this->concert_data->nom = $resultat['Nom'];
				$cartell_concert = $resultat['cartell_concert'];

				/* Concierto único*/
				$query = "select localitat, sala from concertsdata where idConcert = '" . $this->concert_data->id_concert . "'";
				$resultat_consulta2 = $bd->query($query);
				if ($this->resultat_consulta != FALSE) {
					$resultat2 = $resultat_consulta2->fetch_assoc();
					$this->concert_data->sala = $resultat2['sala'];
					$this->concert_data->localitat = $resultat2['localitat'];
					$query = "select Grup from concertsgrups where idConcert = '" . $this->concert_data->id_concert . "' order by ordre";
					$resultat_consulta2 = $bd->query($query);
					if ($this->resultat_consulta != FALSE) {
						$numero_resultats = $resultat_consulta2->num_rows;
						for ($y = 0; $y < $numero_resultats; $y++) {
							$resultat2 = $resultat_consulta2->fetch_assoc();
							if ($this->concert_data->grups != '') {
								$this->concert_data->grups = $this->concert_data->grups . ' + ' . $resultat2['Grup'];
							} else {
								$this->concert_data->grups = $resultat2['Grup'];
							}
						}
					}
				}
				$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
				print '<a class="linkk" href="index.php?ln=' . $page->leng . '&sec=' . $page->section . '&type=entrada&id=' . $this->concert_data->id . '" title="';
				switch ($page->leng) {
					case 'ES':
						print 'Concierto de ';
						break;
					case 'CAT':
						print 'Concert de ';
						break;
				}
				print $this->concert_data->grups . ' ' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')">';

				/* Wrap in entrada_concert div to match conciertos column style */
				print '<div class="entrada_concert">';

				/* Determine which image to use - prefer specific concert poster, fallback to general */
				$cartell_to_use = '';
				if ($cartell_concert != '') {
					$cartell_to_use = $cartell_concert;
				} else if ($this->concert_data->cartell != '') {
					$cartell_to_use = $this->concert_data->cartell;
				}

				/* Display image if available - same size as conciertos column */
				if ($cartell_to_use != '') {
					$tamany = array();
					$tamany = getimagesize('pics/conc/' . $cartell_to_use);
					/* Same sizing logic as conciertos column */
					$ample = floor((150 * $tamany[0]) / $tamany[1]);
					if ($ample > 106) {
						/* mes ample me alt */
						$tam_imp = 'width="106"';
					} else {
						/* mes alt que llarg */
						$tam_imp = 'height="150"';
					}
					print '<img src="pics/conc/' . $cartell_to_use . '" ' . $tam_imp . ' alt="' . $this->concert_data->grups . '" />';
				}

				$this->concert_data->dataIn = $this->timestamp_a_data($this->concert_data->dateIn);
				print '<div class="data_con">' . $this->concert_data->dataIn . '</div>';
				print '<h1>';
				switch ($this->concert_data->tipus) {
					case '1':
						if ($this->concert_data->nom != '') {
							print $this->concert_data->nom . ' <br />';
						}
						print $this->concert_data->grups;
						break;
					case '2':
						print $this->concert_data->grups;
						break;
					case '3':
						if ($this->concert_data->nom != '') {
							print $this->concert_data->nom;
						}
						break;
				}
				print '</h1>';
				print '<p>' . $this->concert_data->data . '<br />' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')</p>';
				print '</div></a>';
			}
		}
	}

	public function extreure_concert_unic($bd, $id, $idioma)
	/* consultar concert a la bbdd a partir d'una id */
	{

		$error = TRUE;
		$query = "select tipus, Nom, texte, cartell, dateIn, descripcio, num_concerts, num_bandes from concerts where idGig = " . $id;
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta == FALSE) {
			$error = TRUE;
		} else {
			$resultat = $this->resultat_consulta->fetch_assoc();
			$num_concerts = $resultat['num_concerts'];
			$num_bandes = $resultat['num_bandes'];
			$this->dades = new entrada_concerts($num_concerts, $num_bandes);
			$this->dades->id = $id;
			$this->dades->titol = $resultat['Nom'];
			$this->dades->cartell = $resultat['cartell'];
			$this->dades->texte = $resultat['texte'];
			$this->dades->dateIn = $resultat['dateIn'];
			$this->dades->descripcio = $resultat['descripcio'];
			$this->dades->num_concerts = $num_concerts;
			$this->dades->num_bandes = $num_bandes;
			$this->dades->tipus = $resultat['tipus'];

			/* Dades genériques extretes, torn del bucle de concerts */

			$query = "select idGig, idConcert, cartell_concert, dateConcert, sala, link, localitat, preu, preu_ant, patrocinat, dateIn from concertsdata where idGig = " . $id . " order by idConcert asc";
			$this->resultat_consulta = $bd->query($query);
			if ($this->resultat_consulta == FALSE) {
				$error = TRUE;
			} else {
				$concs = $this->resultat_consulta->num_rows;
				for ($i = 0; $i < $concs; $i++) {
					$resultat = $this->resultat_consulta->fetch_assoc();
					$nom = 'concert' . ($i + 1);
					$this->dades->$nom->id_concert = $resultat['idConcert'];
					$this->dades->$nom->idGig = $resultat['idGig'];
					$this->dades->$nom->link = $resultat['link'];
					$this->dades->$nom->cartell_concert = $resultat['cartell_concert'];
					$this->dades->$nom->dateConcert = $resultat['dateConcert'];
					$this->dades->$nom->sala = $resultat['sala'];
					$this->dades->$nom->localitat = $resultat['localitat'];
					$this->dades->$nom->preu = $resultat['preu'];
					$this->dades->$nom->preu_ant = $resultat['preu_ant'];
					$this->dades->$nom->patrocinat = $resultat['patrocinat'];
					$this->dades->$nom->data = $resultat['dateConcert'];
					$array_data = $this->timestamp_a_taula($this->dades->$nom->dateConcert);
					$this->dades->$nom->dia = $array_data['dia'];
					$this->dades->$nom->mes = $array_data['mes'];
					$this->dades->$nom->any = $array_data['any'];
					$this->dades->$nom->hora = $array_data['hora'];
					$this->dades->$nom->mins = $array_data['min'];

					$query = "select idConcert, ordre, Grup, Video from concertsgrups where idConcert= '" . $this->dades->$nom->id_concert . "' order by ordre asc";

					$this->resultat_consulta2 = $bd->query($query);
					if ($this->resultat_consulta2 == FALSE) {
						$error = TRUE;
					} else {
						$bandes = $this->resultat_consulta2->num_rows;
						for ($y = 0; $y < $bandes; $y++) {
							$resultat2 = $this->resultat_consulta2->fetch_assoc();
							$nom2 = 'banda' . ($y + 1);
							$this->dades->$nom->$nom2->nom = $resultat2['Grup'];
							$this->dades->$nom->$nom2->video = $resultat2['Video'];
							$this->dades->$nom->$nom2->ordre = $resultat2['ordre'];
							$this->dades->$nom->$nom2->id_concert = $resultat2['idConcert'];
							if ($this->dades->$nom->grups != '') {
								$this->dades->$nom->grups = $this->dades->$nom->grups . ' + ' . $this->dades->$nom->$nom2->nom;
							} else {
								$this->dades->$nom->grups = $this->dades->$nom->$nom2->nom;
							}
						}
					}
				}
			}
		}
		return $error;
	}

	public function mostrar_resultat_concert_unic($idioma)
	{
		switch ($this->dades->tipus) {
			case '1':
				if ($this->dades->cartell != '') { /* Hi ha cartell */
					print '<div class="centrar"><img class="cartell_concert" src="pics/conc/' . $this->dades->cartell . '" alt="' . $this->dades->concert1->grups . '" width="400" /></div>';
				}
				print '<h1 class="titol_concert">';
				if ($this->dades->titol != '') {
					print $this->dades->titol . '<br /><br />';
				}
				switch ($idioma) {
					case 'ES':
						$texte = array('Fecha', 'Sala', 'Localidad', 'Entrada', 'Anticipada', 'Apertura', 'Evento de Facebook');
						break;
					case 'CAT':
						$texte = array('Data', 'Sala', 'Localitat', 'Entrada', 'Anticipada', 'Obertura', 'Event de Facebook');
						break;
				}
				print '<span class="blanc">' . str_replace(' + ', '<br />', $this->dades->concert1->grups) . '</span>';
				print "</h1>\n<p>";
				print $texte[0] . ': <span class="blanc">' . $this->timestamp_a_data($this->dades->concert1->dateConcert) . '</span><br />
				 ' . $texte[1] . ': <span class="blanc">' . $this->dades->concert1->sala . '</span><br />
 				 ' . $texte[2] . ': <span class="blanc">' . $this->dades->concert1->localitat . '</span><br />';
				if (($this->dades->concert1->preu != '') && ($this->dades->concert1->preu != 0)) {
					print $texte[3] . ': <span class="blanc">';
					if (($this->dades->concert1->preu == 'Gratuito') && ($idioma == 'CAT')) {
						$this->dades->concert1->preu = 'Gratuït';
					}
					print $this->dades->concert1->preu;
					if (($this->dades->concert1->preu != 'Gratuït') && ($this->dades->concert1->preu != 'Gratuito')) {
						print ' €';
					}
					print '</span><br />';
				}

				if (($this->dades->concert1->preu_ant != '') && ($this->dades->concert1->preu_ant != 0)) {
					print $texte[4] . ': <span class="blanc">' . $this->dades->concert1->preu_ant . ' €</span><br />';
				}
				$this->dades->concert1->dateConcert = $this->timestamp_a_hora($this->dades->concert1->dateConcert);
				if ($this->dades->concert1->dateConcert != '00:00') {
					print $texte[5] . ': <span class="blanc">' . $this->dades->concert1->dateConcert . '</span><br />';
				}
				if ($this->dades->concert1->link != '') {
					print '<br /><a class="linkk" target="_blank" href="http://';
					$this->dades->concert1->link = str_replace('http://', '', $this->dades->concert1->link);
					$this->dades->concert1->link = str_replace('https://', '', $this->dades->concert1->link);
					print $this->dades->concert1->link;
					print '">' . $texte[6] . '</a>';
				}
				print '
				<!-- ShareThis BEGIN -->
				<div class="sharethis-inline-reaction-buttons"></div>
				<!-- ShareThis END -->
				';
				print '<!-- ShareThis BEGIN -->
				 <div class="sharethis-inline-share-buttons"></div>
				 <!-- ShareThis END -->';
				print '</div>';


				if (($idioma == 'ES') && ($this->dades->texte != '')) {
					print '<p class="texte_concerts">';
					print nl2br($row = $this->posar_negretes($this->tractar_tag_link(1, $this->dades->texte), $this->dades->descripcio));
					print '</p>';
				}
				print '<div class="centrar">';
				for ($i = 0; $i < $this->dades->num_bandes; $i++) {
					$nom = 'banda' . ($i + 1);
					if ($this->dades->concert1->$nom->video != '') {
						print '<iframe width="350" height="197" src="https://www.youtube.com/embed/' . $this->dades->concert1->$nom->video . '?rel=0" frameborder="0" allowfullscreen></iframe>';
					}
				}
				print '</p>';
				break;

			case '2':
				if ($this->dades->cartell != '') { /* Hi ha un cartell unic per la gira */
					print '<div class="centrar"><img class="cartell_concert" src="pics/conc/' . $this->dades->cartell . '" width="400" alt="' . $this->dades->concert1->grups . '" /></div>';
				} else {
					for ($i = 0; $i < $this->dades->num_concerts; $i++) {
						$nom = 'concert' . ($i + 1);
						if ($this->dades->$nom->cartell_concert != '') {
							print '<img class="cartell_concert" src="pics/conc/' . $this->dades->$nom->cartell_concert . '" alt="' . $this->dades->concert1->grups . '" width="222">';
						}
					}
					print '<br /><br />';
				}

				if ($this->dades->titol != '') {
					print '<h1 class="titol_gira">' . $this->dades->titol . '</h1>';
				}
				switch ($idioma) {
					case 'ES':
						$texte = array('Fecha', 'Sala', 'Localidad', 'Entrada', 'Anticipada', 'Apertura', 'Evento de Facebook');
						break;
					case 'CAT':
						$texte = array('Data', 'Sala', 'Localitat', 'Entrada', 'Anticipada', 'Obertura', 'Event de Facebook');
						break;
				}
				for ($i = 0; $i < $this->dades->num_concerts; $i++) {
					$nom = 'concert' . ($i + 1);
					print '<h1 class="titol_gira_grups">' . $this->dades->$nom->grups . "</h1>\n<p>";
					print $texte[0] . ': <span class="blanc">' . $this->timestamp_a_data($this->dades->$nom->dateConcert) . '</span><br />
					 	' . $texte[1] . ': <span class="blanc">' . $this->dades->$nom->sala . '</span><br />
					 	' . $texte[2] . ': <span class="blanc">' . $this->dades->$nom->localitat . '</span><br />';
					if (($this->dades->$nom->preu != '') && ($this->dades->$nom->preu != 0)) {
						print $texte[3] . ': <span class="blanc">';
						if (($this->dades->$nom->preu == 'Gratuito') && ($idioma == 'CAT')) {
							$this->dades->$nom->preu = 'Gratuït';
						}
						print $this->dades->$nom->preu;
						if (($this->dades->$nom->preu != 'Gratuït') && ($this->dades->$nom->preu != 'Gratuito')) {
							print ' €';
						}
						print '</span><br />';
					}
					if (($this->dades->$nom->preu_ant != '') && ($this->dades->$nom->preu_ant != 0)) {
						print $texte[4] . ': <span class="blanc">' . $this->dades->$nom->preu_ant . ' €</span><br />';
					}
					$this->dades->$nom->dateConcert = $this->timestamp_a_hora($this->dades->$nom->dateConcert);
					if ($this->dades->$nom->dateConcert != '00:00') {
						print $texte[5] . ': <span class="blanc">' . $this->dades->$nom->dateConcert . '</span><br />';
					}
					if ($this->dades->$nom->link != '') {
						print '<br /><a class="linkk" target="_blank" href="http://';
						$this->dades->$nom->link = str_replace('http://', '', $this->dades->concert1->link);
						$this->dades->$nom->link = str_replace('https://', '', $this->dades->concert1->link);
						print $this->dades->$nom->link;
						print '">' . $texte[6] . '</a><br /><br /><br />';
					}
				}
				print '
				<!-- ShareThis BEGIN -->
				<div class="sharethis-inline-reaction-buttons"></div>
				<!-- ShareThis END -->
				';
				print '<!-- ShareThis BEGIN -->
				 <div class="sharethis-inline-share-buttons"></div>
				 <!-- ShareThis END -->';
				print '</div>';
				print '</p>';
				if (($idioma == 'ES') && ($this->dades->texte != '')) {
					print '<p class="texte_concerts">';
					print nl2br($row = $this->posar_negretes($this->tractar_tag_link(1, $this->dades->texte), $this->dades->descripcio));
					print '</p>';
				}
				print '<div class="centrar">';
				$grups = array();
				for ($i = 0; $i < $this->dades->num_concerts; $i++) {
					$nom = 'concert' . ($i + 1);
					for ($y = 0; $y < $this->dades->num_bandes; $y++) {
						$nom2 = 'banda' . ($y + 1);
						$grups[] = $this->dades->$nom->$nom2->nom;
						if ($this->dades->$nom->$nom2->video != '') {
							$coincidencia = FALSE;
							for ($z = 0; $z < count($grups); $z++) {
								if ($grups[$z] == $this->dades->$nom->$nom2->nom)
									$coincidencia = TRUE;
							}
							if (!$coincidencia) {
								print '<iframe width="350" height="197" src="https://www.youtube.com/embed/' . $this->dades->$nom->$nom2->video . '?rel=0" frameborder="0" allowfullscreen></iframe>';
							}
						}
					}
				}
				break;
			case '3':
				if ($this->dades->cartell != '') { /* Hi ha cartell */
					print '<div class="centrar"><img class="cartell_concert" src="pics/conc/' . $this->dades->cartell . '" alt="' . $this->dades->concert1->grups . '" width="400" /></div>';
				}
				print '<h1 class="titol_concert">';
				if ($this->dades->titol != '') {
					print $this->dades->titol . '<br />';
				}
				switch ($idioma) {
					case 'ES':
						$texte = array('Fecha', 'Sala', 'Localidad', 'Entrada', 'Anticipada', 'Apertura', 'Evento de Facebook');
						break;
					case 'CAT':
						$texte = array('Data', 'Sala', 'Localitat', 'Entrada', 'Anticipada', 'Obertura', 'Event de Facebook');
						break;
				}

				print "</h1>\n<p>";
				print $texte[0] . ': ';
				for ($i = 0; $i < $this->dades->num_concerts; $i++) {
					$nom = 'concert' . ($i + 1);
					if ($i > 0) {
						print ' - ';
					}
					print '<span class="blanc">' . $this->timestamp_a_data($this->dades->$nom->dateConcert) . '</span>';
				}
				print '<br />';

				if ($this->dades->concert1->sala != '') {
					print $texte[1] . ': <span class="blanc">' . $this->dades->concert1->sala . '</span><br />';
				}
				print $texte[2] . ': <span class="blanc">' . $this->dades->concert1->localitat . '</span><br />';

				if (($this->dades->concert1->preu != '') && ($this->dades->concert1->preu != 0)) {
					print $texte[3] . ': <span class="blanc">';
					if (($this->dades->concert1->preu == 'Gratuito') && ($idioma == 'CAT')) {
						$this->dades->concert1->preu = 'Gratuït';
					}
					print $this->dades->concert1->preu;
					if (($this->dades->concert1->preu != 'Gratuït') && ($this->dades->concert1->preu != 'Gratuito')) {
						print ' €';
					}
					print '</span><br />';
				}
				$grups = '';
				for ($i = 0; $i < $this->dades->num_concerts; $i++) {
					$nom = 'concert' . ($i + 1);
					for ($y = 0; $y < $this->dades->num_bandes; $y++) {
						$nom2 = 'banda' . ($y + 1);
						if ($this->dades->$nom->$nom2->nom != '') {
							if ($grups == '') {
								$grups = $this->dades->$nom->$nom2->nom . '<br />';
							} else {
								$grups = $grups . $this->dades->$nom->$nom2->nom . '<br />';
							}
						}
					}
				}
				if ($grups != '') {
					print 'Bandas: <br /><br /><span class="blanc">' . $grups . '</span><br />';
				}
				if ($this->dades->concert1->link != '') {
					print '<a class="linkk" target="_blank" href="http://';
					$this->dades->concert1->link = str_replace('http://', '', $this->dades->concert1->link);
					$this->dades->concert1->link = str_replace('https://', '', $this->dades->concert1->link);
					print $this->dades->concert1->link;

					print '">' . $texte[6] . '</a>';
				}
				print '
				<!-- ShareThis BEGIN -->
				<div class="sharethis-inline-reaction-buttons"></div>
				<!-- ShareThis END -->
				';
				print '<!-- ShareThis BEGIN -->
				<div class="sharethis-inline-share-buttons"></div>
				<!-- ShareThis END -->';
				print '</div>';
				print '</p>';
				if (($idioma == 'ES') && ($this->dades->texte != '')) {
					print '<p class="texte_concerts">';
					print nl2br($row = $this->posar_negretes($this->tractar_tag_link(1, $this->dades->texte), $this->dades->descripcio));
					print '</p>';
				}
				print '<div class="centrar">';
				for ($i = 0; $i < $this->dades->num_bandes; $i++) {
					$nom = 'banda' . ($i + 1);
					if ($this->dades->concert1->$nom->video != '') {
						print '<iframe width="350" height="197" src="https://www.youtube.com/embed/' . $this->dades->concert1->$nom->video . '?rel=0" frameborder="0" allowfullscreen></iframe>';
					}
				}
				break;
		}
	}

	public function extreure_banner_lateral_concerts($bd, $punter, $quantitat, $tipo)
	/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar que siguin patrocinats*/
	{
		/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
		if ($tipo == 'normal') {
			$inici = 0;
			$quantitat = 20;
		} else {
			$inici = $punter - 1;
		}
		$data_actual = $this->timestamp_actual();
		$data_actual = str_replace(' ', '', str_replace(':', '', str_replace('-', '', $data_actual)));
		$query = "select concerts.idGig, concerts.cartell, concerts.Nom,  concerts.num_bandes, concerts.dateIn, concerts.tipus, concertsdata.idConcert, concertsdata.dateConcert from concertsdata, concerts where concertsdata.dateConcert >= " . $data_actual . " and concerts.idGig = concertsdata.idGig and concertsdata.patrocinat = 1 order by concertsdata.dateConcert asc limit " . $inici . ", " . $quantitat;
		$this->resultat_consulta = $bd->query($query);
		if ($this->resultat_consulta != FALSE) {
			$this->numero_resultats = $this->resultat_consulta->num_rows;
		}
	}

	public function mostrar_resultats_per_banner_lateral_concerts($bd, $page)
	{
		if ($this->resultat_consulta != FALSE) {
			$this->concert_data = new concert_entrades;
			$last_id = 0;
			for ($i = 0; $i < $this->numero_resultats; $i++) {
				$this->concert_data->reset_data();
				$resultat = $this->resultat_consulta->fetch_assoc();
				$this->concert_data->id = $resultat['idGig'];
				$this->concert_data->cartell = $resultat['cartell'];
				$this->concert_data->id_concert = $resultat['idConcert'];
				$this->concert_data->num_bandes = $resultat['num_bandes'];
				$this->concert_data->dateIn = $resultat['dateIn'];
				$this->concert_data->dateConcert = $resultat['dateConcert'];
				$this->concert_data->tipus = $resultat['tipus'];
				$this->concert_data->nom = $resultat['Nom'];

				/* Concierto único*/
				$query = "select localitat, sala from concertsdata where idConcert = '" . $this->concert_data->id_concert . "'";
				$resultat_consulta2 = $bd->query($query);
				if ($this->resultat_consulta != FALSE) {
					$resultat2 = $resultat_consulta2->fetch_assoc();
					$this->concert_data->sala = $resultat2['sala'];
					$this->concert_data->localitat = $resultat2['localitat'];
					$query = "select Grup from concertsgrups where idConcert = '" . $this->concert_data->id_concert . "' order by ordre";
					$resultat_consulta2 = $bd->query($query);
					if ($this->resultat_consulta != FALSE) {
						$numero_resultats = $resultat_consulta2->num_rows;
						for ($y = 0; $y < $numero_resultats; $y++) {
							$resultat2 = $resultat_consulta2->fetch_assoc();
							if ($this->concert_data->grups != '') {
								$this->concert_data->grups = $this->concert_data->grups . ' + ' . $resultat2['Grup'];
							} else {
								$this->concert_data->grups = $resultat2['Grup'];
							}
						}
					}
				}
				$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
				if ((($last_id != $this->concert_data->id) && ($this->concert_data->tipus == 3)) || ($this->concert_data->tipus != 3)) {
					switch ($page->leng) {
						case 'ES':
							$seccio = 'conciertos';
							break;
						case 'CAT':
							$seccio = 'concerts';
							break;
					}
					print '<a class="linkk" href="index.php?ln=' . $page->leng . '&sec=' . $seccio . '&type=entrada&id=' . $this->concert_data->id . '" title="';
					switch ($page->leng) {
						case 'ES':
							print 'Concierto de ';
							break;
						case 'CAT':
							print 'Concert de ';
							break;
					}
					print $this->concert_data->grups . ' ' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')">';
					$this->concert_data->data = $this->timestamp_a_data($this->concert_data->dateConcert);
					print '<img src="pics/conc/' . $this->concert_data->cartell . '" alt="' . $this->concert_data->grups . ' ' . $this->concert_data->sala . ' (' . $this->concert_data->localitat . ')" width="150" /><br />';
					print '</a><br />';
					$last_id = $this->concert_data->id;
				}
			}
		} else {

		}
	}
	public function tractar_tag_link($opcio, $texte)
	/* Als textes busca el tag [link] www.xemple.es [link] on www.exemple.es es una adreça url completa sense els http i si opcio es 1 el converteix en un link class linkk i la resta del texte el tracta per caracterls especials html i si es 2 ignira els tags i els treu del texte i el filtra per caracters html */
	{
		$array_texte = explode('[link]', $texte);
		$texte = '';
		switch ($opcio) {
			case '1': /* [link]www.exemple.es[link] -> <a class="linkk" href="http://www.exemple.es">www.exemple.es</a> */
				for ($i = 0; $i < count($array_texte); $i++) {
					if (substr($texte, 0, 6) == '[link]') {
						if ($i % 2 == 0) {
							$texte = $texte . '<a class="linkk" target="_blank" href="http://' . $array_texte[$i] . '">' . $array_texte[$i] . '</a>';
						} else {
							$texte = $texte . $array_texte[$i];
						}
					} else {
						if ($i % 2 != 0) {
							$texte = $texte . '<a class="linkk" target="_blank" href="http://' . $array_texte[$i] . '">' . $array_texte[$i] . '</a>';
						} else {
							//$texte=$texte.htmlspecialchars($array_texte[$i]);
							$texte = $texte . $array_texte[$i];
						}
					}
				}
				break;

			case '2': /* Anula le tag [link]www.exemple.s[link] -> www.exemple.es i el filtra per caracters html */
				for ($i = 0; $i < count($array_texte); $i++) {
					$texte = $texte . $array_texte[$i];
				}
				//$texte=htmlspecialchars($texte);
				break;
		}
		return $texte;
	}

	public function posar_negretes($text, $tags)
	{
		if ($tags != '') {
			$paraules = explode(',', $tags);
			for ($i = 0; $i < count($paraules); $i++) {
				$paraules[$i] = trim($paraules[$i]);
				//$paraules[$i]=htmlspecialchars(trim($paraules[$i]));
				$text = str_replace($paraules[$i], '<span class="cursiva">' . $paraules[$i] . '</span>', $text);
			}
		}
		return $text;
	}
	public function timestamp_actual()
	{
		//$time=date('YmdHis');Y-m-d H:i:s
		$time = date('Y-m-d H:i:s');
		return ($time);
	}

	public function taula_a_timestamp($taula)
	{
		$data = $taula['any'] . $taula['mes'] . $taula['dia'] . $taula['hora'] . $taula['min'] . '00';
		return $data;
	}

	public function timestamp_a_taula($data)
	{
		$taula['any'] = substr($data, 0, 4);
		$taula['mes'] = substr($data, 5, 2);
		$taula['dia'] = substr($data, 8, 2);
		$taula['hora'] = substr($data, 11, 2);
		$taula['min'] = substr($data, 14, 2);
		return $taula;
	}

	public function timestamp_a_datahora($data)
	{
		$taula['any'] = substr($data, 0, 4);
		$taula['mes'] = substr($data, 5, 2);
		$taula['dia'] = substr($data, 8, 2);
		$taula['hora'] = substr($data, 11, 2);
		$taula['min'] = substr($data, 14, 2);
		return $taula['dia'] . '/' . $taula['mes'] . '/' . $taula['any'] . ' ' . $taula['hora'] . ':' . $taula['min'];
	}

	public function timestamp_a_data($data)
	{
		$taula['any'] = substr($data, 0, 4);
		$taula['mes'] = substr($data, 5, 2);
		$taula['dia'] = substr($data, 8, 2);
		$taula['hora'] = substr($data, 11, 2);
		$taula['min'] = substr($data, 14, 2);
		return $taula['dia'] . '/' . $taula['mes'] . '/' . $taula['any'];
	}

	public function timestamp_a_hora($data)
	{
		$taula['any'] = substr($data, 0, 4);
		$taula['mes'] = substr($data, 5, 2);
		$taula['dia'] = substr($data, 8, 2);
		$taula['hora'] = substr($data, 11, 2);
		$taula['min'] = substr($data, 14, 2);
		return $taula['hora'] . ':' . $taula['min'];
	}
}