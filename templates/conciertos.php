<?php

/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) {
	$bd = $basedades->__get('bd');
	$query = "select comptador_main from comptadors where seccio='gigs'";
	$resultat_consulta = $bd->query($query);
	if ($resultat_consulta != FALSE) {
		$resultat = $resultat_consulta->fetch_assoc();
		$vistes = $resultat['comptador_main'] + 1;
		$query = "update comptadors set comptador_main=$vistes where seccio='gigs'";
		$resultat_consulta = $bd->query($query);
		if ($resultat_consulta != FALSE) {
		}
	}
	$query = "select comptador_main from comptadors where seccio='gigs_dia'";
	$resultat_consulta = $bd->query($query);
	if ($resultat_consulta != FALSE) {
		$resultat = $resultat_consulta->fetch_assoc();
		$vistes = $resultat['comptador_main'] + 1;
		$query = "update comptadors set comptador_main=$vistes where seccio='gigs_dia'";
		$resultat_consulta = $bd->query($query);
		if ($resultat_consulta != FALSE) {
		}
	}
}
$basedades->desconectar();

?>
<div class="banner_main"> <!-- Banner principal 700 x 100-->
	<?php

	/*require('templates/banners/banner_main.php');*/
	$banner->visualitzar();

	?>
</div>
<?php
switch ($page->__get('concert_tipus')) {
	case 'normal':
		print '<div id="contenidor_concerts">
		        <div id="concerts_left">';

		print '<div class="tit400">';
		if ($page->leng == 'ES') {
			print '<p><a class="men" href="index.php?ln=ES&sec=conciertos&type=entradas">Conciertos</a></p>';
		} else {
			print '<p><a class="men" href="index.php?ln=CAT&sec=concerts&type=entradas">Concerts</a></p>';
		}
		print '</div>';

		/* Mostra 20 entrades endreçades per tipus i dateIn */
		$basedades->conectar();
		if (!$basedades->error_conexio) {
			$concerts->extreure_concerts_per_data_entrada($basedades->__get('bd'), $page->__get('punter'), $page->__get('quantitat_concerts_entrada'), $page->__get('concert_tipus'));
			$concerts->mostrar_resultats_per_data_entrada($basedades->__get('bd'), $page->__get('concert_tipus'), $page);
		}
		$basedades->desconectar();

		switch ($page->leng) {
			case 'ES':
				print '<a class="linkk" href="index.php?ln=ES&sec=conciertos&type=entradas&pnt=16">Más conciertos recomendados</a><br />';
				break;
			case 'CAT':
				print '<a class="linkk" href="index.php?ln=CAT&sec=concerts&type=entradas&pnt=16">Més concerts recomenats</a><br />';
				break;
		}
		print ' </div>
		        <div id="concerts_right">';

		print '<div class="tit300">';
		if ($page->leng == 'ES') {
			print '<p><a class="men" href="index.php?ln=ES&sec=conciertos&type=agenda">Agenda</a></p>';
		} else {
			print '<p><a class="men" href="index.php?ln=CAT&sec=concerts&type=agenda">Agenda</a></p>';
		}
		/* Mostra 20 entrades endreçades per tipus i dateIn */

		print '</div>';
		$basedades->conectar();
		if (!$basedades->error_conexio) {
			$concerts->extreure_concerts_per_data_concert($basedades->__get('bd'), $page->__get('punter'), $page->__get('quantitat_concerts_data'), $page->__get('concert_tipus'));
			$concerts->mostrar_resultats_per_data_concert($basedades->__get('bd'), $page->__get('concert_tipus'), $page);
		}
		$basedades->desconectar();
		switch ($page->leng) {
			case 'ES':
				print '<hr size="1" color="##660000" /><p align="right"><a class="linkk" href="index.php?ln=ES&sec=conciertos&type=agenda&pnt=26">Ver listado de conciertos</a></p><br />';
				break;
			case 'CAT':
				print '<p align="right"><a class="linkk" href="index.php?ln=CAT&sec=concerts&type=agenda&pnt=26"><br /><br />Veure llistat de concerts</a></p><br />';
				break;
		}
		print '</div>    		
				</div>';
		break;
	case 'entrada':
		print '<div id="entrada_concerts">';
		$basedades->conectar();
		if (!$basedades->error_conexio) {
			if ($concerts->extreure_concert_unic($basedades->__get('bd'), $page->__get('id'), $page->__get('leng'))) {
				$concerts->mostrar_resultat_concert_unic($page->__get('leng'));
			} else {
				print '<p>ERRRROOOOOORRRR</p>';
			}
		}
		$basedades->desconectar();

		print '</div>';

		break;
	case 'entradas':
		print '<div id="contenidor_concerts">
		        <div class="titdiscos">';

		if ($page->leng == 'ES') {
			print '<p>Conciertos</p>';
		} else {
			print '<p>Concerts</p>';
		}
		print '</div>';

		/* Mostra 20 entrades endreçades per tipus i dateIn */
		$basedades->conectar();
		if (!$basedades->error_conexio) {
			$concerts->extreure_concerts_per_data_entrada($basedades->__get('bd'), $page->__get('punter'), $page->__get('quantitat_concerts_entrada'), $page->__get('concert_tipus'));
			$concerts->mostrar_resultats_per_data_entrada($basedades->__get('bd'), $page->__get('concert_tipus'), $page);
		}
		$query = "select idGig from concerts";
		$resultat = $basedades->bd->query($query);
		if ($resultat != FALSE) {
			$numero = $resultat->num_rows;
			$page->navegador($numero, $page->quantitat_concerts_entrada);
		}
		$basedades->desconectar();


		print ' </div>';
		break;
	case 'agenda':
		print '<div class="titdiscos">';
		if ($page->leng == 'ES') {
			print '<p>Agenda</p>';
		} else {
			print '<p>Agenda</p>';
		}
		/* Mostra 20 entrades endreçades per tipus i dateIn */

		print '</div>';
		$basedades->conectar();
		if (!$basedades->error_conexio) {
			$concerts->extreure_concerts_per_data_concert($basedades->__get('bd'), $page->__get('punter'), $page->__get('quantitat_concerts_data'), $page->__get('concert_tipus'));
			$concerts->mostrar_resultats_per_data_concert($basedades->__get('bd'), $page->__get('concert_tipus'), $page);
		}
		$query = "select idGig from concertsdata";
		$resultat = $basedades->bd->query($query);
		if ($resultat != FALSE) {
			$numero = $resultat->num_rows;
			$page->navegador($numero, $page->quantitat_concerts_data);
		}
		$basedades->desconectar();


		break;

}
?>

<div class="banner_main"> <!-- Banner principal 700 x 100-->
	<?php

	/*require('templates/banners/banner_main.php');*/
	$banner->visualitzar();

	?>
</div>