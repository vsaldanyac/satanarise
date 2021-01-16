<?php
$cronicas_web = new ob_cronicas_web;
	
/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) 
{ 
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='chronicles'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='chronicles'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    $query="select comptador_main from comptadors where seccio='chronicles_dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='chronicles_dia'";
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
    switch ($page->__get('cronica_tipus'))
		{
			case 'main':
      	print '<div class="titdiscos">'; //<!-- Titol de discos -->
      	if ($page->leng=='ES')
      	{
      	    print '<p>Crónicas de conciertos</p>';
      	} else {
      	    print '<p>Crónicas de conciertos</p>';
      	}
      	print '</div>';
      	
      	$basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
           $cronicas_web->extreure_cronicas_per_data_entrada($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_croniques'),$page->__get('leng'));
           $cronicas_web->mostrar_cronicas_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
           switch ($page->leng)
           {
               case 'ES':
                   $query="select idcronicas from cronicas where idioma = 'ES' or idioma = 'BOTH'";
               break;                        
               case 'CAT':
                   $query="select idcronicas from cronicas where idioma = 'CAT' or idioma = 'BOTH'";
               break;
           }                    
				   $resultat=$basedades->bd->query($query);
				   if ($resultat!=FALSE) 
	   	     {
	   	   	 		$numero=$resultat->num_rows;                       
	   				  $page->navegador($numero,$page->quantitat_croniques);
           }
        }
				$basedades->desconectar();                   
         break;
         case 'entrada':
         		$basedades->conectar();
						if (!$basedades->error_conexio) 
						{ 
            		if ($cronicas_web->extreure_cronica_unica($basedades->__get('bd'),$page->id,$page->leng))
                {                       
                	$cronicas_web->mostrar_cronica_unica($page->__get('leng'),$basedades->__get('bd'));
                  $cronicas_web->afegir_visita($basedades->__get('bd'),$page->id);                        
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