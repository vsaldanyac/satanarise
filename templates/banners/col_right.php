
<?php
    if ($page->section=='critiques')
    {
        print '<div id="archivo">
        	<p><a class="men" href="index.php?ln=CAT&sec=critiques&type=all">Arxiu de<br /> novetats</a></p>
        </div>';
    }
    if ($page->section=='criticas')
    {
        print '<div id="archivo">
        	<p><a class="men" href="index.php?ln=ES&sec=criticas&type=all">Archivo de novedades</a></p>
        </div>';
    }
    if (($page->section=='inicio')||($page->section=='inicio'))
    {
?>
    
     <!--<script type="text/javascript" src="http://www.tusencuestas.com/Acciones/tusencuestas.aspx?0-48540-0-0-1f02b85f_06fc_4d87_9e0e_b8833c75a2da-0-0"></script>-->
    
<?php
    }
    $banner100->visualitzar();
    // SPECIAL METAL REPORT
    print '<a class="men" href="index.php?ln=ES&sec=opinion"><img  src="pics/containers/tit_metal_report.jpg" width="100"/></a>'; 
    $opinio_web = new ob_opinio_web;
    $basedades->conectar();
    if (!$basedades->error_conexio) 
	{ 
        $opinio_web->extreure_opinio_per_data_entrada_special($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_entrevistes'),$page->__get('leng'));
        $opinio_web->mostrar_opinio_per_data_entrada_lateral_special($basedades->__get('bd'),$page->__get('leng'));
    // ROCK EN RUOL TALES
    print '<a class="men" href="index.php?ln=ES&sec=entrevistasn"><img  src="pics/containers/tit_entr_news.jpg" width="100"/></a>'; 
    $entrevistes_web = new ob_entrevnews_web;
	
        $entrevistes_web->extreure_entrevistes_per_data_entrada($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_entrevistes'),$page->__get('leng'));
        $entrevistes_web->mostrar_entrevistes_per_data_entrada_lateral($basedades->__get('bd'),$page->__get('leng'));
        switch ($page->leng)
        {
            case 'ES':
               $query="select identrevistes from entrevnews where idioma = 'ES' or idioma = 'BOTH'";
            break;                        
            case 'CAT':
                $query="select identrevistes from entrevnews where idioma = 'CAT' or idioma = 'BOTH'";
            break;
        }
		$resultat=$basedades->bd->query($query);
    	if ($resultat!=FALSE) 
	   	{
	   		$numero=$resultat->num_rows;
	   		$page->navegador($numero,$page->quantitat_entrevistes);
        }
     }
	$basedades->desconectar();  
?>