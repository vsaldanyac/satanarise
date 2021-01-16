<div id="columna_central">

<?php

	require('../sources/ob_cp_reviews.php');
    require('../sources/ob_reviews.php');
	$review_add=new ob_cp_reviews;
    $review=new ob_reviews;
    require ('../sources/basic_functions.php');
	switch ($page->action) {
		case 'main':
?>
			<p class="titol_parcial">Reviews actuales</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$review_add->consulta_reviews($basedades->bd,$page->punter,$page->num_a_mostrar,$review);
					$review_add->presentar_reviews_formulari($basedades->bd,'edit_del',$review);
					$review_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir reviews</p>
<?php
			
			if (isset($_POST['enviat'])) { /* s'ha enviat rl formulari? */
				$basedades->conectar();
                if (!$review_add->recull_parametres($_POST, $review,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
				{
				    print '<p class="terminal">'.$review_add->error.'</p>';
									
				}
                $basedades->desconectar();
				
				
			} else {
				$review->reset_reviews();; /* no esta enviat o no es correcte, es posa tot a 0 */
			}
			if (!$review_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				$basedades->conectar();
				$review_add->formulari ($review,$basedades->bd);
                $basedades->desconectar();
			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$review_add->introduir($basedades->bd,$review,FALSE,FALSE);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
	
		break;
		case 'edit':
?>		
			<p class="titol_parcial">Elije la review a editar</p>			
<?php            
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$review_add->consulta_reviews($basedades->bd,$page->punter,$page->num_a_mostrar);
					$review_add->presentar_reviews_formulari($basedades->bd,'editar',$review);
					$review_add->navegador_entrades($basedades->contar_entrades('reviews'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					$basedades->conectar();
                    if (!$review_add->recull_parametres($_POST, $review,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
                    {
				        print '<p class="terminal">'.$review_add->error.'</p>';							
	       			}
                    $basedades->desconectar();
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$review_add->extreu_dades_reviews_per_id($basedades->bd,$review,$page->id);
						
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$review_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$basedades->conectar();
				    $review_add->formulari ($review,$basedades->bd);
                    $basedades->desconectar();
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */						
						$review_add->introduir($basedades->bd,$review,TRUE,$review->id);
						$basedades->desconectar();
						
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				
			
			}
		break;
		case 'del':
?>		
			<p class="titol_parcial">Elije la review a eliminar</p>
<?php
	        if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$review_add->consulta_reviews($basedades->bd,$page->punter,$page->num_a_mostrar);
					$review_add->presentar_reviews_formulari($basedades->bd,'del',$review);
					$review_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
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
					$review_add->eliminar_registre($basedades->bd,$page->id);
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