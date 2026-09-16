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
				if ($review_add->needs_dim_confirm) {
					?>
					<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
						<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
							<p style="font-size:15px;margin-bottom:25px;line-height:1.5;">La dimensión de esta imagen está por debajo de lo recomendado para su correcta visualización. ¿Quieres continuar?</p>
							<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_review').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
							<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
						</div>
					</div>
					<?php
				}
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
					if ($review_add->needs_dim_confirm) {
						?>
						<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
							<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
								<p style="font-size:15px;margin-bottom:25px;line-height:1.5;">La dimensión de esta imagen está por debajo de lo recomendado para su correcta visualización. ¿Quieres continuar?</p>
								<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_review').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
								<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
							</div>
						</div>
						<?php
					}
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