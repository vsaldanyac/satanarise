	
<?php
	print '<div id="contnot">';
	$basedades->conectar();
	if (!$basedades->error_conexio) 
	{ 
		$noticies->extreure_noticies($basedades->bd,$page->leng,1,12);
		$noticia = new ob_noticia;
		$noticies->estructurar_noticia($noticia,$basedades->bd,'index');
	
		$basedades->desconectar();
	}
	print '</div>';
	
?>
	