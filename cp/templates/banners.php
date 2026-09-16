<div id="columna_central">

<?php

require('../sources/ob_cp_banners.php');
$banner_add = new cp_banner;
switch ($page->action) {

	case 'main':
		?>
		<p class="titol_parcial">Banners actuales</p>

		<?php
		$basedades->conectar();
		if (!$basedades->error_conexio) {
			print '<p class="terminal">Conexió OK!</p>';
			$banner_add->consulta_banners($basedades->bd, $page->punter, $page->num_a_mostrar);
			$banner_add->presentar_banners_formulari($basedades->bd, 'editar');
			$banner_add->navegador_entrades($basedades->contar_entrades('banners'), $page->punter, $page->num_a_mostrar, $page->action);
			$basedades->desconectar();
		} else {
			print '<p class="terminal">Error de conexión a la base de datos</p>';
		}

		break;
	case 'add':

		?>
		<p class="titol_parcial">Añadir banner</p>
		<?php

		if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
			if ($banner_add->recull_parametres($_POST)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */{
				if (!$banner_add->validar_entrada()) {
					print '<p class="terminal">' . $banner_add->error . '</p>';
				}

			} else {
				if (!$banner_add->needs_dim_confirm) {
					$banner_add->inicialitzar_banner(); /* no esta enviat o no es correcte, es posa tot a 0 */
				}
			}

		} else {
			$banner_add->inicialitzar_banner(); /* no esta enviat o no es correcte, es posa tot a 0 */
		}
		if (!$banner_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */

			if ($banner_add->needs_dim_confirm) { ?>
				<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
					<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
						<p style="font-size:15px;margin-bottom:25px;line-height:1.5;"><?php echo implode('<br />', $banner_add->warn_small_dims); ?><br />¿Quieres continuar de todos modos?</p>
						<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_banner').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
						<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
					</div>
				</div>
			<?php }
			$banner_add->formulari();
		} else {
			print '<p class="terminal">Formulari OK</p>';
			$basedades->conectar();
			if (!$basedades->error_conexio) {
				print '<p class="terminal">Conexió OK!</p>';
				/* Introduir a bbdd  */
				$banner_add->introduir($basedades->bd, FALSE, FALSE);
				$basedades->desconectar();
			} else {
				print '<p class="terminal">Error de conexión a la base de datos</p>';
			}
		}

		break;
	case 'edit':
		?>
		<p class="titol_parcial">Elije el banner a editar</p>
		<?php
		if (!$page->formulari) { /* si no hi ha selecció d'edició mostra banners existents a la bbdd  */

			$basedades->conectar();
			if (!$basedades->error_conexio) {
				print '<p class="terminal">Conexió OK!</p>';
				$banner_add->consulta_banners($basedades->bd, $page->punter, $page->num_a_mostrar);
				$banner_add->presentar_banners_formulari($basedades->bd, 'editar');
				$banner_add->navegador_entrades($basedades->contar_entrades('banners'), $page->punter, $page->num_a_mostrar, $page->action);
				$basedades->desconectar();
			} else {
				print '<p class="terminal">Error de conexión a la base de datos</p>';
			}
		} else {
			if (isset($_POST['enviat'])) { /* s'ha enviat el formulari? */
				if ($banner_add->recull_parametres($_POST)) /* en principi si, comrobació i recull de dades Si TRUE les tracta en busca d'errors */{
					if (!$banner_add->validar_entrada()) {
						print '<p class="terminal">' . $banner_add->error . '</p>';
					}

				} else {
					print '<p class="terminal">' . $banner_add->error . '</p>';
				}

			} else {

				/* no hi ha un banner editat enviat pel formulari, tenim la id del banner a editar, extracció de la bbdd i crida al formulari per editar-lo */
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					$banner_add->extreu_dades_banner_per_id($basedades->bd, $page->id);
					print '<p class="terminal">Dades en principi extretes de la bbdd</p>';
					$basedades->desconectar();

				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}
			if (!$banner_add->formulari_ok) { /* si el formulari no s'ha omplert o no esta tot correcte el torna a posar */
				if ($banner_add->needs_dim_confirm) { ?>
					<div id="modal_dim_warning" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:9999;display:flex;align-items:center;justify-content:center;">
						<div style="background:#2a2a2a;color:#fff;padding:35px 40px;border-radius:8px;max-width:480px;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.5);">
							<p style="font-size:15px;margin-bottom:25px;line-height:1.5;"><?php echo implode('<br />', $banner_add->warn_small_dims); ?><br />¿Quieres continuar de todos modos?</p>
							<button onclick="document.getElementById('confirm_small_img').value='si';document.getElementById('form_banner').submit();" style="margin-right:12px;padding:10px 24px;cursor:pointer;background:#5a8a5a;color:#fff;border:none;border-radius:4px;font-size:14px;">Sí</button>
							<button onclick="document.getElementById('modal_dim_warning').style.display='none';" style="padding:10px 24px;cursor:pointer;background:#666;color:#fff;border:none;border-radius:4px;font-size:14px;">No</button>
						</div>
					</div>
				<?php }
				$banner_add->formulari();

			} else {
				print '<p class="terminal">Formulari OK</p>';
				$basedades->conectar();
				if (!$basedades->error_conexio) {
					print '<p class="terminal">Conexió OK!</p>';
					/* Introduir a bbdd  */
					$banner_add->introduir($basedades->bd, TRUE, $page->id);
					$basedades->desconectar();

				} else {
					print '<p class="terminal">Error de conexión a la base de datos</p>';
				}
			}

		}
		break;
}
?>
</div>
