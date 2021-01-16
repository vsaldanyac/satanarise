<div id="columna_central">

<?php

	require('../sources/ob_cp_cronicas.php');
    require('../sources/ob_cronicas.php');
	$cronicas_add=new ob_cp_cronicas;
    $cronicas=new ob_cronicas;
    require ('../sources/basic_functions.php');
	switch ($page->action) {
		case 'main':
?>
			<p class="titol_parcial">Crónicas actuales</p>
         
<?php			
			$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$cronicas_add->consulta_reviews($basedades->bd,$page->punter,$page->num_a_mostrar,$cronicas);
					$cronicas_add->presentar_reviews_formulari($basedades->bd,'edit_del',$cronicas);
					$cronicas_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			
			
		break;
		case 'add':
		
?>			
            <p class="titol_parcial">Añadir crónica</p>
<?php
			$basedades->conectar();
			if ($cronicas_add->recull_parametres_formulari_2($_POST,$page->id)) /* s'ha enviat el formulari 2? */
			{
				/* El formulari 2 esta omplert i recollit, verificar dades i omplir bbdd o tornar a demanar formulari 2 en cas de dades incorrectes */
				if ($cronicas_add->validar_entrada())
				{
					/* Dades ben introduides */
					print '<p class="terminal">Formularis OK!</p>';
					$basedades->conectar();
					if (!$basedades->__get('error_conexio')) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */
						$cronicas_add->introduir_concert($basedades->bd,FALSE,0);
						$basedades->desconectar();
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				} else  {
					/* Dades mal introduides, torna a demanar el formulari */
					print '<p class="terminal">'.$cronicas_add->__get('error').'</p>';
					$cronicas_add->formulari_2($cronicas,$basedades->bd);
				}
			
			} else { /* No està omplert el formulari 2 */
			
				if ($cronicas_add->recull_parametres_formulari_1($_POST,$cronicas)) /* s'ha enviat el formulari 1? */
				{
					/* S'ha omplert formular 1, recollir dades i mostrar formulari 2 */				 
                    $cronicas_add->formulari_2($cronicas,$basedades->bd); /* Si no hi ha formular 2 ho genera formulari sense dades */
					
					
					
				} else {
					/* No s'ha omplert el fomulari 1, mostrar formular 1 */
					
                    $cronicas_add->formulari_1($cronicas,$basedades->bd);
                    
				}
				
			}
            $basedades->desconectar();
	
		break;
		case 'edit':
?>		
			<p class="titol_parcial">Elije la review a editar</p>			
<?php            
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */
					
				$basedades->conectar();
				if (!$basedades->error_conexio) { 
					print '<p class="terminal">Conexió OK!</p>';
					$cronicas_add->consulta_reviews($basedades->bd,$page->punter,$page->num_a_mostrar);
					$cronicas_add->presentar_reviews_formulari($basedades->bd,'editar',$cronicas);
					$cronicas_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
					$basedades->desconectar();
				} else { 
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
					$basedades->conectar();
                    if (!$cronicas_add->recull_parametres($_POST, $cronicas,$basedades->bd)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */
                    {
				        print '<p class="terminal">'.$cronicas_add->error.'</p>';							
	       			}
                    $basedades->desconectar();
					
				} else {
				
					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$cronicas_add->extreu_dades_reviews_per_id($basedades->bd,$cronicas,$page->id);
						
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$cronicas_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */					
					$basedades->conectar();
				    $cronicas_add->formulari ($cronicas,$basedades->bd);
                    $basedades->desconectar();
					
				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */						
						$cronicas_add->introduir($basedades->bd,$cronicas,TRUE,$cronicas->id);
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
					$cronicas_add->consulta_reviews($basedades->bd,$page->punter,$page->num_a_mostrar);
					$cronicas_add->presentar_reviews_formulari($basedades->bd,'del',$cronicas);
					$cronicas_add->navegador_entrades($basedades->contar_entrades('news'),$page->punter,$page->num_a_mostrar,$page->action);
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
					$cronicas_add->eliminar_registre($basedades->bd,$page->id);
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