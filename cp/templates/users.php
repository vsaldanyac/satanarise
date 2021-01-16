<div id="columna_central">

<?php

	require('../sources/ob_cp_users.php');
	require('../sources/ob_users.php');
	$user_add=new cp_users;
	$user = new ob_users;
	switch ($page->action) {
		case 'main':
?>
			<p class="titol_parcial">Usuarios registrados</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$user_add->consulta_noticies($basedades->bd,$page->punter,$page->num_a_mostrar);
					$user_add->presentar_noticies_formulari($basedades->bd,'edit_del',$user);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir usuario</p>
<?php
			
			if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
				if (!$user_add->recull_parametres($_POST, $user)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
				{
					print '<p class="terminal">'.$user_add->error.'</p>';
				}
			} else {
				$user->reset_users($user); /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$user_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				
				$user_add->formulari ($user);
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$user_add->introduir($basedades->bd,$user,FALSE);
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
					$user_add->consulta_noticies($basedades->bd,$page->punter,$page->num_a_mostrar);
					$user_add->presentar_noticies_formulari($basedades->bd,'editar',$user);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					if (!$user_add->recull_parametres($_POST,$user)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
					{
						print '<p class="terminal">'.$user_add->error.'</p>';
							
										
					} else {
						print '<p class="terminal">Error al recollir el formulari de edició</p>';
						
					}
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$user->id=$page->id;
						$user_add->extreu_dades_noticia_per_id($basedades->bd,$user);
						print '<p class="terminal">Dades en principi extretes de la bbdd</p>';
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$user_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$user_add->formulari ($user);
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						 /* Introduir a bbdd  */
						$user_add->introduir($basedades->bd,$user,TRUE);
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
					$user_add->consulta_noticies($basedades->bd,$page->punter,$page->num_a_mostrar);
					$user_add->presentar_noticies_formulari($basedades->bd,'del',$user);
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
					$user_add->eliminar_registre($basedades->bd,$page->id,TRUE);					
					$basedades->desconectar();
					
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
		break;				
	}
?>
</div>