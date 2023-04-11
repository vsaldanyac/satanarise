<div id="columna_central">
	<?php
	require('../sources/ob_cp_conciertos.php');
	require('../sources/ob_concerts.php');
	$cp_concert = new cp_propers_concerts();

	switch ($page->action) {
		case 'main':
			?>
			<p class="titol_parcial">Conciertos actuales</p>
			<?php
			$basedades->conectar();
			if (!$basedades->error_conexio) {
				print '<p class="terminal">Conexió OK!</p>';
				$cp_concert->presentar_concerts_formulari($basedades->bd, 'edit_del', $page->punter, $page->num_a_mostrar);
				$cp_concert->navegador_entrades($basedades->contar_entrades('concertsdata'), $page->punter, $page->num_a_mostrar, $page->action);
				$basedades->desconectar();
			} else {
				print '<p class="terminal">Error de conexión a la base de datos</p>';
			}


			break;
		case 'add':
			?>
			<p class="titol_parcial">Añadir Concierto / Gira / Festival</p>
			<?php
			if ($cp_concert->recull_parametres_formulari_2($_POST, $page->id)) /* s'ha enviat el formulari 2? */{
				/* El formulari 2 esta omplert i recollit, verificar dades i omplir bbdd o tornar a demanar formulari 2 en cas de dades incorrectes */
				if ($cp_concert->validar_entrada()) {
					/* Dades ben introduides */
					print '<p class="terminal">Formularis OK!</p>';
					$basedades->conectar();
					if (!$basedades->__get('error_conexio')) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */
						$cp_concert->introduir_concert($basedades->bd, FALSE, 0);
						$basedades->desconectar();
					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				} else {
					/* Dades mal introduides, torna a demanar el formulari */
					print '<p class="terminal">' . $cp_concert->__get('error') . '</p>';
					$cp_concert->formulari_2();
				}

			} else { /* No està omplert el formulari 2 */

				if ($cp_concert->recull_parametres_formulari_1($_POST, $page->id)) /* s'ha enviat el formulari 1? */{
					/* S'ha omplert formular 1, recollir dades i mostrar formulari 2 */
					$cp_concert->formulari_2(); /* Si no hi ha formular 2 ho genera formulari sense dades */



				} else {
					/* No s'ha omplert el fomulari 1, mostrar formular 1 */
					$cp_concert->formulari_1();
				}

			}

			break;
		case 'edit':
			?>
			<p class="titol_parcial">Elije el concierto a editar</p>
			<?php
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */

				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$cp_concert->presentar_concerts_formulari($basedades->__get('bd'), 'editar', $page->punter, $page->num_a_mostrar);
					$cp_concert->navegador_entrades($basedades->contar_entrades('concertsdata'), $page->punter, $page->num_a_mostrar, $page->action);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				/* S'ha enviat el formilari  */
				if ($cp_concert->recull_parametres_formulari_2($_POST, $page->id)) { /* s'ha enviat el formulari 2 */
					if ($cp_concert->validar_entrada()) {
						/* Dades ben introduides */
						print '<p class="terminal">Formularis OK!</p>';
						/* Introduir dades de nou despres d'eliminar els registres vells*/
						$basedades->conectar();
						if (!$basedades->error_conexio) {
							$cp_concert->introduir_concert($basedades->__get('bd'), TRUE, $page->__get('id'));
						} else {
							print '<p class="terminal">Error de conexión a la base de datos</p>';
						}

					} else {
						/* AQUI */print '<p class="terminal">' . $cp_concert->__get('error') . '</p>';
						$cp_concert->formulari_2();
					}

				} else {

					/* no hi ha una noticia editada enviada pel formulari, tenim la id de la noticia a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$cp_concert->extreu_dades_concert_per_id($basedades->__get('bd'), $page->id);
						print '<p class="terminal">Dades en principi extretes de la bbdd</p>';
						$basedades->desconectar();
						/* Una vegada extretes les dades correctament es presenta el formulari 2 */
						$cp_concert->formulari_2();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}



			}
			break;
		case 'del':
			?>
			<p class="titol_parcial">Elije el concierto a eliminar</p>
			<?php
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra noticies existents a la bbdd  */

				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$cp_concert->presentar_concerts_formulari($basedades->bd, 'del', $page->punter, $page->num_a_mostrar);
					$cp_concert->navegador_entrades($basedades->contar_entrades('concertsdata'), $page->punter, $page->num_a_mostrar, $page->action);
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
					$cp_concert->eliminar_registre($basedades->bd, $page->id);
					print '<p class="terminal">Registro Eliminado</p>';
					$basedades->desconectar();

				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
			break;
		case 'borrar_fora_de_data':
			?>
			<p class="titol_parcial">Eliminar conciertos pasados</p>
			<p class="contingut">Este proceso eliminará todos los conciertos de fechas anteriores a la actual<br />
				¿Está seguro que proceder?</p>
			<p class="terminal">Botó de formulari i esborrar fins a dara actual</p>
			<?php
			break;
	}
	?>
</div>