<?php
ob_start(); /* Buffer de sortida on */

require('sources/ob_page.php'); /* afegir declaracio d'objetctes */
require('sources/ob_bbdd.php'); /* afegir declaracio d'objetctes */
require('sources/ob_noticias_web.php');
require('sources/ob_noticia.php');
require('sources/ob_conciertos_web.php');
require('sources/ob_concerts.php');
require('sources/ob_reviews_web.php');
require('sources/ob_reviews.php');
require('sources/ob_entrevistes_web.php');
require('sources/ob_entrevistes.php');
require('sources/ob_opinio_web.php');
require('sources/ob_opinio.php');
require('sources/ob_cronicas_web.php');
require('sources/ob_cronicas.php');


	
$noticies = new ob_noticias_web;
$concerts = new ob_conciertos_web;
$page = new ob_page;
$basedades = new ob_bbdd;
$banner = new banner_700;
$banner100 = new banner_100;


/* captar parametres */
if (isset($_GET)) $page->get_param($_GET,$basedades);

/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) 
{ 
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='main'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        if (fmod($vistes, 1000) == 0)        
        {
            $mensaje="Hem arribat a $vistes";
            mail('info@satanarise.com', 'Nou maxim de visites', $mensaje);
        } 
        $query="update comptadors set comptador_main=$vistes where seccio='main'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
}
$basedades->desconectar();

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
		require ('templates/reviews.php');
	break;
	case ('critiques'):
		require ('templates/reviews.php');
	break;
	case ('concerts'):
		require ('templates/conciertos.php');
	break;
	case ('conciertos'):
		require ('templates/conciertos.php');
	break;
	case ('cronicas'):
		require ('templates/croniques.php');
	break;
	case ('croniques'):
		require ('templates/croniques.php');
	break;
	case ('entrevistes'):
		require ('templates/entrevistes.php');
	break;
	case ('entrevistas'):
		require ('templates/entrevistes.php');
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
	case ('concurso'):
		require ('templates/concursos.php');
	break;
	case ('concurs'):
		require ('templates/concursos.php');
	break;
    case ('pagina'):
		require ('templates/pagina.php');
	break;
    case ('opinio'):
		require ('templates/opinio.php');
	break;
    case ('opinion'):
		require ('templates/opinio.php');
	break;
}
require('templates/end.php');

/* obrir buffer */
ob_end_flush();
?>