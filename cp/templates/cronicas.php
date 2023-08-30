<div id="columna_central">

	<?php

	require('../sources/ob_cp_cronicas.php');
	require('../sources/ob_cronicas.php');
	$cronicas_add = new ob_cp_cronicas;
	$cronicas = new ob_cronicas;
	require('../sources/basic_functions.php');
	switch ($page->action) {
		case 'main':
			?>
			<p class="titol_parcial">Crónicas actuales</p>

			<?php
			$basedades->conectar();
			if (!$basedades->error_conexio) {
				print '<p class="terminal">Conexió OK!</p>';
				$cronicas_add->consulta_cronicas($basedades->bd, $page->punter, $page->num_a_mostrar, $cronicas);
				$cronicas_add->presentar_cronicas_formulari($basedades->bd, 'edit_del', $cronicas);
				$cronicas_add->navegador_entrades($basedades->contar_entrades('cronicas'), $page->punter, $page->num_a_mostrar, $page->action);
				$basedades->desconectar();
			} else {
				print '<p class="terminal">Error de conexión a la base de datos</p>';
			}


			break;
		case 'add':

			?>
			<p class="titol_parcial">Añadir crónica</p>
			<?php
			$cronicas->reset_cronicas(); /* no esta enviat o no es correcte, es posa tot a 0 */

			if (isset($_POST['enviat_formulari_2'])) { /* s'ha enviat rl formulari 2 ? */
				$basedades->conectar();
				if (!$cronicas_add->recull_parametres_formulari_2($_POST, $cronicas)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */{
					print '<p class="terminal">' . $cronicas_add->error . '</p>';
					$cronicas_add->formulari_2($cronicas, $basedades->bd);

				} else {
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						/* Introduir a bbdd  */
						$cronicas_add->introduir($basedades->bd, $cronicas, FALSE, FALSE);

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				$basedades->desconectar();


			} else {
				if (isset($_POST['enviat_formulari_1'])) {
					if ($cronicas_add->recull_parametres_formulari_1($_POST, $cronicas)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */{
						$basedades->conectar();
						$cronicas_add->formulari_2($cronicas, $basedades->bd);
						$basedades->desconectar();
					}

				} else {
					$cronicas_add->formulari_1();
				}
			}


			break;
		case 'edit':
			?>
			<p class="titol_parcial">Elije la review a editar</p>
			<?php
			if (!$page->formulari) { /* si no hi ha selecció d'edició mostra cróniques existents a la bbdd  */

				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$cronicas_add->consulta_cronicas($basedades->bd, $page->punter, $page->num_a_mostrar);
					$cronicas_add->presentar_cronicas_formulari($basedades->bd, 'editar', $cronicas);
					$cronicas_add->navegador_entrades($basedades->contar_entrades('cronicas'), $page->punter, $page->num_a_mostrar, $page->action);
					$basedades->desconectar();
				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			} else {
				if (isset($_POST['enviat_formulari_2'])) { /* s'ha enviat el formulari? */
					$basedades->conectar();
					if (!$cronicas_add->recull_parametres_formulari_2($_POST, $cronicas, $basedades->bd)) /* en principi si, comprobació i recull de dades Si TRUE les tracta en busca d'errors */{
						print '<p class="terminal">' . $cronicas_add->error . '</p>';
					}
					$basedades->desconectar();

				} else {

					/* no hi ha una crónica editada enviada pel formulari, tenim la id de la crónica a editar, extracció de la bbdd i crida al formulari per editar-la */
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						$cronicas_add->extreu_dades_cronicas_per_id($basedades->bd, $cronicas, $page->id);
						print '<p class="terminal">Dades en principi extretes de la bbdd per a ID: ' . $cronicas->id . '</p>';
						$basedades->desconectar();

					} else {
						print '<p class="terminal">Error de conexión a la base de datos</p>';
					}
				}
				if (!$cronicas_add->formulari_2_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
					print '<p class="terminal">Formulari 2 Num div: ' . $cronicas->num_div . '</p>';
					$basedades->conectar();
					print '<p class="terminal">formulari 2 ID -->' . $cronicas->id . '</p>';
					$cronicas_add->formulari_2($cronicas, $basedades->bd);
					$basedades->desconectar();

				} else {
					print '<p class="terminal">Formulari OK</p>';
					$basedades->conectar();
					if (!$basedades->error_conexio) {
						print '<p class="terminal">Conexió OK!</p>';
						print '<p class="terminal">ID -->' . $cronicas->id . '</p>';
						print '<p class="terminal">TITOL -->' . $cronicas->titol . '</p>';
						/* Introduir a bbdd  */
						$cronicas_add->introduir($basedades->bd, $cronicas, TRUE, $page->id);
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
					$cronicas_add->consulta_reviews($basedades->bd, $page->punter, $page->num_a_mostrar);
					$cronicas_add->presentar_reviews_formulari($basedades->bd, 'del', $cronicas);
					$cronicas_add->navegador_entrades($basedades->contar_entrades('news'), $page->punter, $page->num_a_mostrar, $page->action);
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
					$cronicas_add->eliminar_registre($basedades->bd, $page->id);
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