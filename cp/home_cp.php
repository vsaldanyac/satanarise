<?php
ob_start(); /* Buffer de sortida on */
session_start();
if (isset ($_SESSION['valid_user']))
{

    require('../sources/ob_cp.php'); /* afegir declaracio d'objetctes */
    require('../sources/ob_bbdd.php'); /* afegir declaracio d'objetctes */
    $page = new ob_cp;
    $basedades = new ob_bbdd;
    
    
    /* captar parametres */
    if (isset($_GET)) $page->get_param($_GET);
    
    /* carrega top.php - Menu i control de capçaleres */
    require ('templates/top.php');
    switch ($page->section){
    	case ('inicio'):
    		require ('templates/inici.php');
    	break;	
    	case ('opinion'):
    		require ('templates/opinio.php');
    	break;	
        case ('carta'):
    		require ('templates/carta.php');
    	break;
    	case ('criticas'):
    		require ('templates/reviews.php');
    	break;
    	case ('conciertos'):
    		require ('templates/conciertos.php');
    	break;
    	case ('cronicas'):
    		require ('templates/cronicas.php');
    	break;
    	case ('entrevistas'):
    		require ('templates/entrevistes.php');
    	break;
        case ('entrevistasn'):
    		require ('templates/entrevnews.php');
    	break;
    	case ('noticias'):
    		require ('templates/noticias.php');
    	break;
        case ('colaboradores'):
			require ('templates/colaboradors.php');
		break;	
        case ('usuarios'):
			require ('templates/users.php');
		break;
    }
    require('templates/end.php');
    
    /* obrir buffer */
    ob_end_flush();
} else {
	ob_clean();
	header('Location: index_cp.php');
	exit();
}    
?>
