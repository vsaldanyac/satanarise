<div id="columna_central">

<?php

	require('../sources/ob_cp_noticias.php');
	$noticia_add=new cp_noticia;
	switch ($page->action) {
		case 'main':
?>
			<p class="titol_parcial">Noticias actuales</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$noticia_add->consulta_noticies($basedades->bd,$page->punter,$page->num_a_mostrar);
					$noticia_add->presentar_noticies_formulari($basedades->bd,'edit_del');
					$noticia_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir noticia</p>
<?php
			
			if (isset($_POST['enviat'])) { /* s'ha enviat rl formulari? */
				if ($noticia_add->recull_parametres($_POST)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
				{
					if (!$noticia_add->validar_entrada($page)) 
					{
						print '<p class="terminal">'.$noticia_add->error.'</p>';
					}
					
				} else {
					$noticia_add->inicialitzar_noticia(); /* no esta enviat o no es correcte, es posa tot a 0 */
				}
				
				
			} else {
				$noticia_add->inicialitzar_noticia(); /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$noticia_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				
				$noticia_add->formulari ();
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$noticia_add->introduir($basedades->bd,FALSE,FALSE);
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
					$noticia_add->consulta_noticies($basedades->bd,$page->punter,$page->num_a_mostrar);
					$noticia_add->presentar_noticies_formulari($basedades->bd,'editar');
					$noticia_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					if ($noticia_add->recull_parametres($_POST)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
					{
						if (!$noticia_add->validar_entrada($page)) 
						{
							print '<p class="terminal">'.$noticia_add->error.'</p>';
							
						}
						
					} else {
						print '<p class="terminal">Error al recollir el formulari de edició</p>';
						
					}
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$noticia_add->extreu_dades_noticia_per_id($basedades->bd,$page->id);
						print '<p class="terminal">Dades en principi extretes de la bbdd</p>';
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$noticia_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$noticia_add->formulari ();
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */
						$noticia_add->eliminar_registre($basedades->bd,$page->id);
						$noticia_add->introduir($basedades->bd,TRUE,$page->id);
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
					$noticia_add->consulta_noticies($basedades->bd,$page->punter,$page->num_a_mostrar);
					$noticia_add->presentar_noticies_formulari($basedades->bd,'del');
					$noticia_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
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
					$noticia_add->eliminar_registre($basedades->bd,$page->id);
					print '<p class="terminal">Registro Eliminado</p>';
					$basedades->desconectar();
					
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
		break;				
	}
?>
</div>