

	<div id="socials_2">
        	<a target="_blank" href="http://www.youtube.com/satanarisemetal" title="Canal de Youtube de Satan Arise"><img src="pics/social_youtube.png" width="25" height="25" alt="Canal de Youtube de Satan Arise" /></a>
            <a target="_blank" href="http://twitter.com/SatanArise" title="Satan Arise Twitter"><img src="pics/social_twitter.png" width="25" height="25" alt="Satan Arise Twitter" /></a>
            <a target="_blank" href="http://www.facebook.com/Satanarisemetal" title="Satan Arise Facebook"><img src="pics/social_facebook.png" width="25" height="25" alt="Satan Arise Facebook" /></a>
    </div>		
    <br />
<?php
	$basedades->conectar();
	if (!$basedades->error_conexio) 
	{ 

		$concerts->extreure_banner_lateral_concerts($basedades->__get('bd'),1,20,'xxx');
		$concerts->mostrar_resultats_per_banner_lateral_concerts($basedades->__get('bd'),$page); 
				
	}
	$basedades->desconectar();


?>
