<?php

/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) 
{ 
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='news'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='news'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    $query="select comptador_main from comptadors where seccio='news_dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='news_dia'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
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

	if (($page->id!='') && ($page->noticia!=''))
	/*noticia única*/
	{
		print '<div id="contenidor_noticies">';    

		$basedades->conectar();
		if (!$basedades->error_conexio) 
		{ 
			if ($noticies->extreure_noticia($basedades->bd,$page->id,$page->leng))
			{
				$noticia = new ob_noticia;
				$noticies->estructurar_noticia($noticia,$basedades->bd,'individual');
			} else {
				print '<h1 class="tit_centrada">Error al mostrar la noticia</h1>';
			}
			$basedades->desconectar();
		}
		print '</div>'; /* fi contenidor_noticies */	
	} else {
				
	/* noticies normals */

		print '<div class="titdiscos"> <!-- Titol de discos -->';
		if ($page->leng=='ES') {
			print '<p>Noticias</p>';
		} else {
			print '<p>Noticies</p>';
		}         
		print '</div>
		<div id="contenidor_noticies">';    
		
		$basedades->conectar();
		if (!$basedades->error_conexio) 
		{ 
			$noticies->extreure_noticies($basedades->bd,$page->leng,$page->punter,$page->quantitat);
			$noticia = new ob_noticia;
			$noticies->estructurar_noticia($noticia,$basedades->bd,'noticies');
			$query="select news.idNews from news, newscontent where newscontent.Idioma = '".$page->leng."' and news.idNews = newscontent.IdNews";
			$resultat=$basedades->bd->query($query);
			if ($resultat!=FALSE) 
			{
				$numero=$resultat->num_rows;
				$page->navegador($numero,$page->quantitat);
			}
			$basedades->desconectar();
		}
		print '</div>'; /* fi contenidor_noticies */	
	}
?>
        <div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php

    	/*require('templates/banners/banner_main.php');*/
		$banner->visualitzar();
		
?>
    	</div>