<div id="socials_2">
	<!-- ShareThis BEGIN -->
	<div class="sharethis-inline-follow-buttons"></div>
	<!-- ShareThis END -->
</div>
<br />
<?php
$basedades->conectar();
if (!$basedades->error_conexio) {

	$concerts->extreure_banner_lateral_concerts($basedades->__get('bd'), 1, 20, 'xxx');
	$concerts->mostrar_resultats_per_banner_lateral_concerts($basedades->__get('bd'), $page);

}
$basedades->desconectar();


?>