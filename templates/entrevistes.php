<?php
$entrevistes_web = new ob_entrevistes_web;
	
/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) 
{ 
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='interviews'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='interviews'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    $query="select comptador_main from comptadors where seccio='interviews_dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='interviews_dia'";
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
    switch ($page->__get('entrevista_tipus'))
		{
			case 'main':
      	print '<div class="titdiscos">'; //<!-- Titol de discos -->
      	if ($page->leng=='ES')
      	{
      	    print '<p>Entrevistas</p>';
      	}
      	else 
      	{
      	    print '<p>Entrevistes</p>';
      	}
      	print '</div>';
      	
      	$basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
        	$entrevistes_web->extreure_entrevistes_per_data_entrada($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_entrevistes'),$page->__get('leng'));
        	$entrevistes_web->mostrar_entrevistes_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
        	switch ($page->leng)
        	{
        	    case 'ES':
        	        $query="select identrevistes from entrevistes where idioma = 'ES' or idioma = 'BOTH'";
        	    break;                        
        	    case 'CAT':
        	        $query="select identrevistes from entrevistes where idioma = 'CAT' or idioma = 'BOTH'";
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
                
        break;
        case 'entrada':
        	$basedades->conectar();
					if (!$basedades->error_conexio) 
					{ 
          	if ($entrevistes_web->extreure_entrevista_unica($basedades->__get('bd'),$page->id,$page->leng))
            {
            	$entrevistes_web->mostrar_entrevista_unica($page->__get('leng'),$basedades->__get('bd'));
              $entrevistes_web->afegir_visita($basedades->__get('bd'),$page->id);
            }
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