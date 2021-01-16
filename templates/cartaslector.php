<?php
$carta_web = new ob_carta_web;
	
/* afeigeix visita */
$basedades->conectar();
if (!$basedades->error_conexio) 
{ 
    $bd=$basedades->__get('bd');
	$query="select comptador_main from comptadors where seccio='carta'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='carta'";
        $resultat_consulta=$bd->query($query);
        if ($resultat_consulta!=FALSE) 
	    {}
    }
    $query="select comptador_main from comptadors where seccio='carta_dia'";	
	$resultat_consulta=$bd->query($query);
	if ($resultat_consulta!=FALSE) 
	{
		$resultat=$resultat_consulta->fetch_assoc();
        $vistes=$resultat['comptador_main']+1;
        $query="update comptadors set comptador_main=$vistes where seccio='carta_dia'";
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
        switch ($page->__get('carta_tipus'))
		{
			case 'main':
                print '<div class="titdiscos">'; //<!-- Titol de discos -->
                if ($page->leng=='ES')
                {
                    print '<p>Cartas Del Lector</p>';
                } else {
                    print "<p>Cartes Del Lector</p>";
                }
                print '</div>';

                
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    $carta_web->extreure_carta_per_data_entrada($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_carta'),$page->__get('leng'));
                    $carta_web->mostrar_carta_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
                    switch ($page->leng)
                    {
                        case 'ES':
                            $query="select idcarta from carta where idioma = 'ES' or idioma = 'BOTH'";
                        break;                        
                        case 'CAT':
                            $query="select idcarta from carta where idioma = 'CAT' or idioma = 'BOTH'";
                        break;
                    }
				    $resultat=$basedades->bd->query($query);
    				if ($resultat!=FALSE) 
	   	       		{
	   	   	           $numero=$resultat->num_rows;
	   				   $page->navegador($numero,$page->quantitat_carta);
                    }
                 }
				$basedades->desconectar();            
                
            break;
            case 'entrada':
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    if ($carta_web->extreure_carta_unica($basedades->__get('bd'),$page->id,$page->leng))
                    {
                        $carta_web->mostrar_carta_unica($page->__get('leng'),$basedades->__get('bd'));
                        $carta_web->afegir_visita($basedades->__get('bd'),$page->id);
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