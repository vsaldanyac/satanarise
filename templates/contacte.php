<div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
    	require('sources/ob_colaboradors_web.php');
        require('sources/ob_colaboradors.php');
        
        $colaboradors_web = new ob_colaboradors_web;
        $colaborador = new ob_colaboradors;
        $basedades->conectar();
		$banner->visualitzar();
?>
    	</div>
<?php
	if ($page->leng=='ES') {
?>

    
    	<div class="titdiscos"> <!-- Titol de discos -->
        	<p>Acerca de Satan Arise</p>
        </div>
        
        <h1>
        	Satan Arise es un portal que pretende dar a conocer novedades y bandas de Metal sin tener enlaces de descarga que no sean consentidos y pactados con el grupo. 
Especialmente a los grupos jóvenes se les da la oportunidad de dar a conocer su disco o maqueta, hacer una pequeña entrevista e incluso llegar a poner banners publicitarios.
        </h1>
        <h1><span class="vermell">Críticas:</span> Si quieres contactar con Satan Arise para hacernos llegar un disco para su revisión ponte en contacto con nosotros envíando un mail a <a class="linkk" href="mailto:info@satanarise.com">info@satanarise.com</a>.</h1>
        <h1><span class="vermell">Conciertos:</span> Si quieres comunicarnos la celebración de un concierto para que aparezca como concierto recomendado envíanos el cartel y la información a <a class="linkk" href="mailto:info@satanarise.com">info@satanarise.com</a>. Debido a la gran cantidad de conciertos y bandas existentes es imposible seguir todos los conciertos que se realizan, por ello debereis enviarnos siempre el cartel y la información correspondiente para que sea publicada.</h1>
        <h1><span class="vermell">Noticias:</span> Para mandarnos noticias que creeis que deban ser publicadas en Satan Arise podeis enviarlas a <a class="linkk" href="mailto:news@satanarise.com">news@satanarise.com</a></h1>
        
        <div class="titdiscos">
        	<p>Responsables</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,1,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>
			
		</div>        
        <div class="titdiscos">
        	<p>Staff</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,2,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>

		</div>
        
        <div class="titdiscos">
        	<p>Redactores</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,3,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>

		</div>        
        <div class="titdiscos">
        	<p>Colaboradores</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,4,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>
        </div>
        <?php 
        /* <div class="titdiscos">
        	<p>Antiguos colaboradores</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,5,2);
        $colaboradors_web->presentar_colaboradors_no_actius()
        ?>

		</div> */
        ?>
		
<?php	
	} else {
?>

    
    	<div class="titdiscos"> <!-- Titol de discos -->
        	<p>Sobre Satan Arise...</p>
        </div>
        
        <h1>
        	Satan Arise es un portal que vol donar a conèixer novetats sobre bandes de metal sense enllaços de descàrrega que no siguin consentits i pactats amb les bandes. Especialmente als grups joves se'ls dona la oportunitat de presentar el seu disc o maqueta, fer una petita entrevista i fins i tot arribar a tenir banners publicitaris de franc.
        </h1>
        <h1><span class="vermell">Crítiques:</span> Si vols contactar amb Satan Arise per fer-nos arribar un disc per que el revisem posa't en contacte amb nosaltres enviant un mail a <a class="linkk" href="mailto:info@satanarise.com">info@satanarise.com</a>.</h1>
        <h1><span class="vermell">Concerts:</span> Si vols comunicar-nos la celebració d'un concert per que surti a la nostra secció de concerts recomanats, envians el cartell y la informació a <a class="linkk" href="mailto:info@satanarise.com">info@satanarise.com</a>. Degut a la gran quantitat de concerts i bandes existents es impossible seguir tots els concerts que es realitzen, es per això que ens heu de fer arribar el cartell i la informació per poguer-ho publicar.</h1>
        <h1><span class="vermell">Noticies:</span> Per enviar-nos noticies que penseu que es poden publicar a Satan Arise podeu fer-les arribar a traves de <a class="linkk" href="mailto:news@satanarise.com">news@satanarise.com</a>.</h1>
        
        <div class="titdiscos">
        	<p>Responsables</p>
        </div>
        <div class="contenedorpersonal">
		<?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,1,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>
		</div>        
        <div class="titdiscos">
        	<p>Staff</p>
        </div>
        <div class="contenedorpersonal">
	    <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,2,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>
		</div>
        
        <div class="titdiscos">
        	<p>Redactores</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,3,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>
		</div>        
        <div class="titdiscos">
        	<p>Colaboradores</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,4,1);
        $colaboradors_web->presentar_colaboradors($colaborador,$page->leng)
        ?>            
		</div>
        <?php
        /*
        <div class="titdiscos">
        	<p>Antics col·laboradors</p>
        </div>
        <div class="contenedorpersonal">
        <?php
        $colaboradors_web->extreure_colaboradors($basedades->bd,$page->leng,5,2);
        $colaboradors_web->presentar_colaboradors_no_actius()
        ?>
		</div>
        */
        ?> 
		
        <?php	
	}
    
?>
		<div class="titdiscos">
        	<p>Links / Partners</p>
        </div>
        <div id="linkss">
        <a name="partners"></a>
            <div id="part_logos">
            		<a class="linkk" target="_blank" href="http://metaltrip.com"><img src="pics/partners/metaltrip.png" alt="Metal Trip" width = "600"/></a>
            		<a class="linkk" target="_blank" href="http://ondas-subversivas.blogspot.com.es"><img src="pics/partners/ondas.gif" alt="Ondas Subversivas" width = "600"/></a>
            		<a class="linkk" target="_blank" href="http://www.metalsymphony.com/"><img src="pics/partners/ms.jpg" alt="Metal Symphony" width = "600"/></a>
            		<a class="linkk" target="_blank" href="http://www.necromance.eu/"><img src="pics/partners/necromance.jpg" width = "250" alt="Necromance - Portal de Metal Extremo" /></a>
            		<a class="linkk" target="_blank" href="http://www.heavyrockschool.com/profesor-canto-gutural-metal-barcelona"><img src="pics/partners/hrs.png" alt="Daniel, profesor de canto gutural" width = "250" /></a>
        				<a class="linkk" target="_blank" href="https://www.facebook.com/associacio.vilavern.7"><img src="pics/partners/vilavern.jpg" alt="Vilavern" width = "200"/></a>
        				<a class="linkk" target="_blank" href="https://www.facebook.com/Solidary-Biker-910285272344644/?fref=ts"><img src="pics/partners/solidary.png" alt="Solidary Biker" width = "200"/></a>
        				<a class="linkk" target="_blank" href="https://www.facebook.com/Indomables-MC-434004126760800/"><img src="pics/partners/indomables.jpg" alt="Indomables" width = "200"/></a>
        				<a class="linkk" target="_blank" href="http://www.mujerycancer.org"><img src="pics/partners/amac.jpg" alt="AMAC" width = "200"/></a>
						</div>    
        </div>
<div class="banner_main"> <!-- Banner principal 700 x 100-->
<?php
    	//require('templates/banners/banner_main.php');
		$banner->visualitzar();
?>
    	</div>