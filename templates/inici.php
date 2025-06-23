
    	<div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php

    	/*require('templates/banners/banner_main.php');*/
		$banner->visualitzar();
		
?>
    	</div>
        <!-- ------------------------------------- N O T I C I A S ---------------------------------------------------------------- -->

        <div class="titdiscos">
            
<?php
    if ($page->leng=='ES') {
        print '<p><a class="men" href="index.php?ln=ES&sec=noticias#noticias-marker">Más noticias...</a></p>';
    } else {
        print '<p><a class="men" href="index.php?ln=CAT&sec=noticies#noticias-marker">Més noticies...</a></p>';
    }   
?>   
        </div>
<?php
        require('templates/noticies_index.php');
?>




        <!-- ---------------------------------------------------------------------------------------------------------------- -->
        <div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
        //require('templates/banners/banner_main.php');
        $banner->visualitzar();
?>
        </div>
        <!-- -------------------------------------------N O V E D A D E S --------------------------------------------------- -->
    	<div class="titdiscos"> <!-- Titol de discos -->
    		
<?php
	if ($page->leng=='ES') {
		print '<p><a class="men" href="index.php?ln=ES&sec=criticas">Críticas</a></p>';
	} else {
		print '<p><a class="men" href="index.php?ln=CAT&sec=critiques">Crítiques</a></p>';
	}            
?>        	
        </div>
        <!-- ---------------------------------------------------------------------------------------------------------------- -->
		<div id="contdiscos">
<?php
        $reviews_web = new ob_reviews_web;
		$basedades->conectar();
		if (!$basedades->error_conexio) 
		{ 
            $reviews_web->extreure_reviews_per_data_entrada($basedades->__get('bd'),1,10);
            $reviews_web->mostrar_reviews_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
        }
	   $basedades->desconectar(); 
?>
        </div>
        <!-- ---------------------------------------------------------------------------------------------------------------- -->
        <div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
    	//require('templates/banners/banner_main.php');
		$banner->visualitzar();
?>
    	</div>
		
                
       <!-- -------------------------------------------E N T R E V I S T E S --------------------------------------------------- -->

		<div class="titdiscos">
<?php
        if ($page->leng=='ES') {
            print '<p><a class="men" href="index.php?ln=ES&sec=entrevistas">Entrevistas</a></p>';
        } else {
            print '<p><a class="men" href="index.php?ln=CAT&sec=entrevistes">Entrevistes</a></p>';
        }            
?>  			
        </div>
        <!-- -------------------------------------------------------------------------------------------------------------------- -->
        <div id="content">

<?php
        $entrevistes_web = new ob_entrevistes_web;
		$basedades->conectar();
		if (!$basedades->error_conexio) 
		{ 
            $entrevistes_web->extreure_entrevistes_per_data_entrada($basedades->__get('bd'),1,6,$page->leng);
            $entrevistes_web->mostrar_entrevistes_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
        }
	   $basedades->desconectar(); 
                 
		
?>        
        </div>
        <!-- --------------------------------------B A N N E R    M I D D L E --------------------------------------------------- -->
        <div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
    	/*require('templates/banners/banner_main.php');*/
		$banner->visualitzar();
?>
		</div>
		<!-- ------------------------------------- C O N C I E R T O S ---------------------------------------------------------------- -->
        <div class="titdiscos">
        	
<?php
	if ($page->leng=='ES') {
		print '<p> <a class="men" href="index.php?ln=ES&sec=cronicas" title="Crónicas">Crónicas de Conciertos</a></p>';
	} else {
		print '<p> <a class="men" href="index.php?ln=CAT&sec=entrevistas" title="Cròniques">Cròniques de concerts</a></p>';
	}
?>	              
        </div>
        <!-- ---------------------------------------------------------------------------------------------------------------- -->
<?php
		$cronicas_web = new ob_cronicas_web;
		$basedades->conectar();
		if (!$basedades->error_conexio) 
		{ 
            $cronicas_web->extreure_cronicas_per_data_entrada($basedades->__get('bd'),1,6,$page->leng);
            $cronicas_web->mostrar_cronicas_per_data_entrada($basedades->__get('bd'),$page->__get('leng'));
        }
	   $basedades->desconectar(); 
?>                
        <!-- --------------------------------------B A N N E R    M I D D L E --------------------------------------------------- -->
        <div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
    	/*require('templates/banners/banner_main.php');*/
		$banner->visualitzar();
?>
		</div>
		<!-- ---------------------- C O N C I E R T O S    R E C O M E N D A D O S--------------------------------------------- -->
  <div class="titdiscos">
<?php
	if ($page->leng=='ES') {
		print '<p> <a class="men" href="index.php?ln=ES&sec=conciertos" title="Próximos conciertos">Próximos conciertos</a></p>';
	} else {
		print '<p> <a class="men" href="index.php?ln=CAT&sec=concerts" title="Propers concerts">Propers concerts</a></p>';
	}
?>	  
  </div>
        <!-- --------------------------------------------------------------------------------------------------------------------- -->
	<?php
			require('templates/conciertos_index.php');
	?>        
	
