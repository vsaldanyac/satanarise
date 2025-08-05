<?php
$reviews_web = new ob_reviews_web;
	
/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) 
{ 
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='reviews'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='reviews'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    $query="select comptador_main from comptadors where seccio='reviews_dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='reviews_dia'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
}
$basedades->desconectar();
?>
    	<div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
    	
		$banner->visualitzar();
		
?>
    	</div>
<?php
        switch ($page->__get('reviews_tipus'))
		{
			case 'main':
                print '<div class="titdiscos">'; //<!-- Titol de discos -->
                if ($page->leng=='ES')
                {
                    print '<p id="criticas-marker">Críticas</p>';
                } else {
                    print '<p id="criticas-marker">Crítiques</p>';
                }
                print '</div>';
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    $reviews_web->extreure_reviews_per_data_entrada($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_reviews'));
                    $reviews_web->mostrar_reviews_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
                    $query="select idreviews from reviews";
				    $resultat=$basedades->bd->query($query);
    				if ($resultat!=FALSE) 
	   	       		{
	   	   	           $numero=$resultat->num_rows;
	   				   $page->navegador($numero,$page->quantitat_reviews);
                    }
                 }
				$basedades->desconectar();            
                
            break;
            case 'entrada':
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    if ($reviews_web->extreure_review_unica($basedades->__get('bd'),$page->id,$page->leng))
                    {
                        $reviews_web->mostrar_review_unica($page->__get('leng'),$basedades->__get('bd'));
                        $reviews_web->afegir_visita($basedades->__get('bd'),$page->id);
                    }
                }
				$basedades->desconectar();
            
            break;
            case 'all':
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    if ($reviews_web->extreure_historic($basedades->__get('bd')))
                    {
                        $reviews_web->mostrar_historic($page->__get('leng'));                        
                    }
                }
				$basedades->desconectar();
            
            break;
        }
                //--------------------------------------------------------------------------------------------------------------------------------
                
				
?>		

        <div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php

    	/*require('templates/banners/banner_main.php');*/
		$banner->visualitzar();
		
?>
    	</div>