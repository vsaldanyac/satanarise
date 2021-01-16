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
require('sources/ob_entrevnews_web.php');
require('sources/ob_entrevistes.php');
require('sources/ob_entrevnews.php');
require('sources/ob_opinio_web.php');
require('sources/ob_carta_web.php');
require('sources/ob_opinio.php');
require('sources/ob_carta.php');
require('sources/ob_cronicas_web.php');
require('sources/ob_cronicas.php');
require('sources/ob_preferidos.php');
require('sources/ob_preferidos_web.php');


	
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
    /* controlem visites diaries */
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $dia_bbdd=$resultat['comptador_main'];
        $dia=date("j");
        if ($dia_bbdd != $dia)       
        {
            $tit="Informe visites web del ".date('d/m/y');
            $query="select comptador_main from comptadors where seccio='main_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['main']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='main_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='news_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['news']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='news_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='interviews_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['interviews']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='interviews_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='reviews_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['reviews']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='reviews_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='chronicles_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['chronicles']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='chronicles_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='gigs_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['gigs']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='gigs_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='opinion_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['opinion']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='opinion_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='carta_dia'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['carta']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='carta_dia'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select texte, contador from banners order by tipo desc";
            $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
	            $numero=$resultat_consulta->num_rows;
                $b="\nEls banners tenen les seguents visites: \n\n";
                for ($x=0;$x<$numero;$x++)
                {
                    $resultat=$resultat_consulta->fetch_assoc();
                    $b=$b.$resultat['texte']." porta ".$resultat['contador']." clicks,\n";
                }
                
            }
            $mensaje="Bon dia a la vila del pingui!!!\n\nVistes del dia: ".$v['main']."\nVistes news: ".$v['news']."\nVistes reviews: ".$v['reviews']."\nVistes croniques: ".$v['chronicles']."\nVistes entrevistes: ".$v['interviews']."\nVistes concerts: ".$v['gigs']."\nVistes opinio: ".$v['opinion']."\nVistes cartes: ".$v['carta']."\n".$b."\nFins dema!";
            $cab = 'From: info@satanarise.com';
            mail('info@satanarise.com',$tit , $mensaje, $cab);
            $query="update comptadors set comptador_main=$dia where seccio='dia'";
            $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	    {}
        }
         
        
    }$query="select comptador_main from comptadors where seccio='mes'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $dia_bbdd=$resultat['comptador_main'];
        $dia=date("n");
        if ($dia_bbdd != $dia)       
        {
            $tit="Informe visites web del ".date('d/m/y');
            $query="select comptador_main from comptadors where seccio='main'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['main']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='main'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='news'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['news']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='news'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='interviews'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['interviews']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='interviews'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='reviews'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['reviews']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='reviews'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='chronicles'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['chronicles']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='chronicles'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='gigs'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['gigs']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='gigs'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='opinion'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['opinion']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='opinion'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            $query="select comptador_main from comptadors where seccio='carta'";	
	        $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	        {
                $resultat=$resultat_consulta->fetch_assoc();
                $v['carta']=$resultat['comptador_main'];
                $query="update comptadors set comptador_main=0 where seccio='carta'";
                $resultat_consulta=$bd->query($query);
                if ($resultat_consulta!=FALSE) 
	            {}
            }
            
            $mensaje="Bon mes a la vila del ornitorrinc!!!\n\nVistes del mes: ".$v['main']."\nVistes news: ".$v['news']."\nVistes reviews: ".$v['reviews']."\nVistes entrevistes: ".$v['interviews']."\nVistes croniques: ".$v['chronicles']."\nVistes concerts: ".$v['gigs']."\nVistes opinio: ".$v['opinion']."\nVistes cartes: ".$v['carta']."\n".$b."\nFins el mes que ve!";
            $cab = 'From: info@satanarise.com';
            mail('info@satanarise.com',$tit , $mensaje, $cab);
            $query="update comptadors set comptador_main=$dia where seccio='mes'";
            $resultat_consulta=$bd->query($query);
            if ($resultat_consulta!=FALSE) 
	    {}
        }
         
        
    }
    
	$query="select comptador_main from comptadors where seccio='main'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        if (fmod($vistes, 1000) == 0)        
        {
            $mensaje="Hem arribat a $vistes\n\n Fins les mil visites seguents!";
            $cab = 'From: info@satanarise.com';
            mail('info@satanarise.com', 'Informe de nova fita de visites', $mensaje, $cab);
        } 
        $query="update comptadors set comptador_main=$vistes where seccio='main'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    $query="select comptador_main from comptadors where seccio='main_dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;         
        $query="update comptadors set comptador_main=$vistes where seccio='main_dia'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    
    
}
/* omple els banners */

    $banner100->omplir($basedades->__get('bd'));
    $banner->omplir($basedades->__get('bd'));
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
    case ('entrevistesn'):
		require ('templates/entrevnews.php');
	break;
	case ('entrevistasn'):
		require ('templates/entrevnews.php');
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
    case ('cartaslector'):
		require ('templates/cartaslector.php');
	break;
    case ('carteslector'):
		require ('templates/cartaslector.php');
	break;
    case ('preferidos'):
		require ('templates/preferidos.php');
	break;
    case ('preferits'):
		require ('templates/preferidos.php');
	break;
}
require('templates/end.php');

/* obrir buffer */
ob_end_flush();
?>