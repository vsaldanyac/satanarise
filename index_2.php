<?php
ob_start(); /* Buffer de sortida on */

require('sources/ob_page.php'); /* afegir declaracio d'objetctes */
require('sources/ob_bbdd.php'); /* afegir declaracio d'objetctes */
require('sources/ob_noticias_web.php');
require('sources/ob_noticia.php');
require('sources/ob_conciertos_web.php');
require('sources/ob_concerts.php');

	
$noticies = new ob_noticias_web;
$concerts = new ob_conciertos_web;
$page = new ob_page;
$basedades = new ob_bbdd;
$banner = new banner_700;

/* captar parametres */
if (isset($_GET)) $page->get_param($_GET,$basedades);

/* carrega top.php - Menu i control de capçaleres */
require ('templates/top.php');
switch ($page->section){
	case ('inici'):
		require ('templates/inici.php');
	break;
	case ('inicio'):
		require ('templates/inici.php');
	break;	
	case ('criticas'):
		/*require ('templates/reviews.php');*/
		ob_clean();
		header ('location: novedades.html');
		exit();
	break;
	case ('critiques'):
		/*require ('templates/reviews.php');*/
		ob_clean();
		header ('location: novedades_cat.html');
		exit();
	break;
	case ('concerts'):
		require ('templates/conciertos.php');
	break;
	case ('conciertos'):
		require ('templates/conciertos.php');
	break;
	case ('cronicas'):
		/*require ('templates/croniques.php');*/
		ob_clean();
		header ('location: es/conciertos/conciertos.html');
		exit();
	break;
	case ('croniques'):
		/*require ('templates/croniques.php');*/
		ob_clean();
		header ('location: cat/conciertos/conciertos.html');
		exit();
	break;
	case ('entrevistes'):
		/*require ('templates/entrevistes.php');*/
		ob_clean();
		header ('location: cat/entrevistas/entrevistas.html');
		exit();
	break;
	case ('entrevistas'):
		/*require ('templates/entrevistes.php');*/
		ob_clean();
		header ('location: es/entrevistas/entrevistas.html');
		exit();
	break;
	case ('contacto'):
		require ('templates/contacte.php');
	break;
	case ('contacte'):
		require ('templates/contacte.php');
	break;	
	case ('noticias'):
		require ('templates/noticias.php');
	break;	
	case ('noticies'):
		require ('templates/noticias.php');
	break;	
}
require('templates/end.php');

/* obrir buffer */
ob_end_flush();
?>