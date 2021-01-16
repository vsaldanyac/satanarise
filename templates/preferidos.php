<?php
$preferidos_web = new ob_preferidos_web;
	
?>
    	<div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
    	
		$banner->visualitzar();
		
?>
    	</div>
<?php
        switch ($page->__get('preferidos_tipus'))
		{
			case 'main':
                print '<div class="titdiscos">'; //<!-- Titol de discos -->
                if ($page->leng=='ES')
                {
                    print '<p>Críticas</p>';
                } else {
                    print '<p>Crítiques</p>';
                }
                print '</div>';
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    $preferidos_web->extreure_preferidos_per_data_entrada($basedades->__get('bd'),$page->__get('punter'),$page->__get('quantitat_preferidos'));
                    $preferidos_web->mostrar_preferidos_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
                    $query="select idpreferidos from preferidos";
				    $resultat=$basedades->bd->query($query);
    				if ($resultat!=FALSE) 
	   	       		{
	   	   	           $numero=$resultat->num_rows;
	   				   $page->navegador($numero,$page->quantitat_preferidos);
                    }
                 }
				$basedades->desconectar();            
                
            break;
            case 'entrada':
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    if ($preferidos_web->extreure_review_unica($basedades->__get('bd'),$page->id,$page->leng))
                    {
                        $preferidos_web->mostrar_review_unica($page->__get('leng'),$basedades->__get('bd'));
                        $preferidos_web->afegir_visita($basedades->__get('bd'),$page->id);
                    }
                }
				$basedades->desconectar();
            
            break;
            case 'all':
                $basedades->conectar();
				if (!$basedades->error_conexio) 
				{ 
                    if ($preferidos_web->extreure_historic($basedades->__get('bd')))
                    {
                        $preferidos_web->mostrar_historic($page->__get('leng'));                        
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