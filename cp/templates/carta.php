<div id="columna_central">
xxx
<?php

	require('../sources/ob_cp_carta.php');
    require('../sources/ob_carta.php');
	$carta_add=new ob_cp_carta;
    $carta=new ob_carta;
    require ('../sources/basic_functions.php');
	switch ($page->action) {

		case 'main':
?>
			<p class="titol_parcial">Cartas actuales</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$carta_add->consulta_carta($basedades->bd,$page->punter,$page->num_a_mostrar,$carta);
					$carta_add->presentar_carta_formulari($basedades->bd,'edit_del',$carta);
					$carta_add->navegador_entrades($basedades->contar_entrades('carta'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir carta</p>
<?php
			
			if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
				$basedades->conectar();
                if (!$carta_add->recull_parametres($_POST, $carta,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
				{
				    print '<p class="terminal">'.$carta_add->error.'</p>';
									
				}
                $basedades->desconectar();
				
				
			} else {
				$carta->reset_carta();; /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$carta_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				$basedades->conectar();
				$carta_add->formulari ($carta,$basedades->bd);
                $basedades->desconectar();
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$carta_add->introduir($basedades->bd,$carta,FALSE,FALSE);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
	
		break;
		case 'edit':
?>		
			<p class="titol_parcial">Elije la carta a editar</p>			
<?php            
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$carta_add->consulta_carta($basedades->bd,$page->punter,$page->num_a_mostrar);
					$carta_add->presentar_carta_formulari($basedades->bd,'editar',$entrevista);
					$carta_add->navegador_entrades($basedades->contar_entrades('carta'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					$basedades->conectar();
                    if (!$carta_add->recull_parametres($_POST, $carta,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
                    {
				        print '<p class="terminal">'.$entrevista_add->error.'</p>';							
	       			}
                    $basedades->desconectar();
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$carta_add->extreu_dades_carta_per_id($basedades->bd,$carta,$page->id);
						
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$carta_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$basedades->conectar();
				    $carta_add->formulari ($carta,$basedades->bd);
                    $basedades->desconectar();
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */						
						$carta_add->introduir($basedades->bd,$carta,TRUE,$carta->id);
						$basedades->desconectar();
						
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				
			
			}
		break;
		case 'del':
?>		
			<p class="titol_parcial">Elije la carta a eliminar</p>
<?php
	        if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$carta_add->consulta_carta($basedades->bd,$page->punter,$page->num_a_mostrar);
					$carta_add->presentar_carta_formulari($basedades->bd,'del',$carta);
					$carta_add->navegador_entrades($basedades->contar_entrades('carta'),$page->punter,$page->num_a_mostrar,$page->action);
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
					$carta_add->eliminar_registre($basedades->bd,$page->id);
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