<div id="propers_concerts_index">
<?php
	$basedades->conectar();
	if (!$basedades->error_conexio) 
	{ 

		$concerts->extreure_concerts_per_data_concert($basedades->__get('bd'),1,12,'xxx');
		$concerts->mostrar_resultats_per_data_concert_index($basedades->__get('bd'),$page); 
				
	}
	$basedades->desconectar();
?>
</div>