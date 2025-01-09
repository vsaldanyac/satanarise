<div id="columna_central">

<?php

	require('../sources/ob_cp_opinio.php');
    require('../sources/ob_opinio.php');
	$opinio_add=new ob_cp_opinio;
    $opinio=new ob_opinio;
    require ('../sources/basic_functions.php');
	switch ($page->action) {

		case 'main':
?>
			<p class="titol_parcial">Metal Reports</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$opinio_add->consulta_opinio($basedades->bd,$page->punter,$page->num_a_mostrar,$opinio);
					$opinio_add->presentar_opinio_formulari($basedades->bd,'edit_del',$opinio);
					$opinio_add->navegador_entrades($basedades->contar_entrades('opinio'),$page->punter,$page->num_a_mostrar,$page->action);                    
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir artículo</p>
<?php
			
			if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
				$basedades->conectar();
                if (!$opinio_add->recull_parametres($_POST, $opinio,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
				{
				    print '<p class="terminal">'.$opinio_add->error.'</p>';
									
				}
                $basedades->desconectar();
				
				
			} else {
				$opinio->reset_opinio();; /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$opinio_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				$basedades->conectar();
				$opinio_add->formulari ($opinio,$basedades->bd);
                $basedades->desconectar();
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$opinio_add->introduir($basedades->bd,$opinio,FALSE,FALSE);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
	
		break;
		case 'edit':
?>		
			<p class="titol_parcial">Elije el artículo a editar</p>			
<?php            
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$opinio_add->consulta_opinio($basedades->bd,$page->punter,$page->num_a_mostrar);
					$opinio_add->presentar_opinio_formulari($basedades->bd,'editar',$opinio);
					$opinio_add->navegador_entrades($basedades->contar_entrades('opinio'),$page->punter,$page->num_a_mostrar,$page->action);                    
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					$basedades->conectar();
                    if (!$opinio_add->recull_parametres($_POST, $opinio,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
                    {
				        print '<p class="terminal">'.$opinio_add->error.'</p>';							
	       			}
                    $basedades->desconectar();
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$opinio_add->extreu_dades_opinio_per_id($basedades->bd,$opinio,$page->id);
						
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$opinio_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$basedades->conectar();
				    $opinio_add->formulari ($opinio,$basedades->bd);
                    $basedades->desconectar();
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */						
						$opinio_add->introduir($basedades->bd,$opinio,TRUE,$opinio->id);
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
					$opinio_add->consulta_opinio($basedades->bd,$page->punter,$page->num_a_mostrar);
					$opinio_add->presentar_opinio_formulari($basedades->bd,'del',$opinio);
					$opinio_add->navegador_entrades($basedades->contar_entrades('opinio'),$page->punter,$page->num_a_mostrar,$page->action);
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
					$opinio_add->eliminar_registre($basedades->bd,$page->id);
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