<?php
function convertir_cadena_arxiu($cadena)
{
	$cadena=strtolower($cadena);
	$cadena=str_replace('á','a',$cadena);
	$cadena=str_replace('à','a',$cadena);
	$cadena=str_replace('ä','a',$cadena);
	$cadena=str_replace('â','a',$cadena);
	$cadena=str_replace('é','e',$cadena);
	$cadena=str_replace('è','e',$cadena);
	$cadena=str_replace('ë','e',$cadena);
	$cadena=str_replace('ê','e',$cadena);
	$cadena=str_replace('í','i',$cadena);
	$cadena=str_replace('ì','i',$cadena);
	$cadena=str_replace('ï','i',$cadena);
	$cadena=str_replace('î','i',$cadena);
	$cadena=str_replace('ó','o',$cadena);
	$cadena=str_replace('ò','o',$cadena);
	$cadena=str_replace('ö','o',$cadena);
	$cadena=str_replace('ô','o',$cadena);
	$cadena=str_replace('ú','u',$cadena);
	$cadena=str_replace('ù','u',$cadena);
	$cadena=str_replace('ü','u',$cadena);
	$cadena=str_replace('û','u',$cadena);
	$cadena=str_replace('ñ','n',$cadena);
	$cadena=str_replace('-','',$cadena);
	$cadena=str_replace('\'','',$cadena);
	$cadena=str_replace('.','',$cadena);
	$cadena=str_replace(',','',$cadena);
	$cadena=str_replace(' ','',$cadena);
	$cadena=str_replace('ç','c',$cadena);
	$cadena=str_replace('?','',$cadena);
	$cadena=str_replace('¡','',$cadena);
	$cadena=str_replace('!','',$cadena);
	$cadena=str_replace('¿','',$cadena);
    $cadena=str_replace('-','',$cadena);
    $cadena=str_replace('(','',$cadena);
    $cadena=str_replace(')','',$cadena);
    $cadena=str_replace('/','',$cadena);
    $cadena=str_replace('+','',$cadena);
	return $cadena;
	
}

?>