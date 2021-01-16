<div id="columna_central">

<?php

	require('../sources/ob_cp_colaboradors.php');
	require('../sources/ob_colaboradors.php');
	$colaborador_add=new cp_colaboradors;
	$colaborador = new ob_colaboradors;
	switch ($page->action) {
		case 'main':
?>
			<p class="titol_parcial">Colaboradores</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$colaborador_add->consulta_colaboradors($basedades->bd);
					$colaborador_add->presentar_colaboradors_formulari($basedades->bd,'edit_del',$colaborador);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir Colaborador</p>
<?php
			
			if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
				if (!$colaborador_add->recull_parametres($_POST, $colaborador)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
				{
					print '<p class="terminal">'.$colaborador_add->error.'</p>';
				}
			} else {
				$colaborador->reset_colaboradors($colaborador); /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$colaborador_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				
				$colaborador_add->formulari ($colaborador);
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$colaborador_add->introduir($basedades->bd,$colaborador,FALSE);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
	
		break;
		case 'edit':
?>		
			<p class="titol_parcial">Elije la noticia a editar</p>			
<?php            
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$colaborador_add->consulta_colaboradors($basedades->bd,$page->punter,$page->num_a_mostrar);
					$colaborador_add->presentar_colaboradors_formulari($basedades->bd,'editar',$colaborador);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					if (!$colaborador_add->recull_parametres($_POST,$colaborador)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
					{
						print '<p class="terminal">'.$colaborador_add->error.'</p>';
							
										
					} else {
						print '<p class="terminal">Error al recollir el formulari de edició</p>';
						
					}
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$colaborador->id=$page->id;
						$colaborador_add->extreu_dades_colaborador_per_id($basedades->bd,$colaborador);
						print '<p class="terminal">Dades en principi extretes de la bbdd</p>';
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$colaborador_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$colaborador_add->formulari ($colaborador);
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						 /* Introduir a bbdd  */
						$colaborador_add->introduir($basedades->bd,$colaborador,TRUE);
						$basedades->desconectar();
						
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				
			
			}
		break;
		case 'del':
?>		
			<p class="titol_parcial">Elije la noticia a eliminar</p>
<?php
	        if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$colaborador_add->consulta_noticies($basedades->bd,$page->punter,$page->num_a_mostrar);
					$colaborador_add->presentar_noticies_formulari($basedades->bd,'del',$colaborador);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
			print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$colaborador_add->eliminar_registre($basedades->bd,$page->id,TRUE);					
					$basedades->desconectar();
					
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
		break;				
	}
?>
</div>