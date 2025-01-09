<?php
$opinio_web = new ob_opinio_web;
	
/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) 
{ 
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='opinion'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='opinion'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    $query="select comptador_main from comptadors where seccio='opinion_dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='opinion_dia'";
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
        switch ($page->__get('opinio_tipus'))
		{
			case 'main':
                print '<div class="titdiscos">'; //<!-- Titol de discos -->
                
                print '<p>Metal Report</p>';
                
                print '</div>';
                
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    $opinio_web->extreure_opinio_per_data_entrada($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_entrevistes'),$page->__get('leng'));
                    $opinio_web->mostrar_opinio_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
                    switch ($page->leng)
                    {
                        case 'ES':
                            $query="select idopinio from opinio where idioma = 'ES' or idioma = 'BOTH'";
                        break;                        
                        case 'CAT':
                            $query="select idopinio from opinio where idioma = 'CAT' or idioma = 'BOTH'";
                        break;
                    }
				    $resultat=$basedades->bd->query($query);
    				if ($resultat!=FALSE) 
	   	       		{
	   	   	           $numero=$resultat->num_rows;
	   				   $page->navegador($numero,$page->quantitat_opinio);
                    }
                 }
				$basedades->desconectar();            
                
            break;
            case 'entrada':
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    if ($opinio_web->extreure_opinio_unica($basedades->__get('bd'),$page->id,$page->leng))
                    {
                        $opinio_web->mostrar_opinio_unica($page->__get('leng'),$basedades->__get('bd'));
                        $opinio_web->afegir_visita($basedades->__get('bd'),$page->id);
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