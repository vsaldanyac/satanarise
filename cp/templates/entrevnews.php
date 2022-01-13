<div id="columna_central">

<?php

	require('../sources/ob_cp_entrevnews.php');
    require('../sources/ob_entrevnews.php');
	$entrevista_add=new ob_cp_entrevnews;
    $entrevista=new ob_entrevnews;
    require ('../sources/basic_functions.php');
	switch ($page->action) {
		case 'main':
?>
			<p class="titol_parcial">Entrevistes actuales</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$entrevista_add->consulta_entrevistes($basedades->bd,$page->punter,$page->num_a_mostrar,$entrevista);
					$entrevista_add->presentar_entrevistes_formulari($basedades->bd,'edit_del',$entrevista);
					$entrevista_add->navegador_entrades($basedades->contar_entrades('entrevnews'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir entrevistes</p>
<?php
			
			if (isset($_POST['enviat'])) { /* s'ha enviat rl formulari? */
				$basedades->conectar();
                if (!$entrevista_add->recull_parametres($_POST, $entrevista,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
				{
				    print '<p class="terminal">'.$entrevista_add->error.'</p>';
									
				}
                $basedades->desconectar();
				
				
			} else {
				$entrevista->reset_entrevistes();; /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$entrevista_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				$basedades->conectar();
				$entrevista_add->formulari ($entrevista,$basedades->bd);
                $basedades->desconectar();
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$entrevista_add->introduir($basedades->bd,$entrevista,FALSE,FALSE);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
	
		break;
		case 'edit':
?>		
			<p class="titol_parcial">Elije la entrevista a editar</p>			
<?php            
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$entrevista_add->consulta_entrevistes($basedades->bd,$page->punter,$page->num_a_mostrar);
					$entrevista_add->presentar_entrevistes_formulari($basedades->bd,'editar',$entrevista);
					$entrevista_add->navegador_entrades($basedades->contar_entrades('entrevnews'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					$basedades->conectar();
                    if (!$entrevista_add->recull_parametres($_POST, $entrevista,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
                    {
				        print '<p class="terminal">'.$entrevista_add->error.'</p>';							
	       			}
                    $basedades->desconectar();
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$entrevista_add->extreu_dades_entrevistes_per_id($basedades->bd,$entrevista,$page->id);
						
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$entrevista_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$basedades->conectar();
				    $entrevista_add->formulari ($entrevista,$basedades->bd);
                    $basedades->desconectar();
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */						
						$entrevista_add->introduir($basedades->bd,$entrevista,TRUE,$entrevista->id);
						$basedades->desconectar();
						
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				
			
			}
		break;
		case 'del':
?>		
			<p class="titol_parcial">Elije la entrevista a eliminar</p>
<?php
	        if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$entrevista_add->consulta_entrevistes($basedades->bd,$page->punter,$page->num_a_mostrar);
					$entrevista_add->presentar_entrevistes_formulari($basedades->bd,'del',$entrevista);
					$entrevista_add->navegador_entrades($basedades->contar_entrades('entrevnews'),$page->punter,$page->num_a_mostrar,$page->action);
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
					$entrevista_add->eliminar_registre($basedades->bd,$page->id);
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